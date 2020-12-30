<?php
// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require '../data/config.php';

// Insersion de archivo de funciones
require '../data/functions.php';

$conexion = conexion($bd_config);

// Variable de error para mensajes de inicio de sesión
$errores = '';

$active_asis = '';
$active_admin = '';
$active_emp = 'active';

/* Condicional que verifica si la variable sesión esta seteada
hace la insersión del archivo de vista html de lo contrario 
redirecciona al usuario a la pantalla de Login*/
if (isset($_SESSION['usuario'])) {
    require 'views/usuarios.view.php';
} else {
    header("Location: " . RUTA . "admin/");
}
