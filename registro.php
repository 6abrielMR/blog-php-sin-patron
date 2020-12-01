<?php
if (isset($_POST)) {
    // Conexión a la base de datos
    require_once "includes/conexion.php";
    // Iniciar Sesión
    if (!isset($_SESSION)) session_start();

    // Recoger los valores del formulario de registro
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

    // Array de errores
    $errores = array();

    // Validar los datos antes de guardarlos en la base de datos
    // Validar nombre
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombreValidado = true;
    } else {
        $nombreValidado = false;
        $errores['nombre'] = "El nombre no es válido";
    }

    // Validar apellidos
    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidosValidado = true;
    } else {
        $apellidosValidado = false;
        $errores['apellidos'] = "Los apellidos no son válidos";
    }

    // Validar email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailValidado = true;
    } else {
        $emailValidado = false;
        $errores['email'] = "El email no es válido";
    }

    // Validar contraseña
    if (!empty($password)) {
        echo "el nombre es valido";
        $passwordValidado = true;
    } else {
        $passwordValidado = false;
        $errores['password'] = "La contraseña está vacía";
    }

    $guardarUsuario = false;

    if (count($errores) == 0) {
        $guardarUsuario = true;
        // Cifrar la contraseña
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);
        // Insertar usuario en la tabla usuarios
        $sql = "insert into usuarios values(null, '$nombre', '$apellidos', '$email', '$password_segura', curdate());";
        $guardar = mysqli_query($db, $sql);

        if ($guardar) {
            $_SESSION['completado'] = "El registro se ha completado con éxito.";
        } else {
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario.";
        }
    } else {
        $_SESSION['errores'] = $errores;
        header("Location: index.php");
    }
}

header("Location: index.php");