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

    $fecha_inicio = filter_var($_POST['entrada'], FILTER_SANITIZE_STRING);
    $fecha_fin = filter_var($_POST['salida'], FILTER_SANITIZE_STRING);
    $noRegistro = array('noregistrada' => 'No Registrada.');

    header('Content-Type:text/csv; charset=latin1');
    header('Content-Disposition: attachment; filename="Reporte_de_asistencias.csv"');

    $salida = fopen('php://output', 'w');

    fputcsv($salida, array(
        'No. Empleado',
        'Nombre',
        'Entrada',
        'Salida'
    ));

    $statement = $conexion->prepare(
        'SELECT * FROM asistencias_usuarios A JOIN empleados B ON B.email = A.email WHERE entrada BETWEEN :fecha_inicio AND :fecha_fin ORDER BY empleado ASC, entrada ASC'
    );

    $statement->execute(array(
        ':fecha_inicio' => $fecha_inicio,
        ':fecha_fin' => $fecha_fin
    ));

    $resultado = $statement->fetchAll();

    foreach ($resultado as $res) :
        fputcsv($salida, array(
            $res['id_empleado'],
            $res['empleado'],
            $res['entrada'],
            $res['salida']
        ));
    endforeach;
} else {
    header('Location: ' . RUTA . 'admin');
}
