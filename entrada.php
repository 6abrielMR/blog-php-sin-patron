<?php require_once 'includes/cabecera.php'; ?>
<?php require_once 'includes/lateral.php'; ?>
<?php
    $entrada_actual = conseguitEntrada($db, $_GET['id']);
    if(!isset($entrada_actual['id'])) header("Location: index.php");
?>
<!-- Caja Principal -->
<div id="principal">
    <h1><?= $entrada_actual['titulo'] ?></h1>
    <a href="categoria.php?id=<?=$entrada_actual['categoria_id']?>">
        <h2><?= $entrada_actual['categoria'] ?></h2>
    </a>
    <h4><?= $entrada_actual['fecha'] ?></h4>
    <p><?= $entrada_actual['descripcion'] ?></p>
</div>
<!-- Fin del Contenedor -->
<?php require_once 'includes/pie.php'; ?>