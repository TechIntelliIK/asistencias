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
    $nombre = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
    $email = extractEmail($conexion, $id_user);
    $carpeta_antigua = '../../resources/img/imgusers/' . $email['email'];
    $carpeta_renombrada = '../../resources/img/imgusers/' . $correo;

    if (empty($id_user) or empty($nombre) or empty($correo)) {
        $_SESSION['vacios'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor llena todos los datos correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
        header('Location: ' . RUTA . 'admin/usuarios.php');
    } else {

        echo rename($carpeta_antigua, $carpeta_renombrada);

        $statement = $conexion->prepare('UPDATE empleados SET empleado = :nombre, email = :correo WHERE id_empleado = :id');
        $statement->execute(array(
            ':id' => $id_user,
            ':nombre' => $nombre,
            ':correo' => $correo
        ));
        $_SESSION['actualizado'] = '1';
        header('Location: ' . RUTA . 'admin/usuarios.php');
    }
} else {
    header('Location: ' . RUTA . 'admin/usuarios.php');
}
