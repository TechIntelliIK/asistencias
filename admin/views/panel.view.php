<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Icono de pestaña -->
    <link rel="shortcut icon" href="<?php echo RUTA; ?>icono.png" type="image/x-icon">
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo RUTA; ?>resources/css/bootstrap.min.css">
    <script src="<?php echo RUTA ?>resources/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <!-- Color navegador -->
    <meta name="theme-color" content="#202020">
    <title>Panel de control</title>
</head>

<body>

    <!-- Navbar -->
    <?php require 'navbar.php' ?>

    <div style="padding-top: 88px"></div>
    <div class="container content-fluid pt-3">
        <?php echo $errores; ?>
        <div class="row justify-content-center">
            <?php
            if (!empty($asistencias)) {
                foreach ($asistencias as $asistencia) : ?>
                    <div class="card text-white mb-3 bg-dark" style="width: 18rem;">
                        <div class="card-header text-center">Asistencia del dia <small><i><?php $date = date_create($asistencia['entrada']);
                                                                                            echo fecha($asistencia['entrada']) ?></i></small></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $asistencia['empleado'] ?></h5>
                            <p class="card-text">No. Empleado: <?php echo $asistencia['id_empleado'] ?></p>
                            <p class="card-text">Entrada: <?php $entrada = date_create($asistencia['entrada']);
                                                            echo date_format($entrada, "g:i a") ?></p>
                            <p class="card-text">Salida: <?php
                                                            if ($asistencia['salida'] == '0000-00-00 00:00:00') {
                                                                echo "<span class='text-danger'>No registrada</span>";
                                                            } else {
                                                                $salida = date_create($asistencia['salida']);
                                                                echo date_format($salida, "g:i a");
                                                            }
                                                            ?></p>
                            <p class="card-text"><a href="#" style="color: #7CBEEA;" data-toggle="modal" data-target="#verFotos" data-nombre="<?php echo $asistencia['empleado'] ?>" data-imagen1="<img src=' <?php echo RUTA . 'resources/img/imgusers/' . $asistencia['email'] . '/' . $asistencia['thumb']; ?>' class='img-fluid' alt='Imagen Pantalla'>" data-imagen2="<img src=' <?php echo RUTA . 'resources/img/imgusers/'  . $asistencia['email'] . '/' .  $asistencia['thumb2']; ?>' class='img-fluid' alt='Imagen Pantalla'>" data-nota="<div class='alert alert-primary' role='alert'><?php echo nl2br($asistencia['comentario']); ?></div>">Ver fotos y comentarios ➥</a></p>
                            <div class="btn-group col-12" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info col-6" data-toggle="modal" data-target="#editAsis" data-registro="<?php echo base64_encode($asistencia['id_asistencia']) ?>" data-nombre="<?php echo $asistencia['empleado'] ?>" data-fecha="<?php echo date_format($date, "d-m-Y") ?>" data-entrada="<?php echo $asistencia['entrada'] ?>" data-salida="<?php echo $asistencia['salida'] ?>">Editar</button>
                                <button type=" button" class="btn btn-danger col-6" data-toggle="modal" data-target="#deleteAsis" data-nombre="<?php echo $asistencia['empleado'] ?>" data-fecha="<?php echo date_format($date, "d-m-Y") ?>" data-registro="<?php echo base64_encode($asistencia['id_asistencia']) ?>" data-imagen1="<?php echo '../../resources/img/imgusers/' . $asistencia['email'] . '/' . $asistencia['thumb']; ?>" data-imagen2="<?php echo '../../resources/img/imgusers/' . $asistencia['email'] . '/' . $asistencia['thumb2']; ?>">Elminar</button>
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 pr-2"></div>
                <?php endforeach; ?>

                <!-- Modal ver imagenes -->
                <div class="modal fade" id="verFotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Fotos de Asistencia</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar Ventana</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Eliminar -->
                <div class="modal fade" id="deleteAsis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro de </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars(RUTA . 'admin/stm/delete.asistencia.php'); ?>" method="POST">
                                    <input type="hidden" id="registro" name="registro">
                                    <input type="hidden" id="thumb" name="thumb">
                                    <input type="hidden" id="thumb2" name="thumb2">
                                    Este registro se eliminará premanentemente ¿Desea eliminarlo?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Editar registro -->
                <div class="modal fade" id="editAsis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars(RUTA . 'admin/stm/update.asistencia.php'); ?>" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" id="registro" name="registro">
                                        <label for="entrada" class="col-form-label">Hora de entrada:</label>
                                        <input type="text" class="form-control" id="entrada" name="entrada">
                                    </div>
                                    <div class="form-group">
                                        <label for="salida" class="col-form-label">Hora de salida:</label>
                                        <input type="text" class="form-control" id="salida" name="salida">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Generar reporte -->
                <div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Asistencias</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars(RUTA . 'admin/stm/reporte.php'); ?>" method="POST">
                                    <div class="form-group">
                                        <label for="entrada" class="col-form-label">Fecha de Inicial:</label>
                                        <input type="date" class="form-control" id="entrada" name="entrada">
                                    </div>
                                    <div class="form-group">
                                        <label for="salida" class="col-form-label">Fecha Final:</label>
                                        <input type="date" class="form-control" id="salida" name="salida">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Generar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo '<div class="card text-white justify-content-center col-11 bg-dark">
                        <div class="card-body h2 text-white">
                           <center> No hay registros. </center>
                         </div>
                    </div>';
            }
            ?>

        </div>
    </div>


    <!-- JS, Popper.js, and jQuery -->
    <script src="<?php echo RUTA ?>resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="<?php echo RUTA ?>resources/js/bootstrap.min.js"></script>
    <script>
        $('#verFotos').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nombre = button.data('nombre')
            var imagen1 = button.data('imagen1')
            var imagen2 = button.data('imagen2')
            var comentario = button.data('nota')
            var modal = $(this)
            modal.find('.modal-title').text('Fotos de Asistencia de ' + nombre)
            modal.find('.modal-body').html(imagen1 + '<br>' + imagen2 + '<br><br><h2>Comentarios:</h2>' + comentario)
        })

        $('#deleteAsis').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nombre = button.data('nombre')
            var fecha = button.data('fecha')
            var id_asistencia = button.data('registro')
            var imagen1 = button.data('imagen1')
            var imagen2 = button.data('imagen2')
            var modal = $(this)
            modal.find('.modal-title').text('Eliminar registro de ' + nombre + ' del día ' + fecha)
            modal.find('.modal-body #registro').val(id_asistencia)
            modal.find('.modal-body #thumb').val(imagen1)
            modal.find('.modal-body #thumb2').val(imagen2)
        })

        $('#editAsis').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var nombre = button.data('nombre')
            var fecha = button.data('fecha')
            var id_asistencia = button.data('registro')
            var entrada = button.data('entrada')
            var salida = button.data('salida')
            var modal = $(this)
            modal.find('.modal-title').text('Editar registro de ' + nombre + ' del día ' + fecha)
            modal.find('.modal-body #registro').val(id_asistencia)
            modal.find('.modal-body #entrada').val(entrada)
            modal.find('.modal-body #salida').val(salida)
        })
    </script>

</body>

</html>