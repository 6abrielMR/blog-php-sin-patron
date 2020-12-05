<?php

if (isset($_POST)) {
    // Conexión a la base de datos
    require_once "includes/conexion.php";

    $titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($db, $_POST['titulo']) : false;
    $descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($db, $_POST['descripcion']) : false;
    $categoria = isset($_POST['categoria']) ? (int) $_POST['categoria'] : false;
    $usuario = $_SESSION['usuario']['id'];

    // Array de errores
    $errores = array();

    // Validar los datos antes de guardarlos en la base de datos
    // Validar titulo
    if (!empty($titulo) && !is_numeric($titulo) && !preg_match("/[0-9]/", $titulo)) {
        $nombreValidado = true;
    } else {
        $tituloValidado = false;
        $errores['titulo'] = "El titulo no es válido";
    }
    // Validar descripcion
    if (!empty($descripcion) && !is_numeric($descripcion) && !preg_match("/[0-9]/", $descripcion)) {
        $descripcionValidado = true;
    } else {
        $descripcionValidado = false;
        $errores['descripcion'] = "La descripcion no es válida";
    }
    // Validar categoria
    if (!empty($categoria) && is_numeric($categoria)) {
        $categoriaValidado = true;
    } else {
        $categoriaValidado = false;
        $errores['categoria'] = "Selecciona una categoría";
    }

    // Validar si existen errores
    if (count($errores) == 0) {
        $sql = "insert into entradas values(null, $usuario, $categoria, '$titulo', '$descripcion', curdate())";
        $guardar = mysqli_query($db, $sql);
        header("Location: index.php");
    } else {
        $_SESSION['errores_entrada'] = $errores;
        header("Location: crear-entradas.php");
    }
}