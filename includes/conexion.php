<?php

// Conexion
$servidor = 'localhost';
$usuario = 'root';
$password = '';
$basededatos = 'blog_master';
$db = mysqli_connect($servidor, $usuario, $password, $basededatos);

mysqli_query($db, "set names 'utf8'");

// Iniciar la sesión
if (!isset($_SESSION)) session_start();