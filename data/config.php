<?php

date_default_timezone_set('Mexico/General');
setlocale(LC_ALL, "es_ES");

// Borrar reportes de error para produccion
error_reporting(0);

// Variable definida para utilizar en los enlaces o en la reedirección
define('RUTA', "http://{$_SERVER['SERVER_NAME']}/");

//  Arreglo de configuracion de la Base de datos
$bd_config = array(
    // Nombre de dominio o host
    'host' => 'localhost',
    // nombre de la base de datos
    'basededatos' => 'hammex_asistencias',
    // Usurio de base de datos
    'usuario' => 'gortega',
    // Contraseña de base de datos
    'pass' => 'Issac1997'
);
