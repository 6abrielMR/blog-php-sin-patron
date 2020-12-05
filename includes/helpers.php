<?php

function mostrarError($errores, $campo) {
    $alerta = "";
    if (isset($errores[$campo]) && !empty($campo)) {
        $alerta = "<div class='alerta alerta-error'>".$errores[$campo]."</div>";
    }

    return $alerta;
}

function borrarErrores() {
    if (isset($_SESSION['errores'])) {
        $_SESSION['errores'] = null;
        unset($_SESSION['errores']);
    }

    if (isset($_SESSION['errores_entrada'])) {
        $_SESSION['errores_entrada'] = null;
        unset($_SESSION['errores_entrada']);
    }
    
    if (isset($_SESSION['completado'])) {
        $_SESSION['completado'] = null;
        unset($_SESSION['completado']);
    }
}

function conseguirCategorias($conexion) {
    $sql = "select * from categorias order by id asc";
    $categorias = mysqli_query($conexion, $sql);

    $result = array();
    if ($categorias && mysqli_num_rows($categorias) >= 1) {
        $result = $categorias;
    }

    return $result;
}

function conseguirCategoria($conexion, $id) {
    $sql = "select * from categorias where id = $id";
    $categorias = mysqli_query($conexion, $sql);

    $result = array();
    if ($categorias && mysqli_num_rows($categorias) >= 1) {
        $result = mysqli_fetch_assoc($categorias);
    }

    return $result;
}

function conseguirEntradas($conexion, $limit = null, $categoria = null) {
    $sql = "select e.*, c.nombre as 'categoria' from entradas e ".
            "inner join categorias c on e.categoria_id = c.id ";
    if (!empty($categoria)) $sql .= "where e.categoria_id = $categoria ";
    $sql .= "order by e.id desc ";
    if ($limit) $sql .= "limit 4";
    $entradas = mysqli_query($conexion, $sql);
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas) >= 1) {
        $resultado = $entradas;
    }

    return $resultado;
}

function conseguitEntrada($conexion, $id) {
    $sql = "select e.*, c.nombre as 'categoria' from entradas e ".
            "inner join categorias c on e.categoria_id = c.id ".
            "where e.id = $id";
    $entrada = mysqli_query($conexion, $sql);

    $result = array();
    if ($entrada && mysqli_num_rows($entrada) >= 1) {
        $result = mysqli_fetch_assoc($entrada);
    }

    return $result;
}