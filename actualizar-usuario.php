<?php
if (isset($_POST)) {
    // Conexión a la base de datos
    require_once "includes/conexion.php";
    // Iniciar Sesión
    if (!isset($_SESSION)) session_start();

    // Recoger los valores del formulario de registro
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

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

    if (count($errores) == 0) {
        $usuario = $_SESSION['usuario'];
        // Comprobar si el usuario no existe
        $sql = "select id, email from usuarios where email = '$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);

        if ($isset_user['id'] == $usuario['id'] || empty($isset_user)) {
            // Actualizar usuario en la tabla usuarios
            $sql = "update usuarios set ".
            "nombre = '$nombre', ".
            "apellidos = '$apellidos', ".
            "email = '$email' ".
            "where id = ".$usuario['id'];
            $guardar = mysqli_query($db, $sql);

            if ($guardar) {
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;
                $_SESSION['completado'] = "Tus datos se han actualizado con éxito.";
                header("Location: mis-datos.php");
            } else {
                $_SESSION['errores']['general'] = "Fallo al actualizar tus datos.";
                header("Location: mis-datos.php");
            }
        } else {
            $_SESSION['errores']['general'] = "Este correo ya existe.";
            header("Location: mis-datos.php");
        }
    } else {
        $_SESSION['errores'] = $errores;
	    header("Location: mis-datos.php");
    }
}
