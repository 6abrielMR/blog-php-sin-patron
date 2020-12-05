<?php

if (isset($_POST)) {
    // Conexión a la base de datos
    require_once "includes/conexion.php";

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;

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

    // Validar si existen errores
    if (count($errores) == 0) {
        $sql = "insert into categorias values(null, '$nombre')";
        $guardar = mysqli_query($db, $sql);
    }
}

header("Location: index.php");