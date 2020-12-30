<?php
// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require '../../data/config.php';

// Insersion de archivo de funciones
require '../../data/functions.php';

$conexion = conexion($bd_config);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(strtolower(limpiarDatos($_POST['email'])), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $validarUser = validarExistUser($conexion, $email);
    if ($validarUser) {
        $asistencias = consultAsist($conexion, $email);

        require '../consultasist.view.php';
    } else {
        $_SESSION['no_exist'] = '1';
        header("Location: " . RUTA);
    }
} else {
    header("Location: " . RUTA);
}
