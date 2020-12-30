<?php
// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require_once '../data/config.php';

// Insersion de archivo de funciones
require_once '../data/functions.php';

// Destruyendo la sesión
session_destroy();

// Limpiando la variable SESSION
$_SESSION =  array();

// Reedireccionamiento a index.php
header("Location: " . RUTA . "admin/");
