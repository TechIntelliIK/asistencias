<?php
// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require_once '../../data/config.php';

// Insersion de archivo de funciones
require_once '../../data/functions.php';

// Insertando la conexion de la base de datos
$conexion  = conexion($bd_config);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_asistecia = base64_decode(filter_var(limpiarDatos($_POST['registro']), FILTER_SANITIZE_STRING));
    $entrada = filter_var($_POST['entrada'], FILTER_SANITIZE_STRING);
    $salida = filter_var($_POST['salida'], FILTER_SANITIZE_STRING);
    $statement = $conexion->prepare('UPDATE asistencias_usuarios SET entrada = :entrada, salida = :salida WHERE id_asistencia = :id');
    $statement->execute(array(
        ':id' => $id_asistecia,
        ':entrada' => $entrada,
        ':salida' => $salida
    ));
    $_SESSION['actualizada'] = '1';
    header('Location: ' . RUTA . 'admin');
} else {
    header('Location: ' . RUTA . 'admin');
}
