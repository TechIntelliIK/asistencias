<?php

session_start();

// Llamando archvio de configuracion
require 'data/config.php';

// Insersion de archivo de funciones
require 'data/functions.php';

// Variable de error para mensajes de inicio de sesión
$errores = '';

// Insertando la conexion de la base de datos
$conexion  = conexion($bd_config);

// echo var_dump(verifyEnter($conexion, date("Y-m-d"), $usuario));

if (isset($_SESSION['asistencia'])) {
    unset($_SESSION['asistencia']);
    $errores .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>¡Bienvenid@ ' . $_SESSION['nombre']  . '!</strong> Tu asistencia se ha registrado a las ' . date("g:i a") . ' exitosamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    unset($_SESSION['nombre']);
}

if (isset($_SESSION['salida'])) {
    unset($_SESSION['salida']);
    $errores .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>¡Excelente!</strong> Tu salida se ha registrado a las ' . date("g:i a") . ' exitosamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
}

if (isset($_SESSION['no_exist'])) {
    unset($_SESSION['no_exist']);
    $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>¡Error!</strong> El usuario ingresado no existe, verificarlo por favor.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
    $usuario = filter_var(strtolower(limpiarDatos($_POST['usuario'])), FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $validarUser = validarExistUser($conexion, $usuario);
    if (empty($_POST['registro'])) {
        $registro = 'Entrada';
        $thumb1 = @getimagesize($_FILES['thumb']['tmp_name']);
        $thumb2 = @getimagesize($_FILES['thumb2']['tmp_name']);
        $coment = filter_var(limpiarDatos($_POST['comentario']), FILTER_SANITIZE_STRING);
    } else {
        $registro = filter_var(limpiarDatos($_POST['registro']), FILTER_SANITIZE_STRING);
    }


    if (empty($usuario)) {
        $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> Por favor llena todos los datos correctamente.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
    } else {
        if ($validarUser) {
            if ($registro == 'Entrada') {
                if (verifyEnter($conexion, date("Y-m-d"), $usuario) != true) {
                    if ($thumb1 !== false && $thumb2 !== false) {
                        $fehahora_actual = date("Y-m-d H:i:s");
                        $carpeta_destino = 'resources/img/imgusers/' . $usuario . '/';
                        if(!file_exists($carpeta_destino)){
                            mkdir($carpeta_destino, 0777, true);
                        }
                        $thumb_name1 = uniqid(mt_rand(), true) . '_' . $_FILES['thumb']['name'];
                        $thumb_name2 = uniqid(mt_rand(), true) . '_' . $_FILES['thumb2']['name'];
                        $archivo_subido = $carpeta_destino . $thumb_name1;
                        $archivo_subido2 = $carpeta_destino . $thumb_name2;
                        move_uploaded_file($_FILES['thumb']['tmp_name'], $archivo_subido);
                        move_uploaded_file($_FILES['thumb2']['tmp_name'], $archivo_subido2);
                        $exif = exif_read_data($archivo_subido);
                        $exif2 = exif_read_data($archivo_subido2);
                        $fecha_img = date_format(date_create($exif['DateTimeOriginal']), "Y-m-d");
                        $fecha_img2 = date_format(date_create($exif2['DateTimeOriginal']), "Y-m-d");

                        if ($fecha_img == date("Y-m-d") && $fecha_img2 == date("Y-m-d")) {
                            if (empty($coment)) {
                                $statement = $conexion->prepare('INSERT INTO asistencias_usuarios (id_asistencia, email, thumb, thumb2, entrada, salida) 
                                                VALUES (NULL, :correo, :thumb1, :thumb2, :fecha_hora, "0000-00-00 00:00:00")');

                                $statement->execute(array(
                                    ':correo' => $usuario,
                                    ':thumb1' => $thumb_name1,
                                    ':thumb2' => $thumb_name2,
                                    ':fecha_hora' => $fehahora_actual
                                ));
                                $nombre = extractName($conexion, $usuario);
                                $_SESSION['asistencia'] = '1';
                                $_SESSION['nombre'] = $nombre['empleado'];
                                header('Location: ' . RUTA);
                            } else {
                                $statement = $conexion->prepare('INSERT INTO asistencias_usuarios (id_asistencia, email, thumb, thumb2, entrada, salida, comentario) 
                                                VALUES (NULL, :correo, :thumb1, :thumb2, :fecha_hora, "0000-00-00 00:00:00", :comentario)');

                                $statement->execute(array(
                                    ':correo' => $usuario,
                                    ':thumb1' => $thumb_name1,
                                    ':thumb2' => $thumb_name2,
                                    ':fecha_hora' => $fehahora_actual,
                                    ':comentario' => $coment
                                ));
                                $nombre = extractName($conexion, $usuario);
                                $_SESSION['asistencia'] = '1';
                                $_SESSION['nombre'] = $nombre['empleado'];
                                header('Location: ' . RUTA);
                            }
                        } else {
                            unlink($archivo_subido);
                            unlink($archivo_subido2);
                            $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> Una de las fotografias no fue tomada el dia de hoy, favor de subir una fotografia tomada recientemente.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                        }
                    } else {
                        $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> Formato de imagen o archivo no valido.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                } else {
                    $horaEnter = verifyEnter($conexion, date('Y-m-d'), $usuario);
                    $hora_entrada = date_create($horaEnter['entrada']);
                    $errores .= '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Atención!</strong> Ya se ha registrado tu hora de entrada del dia de hoy ' . date("d/m/Y") . ' a las ' . date_format($hora_entrada, "g:i a") . '.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                }
            } else {
                if (verifyEnter($conexion, date("Y-m-d"), $usuario) == true) {
                    if (verifyExit($conexion, date("Y-m-d"), $usuario) != true) {
                        $fehahora_actual = date("Y-m-d H:i:s");
                        $statement = $conexion->prepare('UPDATE asistencias_usuarios SET salida = :fecha_hora 
                                                        WHERE DATE(entrada) = :fecha AND email = :correo');
                        $statement->execute(array(
                            ':correo' => $usuario,
                            ':fecha' => date("Y-m-d"),
                            ':fecha_hora' => $fehahora_actual
                        ));

                        $nombre = extractName($conexion, $usuario);
                        $_SESSION['salida'] = '1';
                        header('Location: ' . RUTA);
                    } else {
                        $horaExit = verifyExit($conexion, date('Y-m-d'), $usuario);
                        $hora_salida = date_create($horaExit['salida']);
                        $errores .= '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Atención!</strong> Ya se ha registrado tu hora de salida del dia de hoy ' . date("d/m/Y") . ' a las ' . date_format($hora_salida, "g:i a") . '.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                } else {
                    $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>¡Error!</strong> No has registrado tu hora de entrada, verificar hora de entrada del dia de hoy por favor.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                }
            }
        } else {
            $errores .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>¡Error!</strong> El usuario ingresado no existe, verificarlo por favor.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }
    }
}

// Insersión de vista de archivo html para inicio de sesión
require 'views/index.view.php';
