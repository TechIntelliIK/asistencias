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
$active_admin = 'active';
$active_emp = '';

$administradores = administradores($conexion);

if (isset($_SESSION['registrado'])) {
    unset($_SESSION['registrado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Usuario registrado correctamente.
                    </div>';
}

if (isset($_SESSION['actualizado'])) {
    unset($_SESSION['actualizado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Usuario actualizado correctamente.
                    </div>';
}

if (isset($_SESSION['eliminado'])) {
    unset($_SESSION['eliminado']);
    $errores .= '<div class="alert alert-success alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Exito!</strong> Usuario eliminado correctamente.
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
    $usuario = filter_var(strtolower(limpiarDatos($_POST['user'])), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $nombre = filter_var(limpiarDatos(ucwords($_POST['name'])), FILTER_SANITIZE_STRING);
    $pass1 = filter_var(limpiarDatos($_POST['pass']), FILTER_SANITIZE_STRING);
    $pass2 = filter_var(limpiarDatos($_POST['pass2']), FILTER_SANITIZE_STRING);
    if (empty($usuario) or empty($nombre) or empty($pass1) or empty($pass2)) {
        $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor llena todos los datos correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
    } else {
        $userValid = validarExistUserS($conexion, $usuario);
        if ($userValid != false) {
            $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> El nombre de usuario ya existe.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
        }

        $pass1 = hash('sha512', $pass1);
        $pass1 = hash('sha256', $pass1);
        $pass2 = hash('sha512', $pass2);
        $pass2 = hash('sha256', $pass2);

        if ($pass1 != $pass2) {
            $errores .= '<div class="alert alert-danger alert-dismissable col-12">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>¡Error!</strong> Las contraseñas no coinciden.
                    </div>';
        }

        if ($errores == '') {
            $statement = $conexion->prepare('INSERT INTO users (id_user, name, user, pass) 
                VALUES (NULL, :nombre, :user, :pass)');
            $statement->execute(array(
                ':nombre' => $nombre,
                ':user' => $usuario,
                ':pass' => $pass1
            ));
            $_SESSION['registrado'] = 'registrate';
            header('Location:' . RUTA . 'admin/admins.php');
        }
    }
}

/* Condicional que verifica si la variable sesión esta seteada
hace la insersión del archivo de vista html de lo contrario 
redirecciona al usuario a la pantalla de Login*/
if (isset($_SESSION['usuario'])) {
    require 'views/admins.view.php';
} else {
    header("Location: " . RUTA . "admin/");
}
