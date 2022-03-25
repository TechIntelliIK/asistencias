<?php
// Declarando la funcion de sesion iniciada
session_start();

// Llamando archvio de configuracion
require '../data/config.php';

// Insersion de archivo de funciones
require '../data/functions.php';

$conexion = conexion($bd_config);

$empleados = empleados($conexion);

// Variable de error para mensajes de inicio de sesión
$errores = '';

$active_asis = '';
$active_admin = '';
$active_emp = 'active';

if (isset($_SESSION['registrado'])) {
    unset($_SESSION['registrado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Colaborador registrado correctamente.
                    </div>';
}

if (isset($_SESSION['actualizado'])) {
    unset($_SESSION['actualizado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Colaborador actualizado correctamente.
                    </div>';
}

if (isset($_SESSION['eliminado'])) {
    unset($_SESSION['eliminado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Colaborador eliminado correctamente.
                    </div>';
}

if (isset($_SESSION['vacios'])) {
    $errores .= $_SESSION['vacios'];
    unset($_SESSION['vacios']);
}

if (isset($_SESSION['validacion'])) {
    $errores .= $_SESSION['validacion'];
    unset($_SESSION['validacion']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_empleado = filter_var(limpiarDatos($_POST['id_emp']), FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
    $nombre = filter_var(limpiarDatos(ucwords($_POST['name'])), FILTER_SANITIZE_STRING);
    $email = filter_var(strtolower(limpiarDatos($_POST['user'])), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $carpeta_destino = '../resources/img/imgusers/' . $email . '/';

    if (empty($id_empleado) or empty($email) or empty($nombre)) {
        $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor llena todos los datos correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
    } else {
        $userValid = validarExistUser($conexion, $email);
        if ($userValid != false) {
            $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> El email ya existe.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
        }
        
        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        if ($errores == '') {
            $statement = $conexion->prepare('INSERT INTO `empleados` (`id_empleado`, `empleado`, `email`) VALUES 
            (:id_empleado, :nombre, :email)');
            $statement->execute(array(
                ':id_empleado' => $id_empleado,
                ':nombre' => $nombre,
                ':email' => $email,
            ));
            $_SESSION['registrado'] = 'registrate';
            header('Location:' . RUTA . 'admin/usuarios.php');
        }
    }
}

/* Condicional que verifica si la variable sesión esta seteada
hace la insersión del archivo de vista html de lo contrario 
redirecciona al usuario a la pantalla de Login*/
if (isset($_SESSION['usuario'])) {
    require 'views/usuarios.view.php';
} else {
    header("Location: " . RUTA . "admin/");
}
