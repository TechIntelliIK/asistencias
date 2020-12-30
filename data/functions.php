<?php

// Funcion de conexion a la base de datos
function conexion($bd_config)
{
    try {
        $conexion = new PDO("mysql:host=" . $bd_config["host"] . ";dbname=" . $bd_config["basededatos"], $bd_config["usuario"], $bd_config["pass"]);
        return $conexion;
    } catch (PDOException $e) {
        return false;
    }
}

function limpiarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = strip_tags($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

// Funcion de validacion de Inicio de Sesion
function iniciar_sesion($conexion, $usuario, $password)
{
    $statement = $conexion->prepare("SELECT * FROM users WHERE user = :user AND pass = :pass LIMIT 1");
    $statement->execute(array(":user" => $usuario, ":pass" => $password));
    $resultado = $statement->fetch();
    return ($resultado) ? $resultado : false;
}

function validarExistUser($conexion, $usuario)
{
    $statement = $conexion->prepare("SELECT * FROM empleados WHERE email = :usuario LIMIT 1");
    $statement->execute(array(":usuario" => $usuario));
    $resultado = $statement->fetch();
    return ($resultado) ? $resultado : false;
}

function extractName($conexion, $usuario)
{
    $statement = $conexion->prepare("SELECT empleado FROM empleados WHERE email = :usuario LIMIT 1");
    $statement->execute(array(":usuario" => $usuario));
    $resultado = $statement->fetch();
    return ($resultado) ? $resultado : false;
}

function verifyEnter($conexion, $fecha, $usuario)
{
    $statement = $conexion->prepare("SELECT entrada FROM asistencias_usuarios WHERE DATE(entrada) = :fecha AND email = :usuario LIMIT 1");
    $statement->execute(array(":fecha" => $fecha, ':usuario' => $usuario));
    $resultado = $statement->fetch();
    return ($resultado) ? $resultado : false;
}

function verifyExit($conexion, $fecha, $usuario)
{
    $statement = $conexion->prepare("SELECT salida FROM asistencias_usuarios WHERE DATE(salida) = :fecha AND email = :usuario LIMIT 1");
    $statement->execute(array(":fecha" => $fecha, ':usuario' => $usuario));
    $resultado = $statement->fetch();
    return ($resultado) ? $resultado : false;
}

function asistencias($conexion)
{
    $statement = $conexion->query('SELECT * FROM asistencias_usuarios A JOIN empleados B ON B.email = A.email ORDER BY entrada DESC');
    $resultado = $statement->fetchAll();
    return ($resultado) ? $resultado : false;
}

function consultAsist($conexion, $email)
{
    $statement = $conexion->prepare("SELECT * FROM asistencias_usuarios A JOIN empleados B ON B.email = A.email WHERE A.email = :usuario ORDER BY entrada DESC");
    $statement->execute(array(":usuario" => $email));
    $resultado = $statement->fetchAll();
    return ($resultado) ? $resultado : false;
}

function fecha($fecha)
{
    $timestamp = strtotime($fecha);
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $dia = date('d', $timestamp);
    $mes = date('m', $timestamp) - 1;
    $year = date('Y', $timestamp);

    $fecha = "$dia de " . $meses[$mes] . " del $year";
    return $fecha;
}
