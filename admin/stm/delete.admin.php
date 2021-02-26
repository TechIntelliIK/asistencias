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
    $id_user = base64_decode(filter_var(limpiarDatos($_POST['iduser']), FILTER_SANITIZE_STRING));
    $statement = $conexion->prepare('DELETE FROM users WHERE id_user = :id');
    $statement->execute(array(
        ':id' => $id_user
    ));
    $_SESSION['eliminado'] = '1';
    header('Location: ' . RUTA . 'admin/admins.php');
} else {
    header('Location: ' . RUTA . 'admin/admins.php');
}
