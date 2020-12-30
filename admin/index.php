<?php

// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require '../data/config.php';

// Insersion de archivo de funciones
require '../data/functions.php';

// Variable de error para mensajes de inicio de sesión
$errores = '';

// Insertando la conexion de la base de datos
$conexion = conexion($bd_config);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = filter_var(strtolower(limpiarDatos($_POST['usuario'])), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $password = filter_var(limpiardatos($_POST['contrasena']), FILTER_SANITIZE_STRING);
    $password = hash('sha512', $password);
    $password = hash('sha256', $password);

    if (iniciar_sesion($conexion, $usuario, $password) != false) {
        $_SESSION['usuario'] = $usuario;
        header('Location:' . RUTA . 'admin/panel.php');
    } else {

        $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> El usuario o la contraseña son incorrectos.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    }
}

/* Condicional para verficar si las variable de sesión de usuario esta seteada 
nos redireccione a la pagina de inicio de la aplicación */
if (isset($_SESSION['usuario'])) {
    header('Location: ' . RUTA . 'admin/panel.php');
}



// Insersión de vista de archivo html para inicio de sesión
require 'views/index.view.php';
