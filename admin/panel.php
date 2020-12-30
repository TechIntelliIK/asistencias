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

$active_asis = 'active';
$active_admin = '';
$active_emp = '';

$asistencias = asistencias($conexion);

if (isset($_SESSION['actualizada'])) {
    unset($_SESSION['actualizada']);
    $errores .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>¡Excelente!</strong> Se a actualizado el registro correctamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
}

if (isset($_SESSION['eliminada'])) {
    unset($_SESSION['eliminada']);
    $errores .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>¡Excelente!</strong> Se a eliminado el registro correctamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
}

/* Condicional que verifica si la variable sesión esta seteada
hace la insersión del archivo de vista html de lo contrario 
redirecciona al usuario a la pantalla de Login*/
if (isset($_SESSION['usuario'])) {
    require 'views/panel.view.php';
} else {
    header("Location: " . RUTA . "admin/");
}
