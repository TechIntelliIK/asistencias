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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="<?php echo RUTA ?>">👈 Regresar</a>
    </nav>

    <div style="padding-top: 75px"></div>
    <div class="container content-fluid pt-3">
        <div class="row justify-content-center">
            <?php
            if (!empty($asistencias)) {
                foreach ($asistencias as $asistencia) : ?>
                    <div class="card text-white mb-3 bg-dark" style="width: 18rem;">
                        <div class="card-header text-center">Asistencia del dia <small><i><?php echo fecha($asistencia['entrada']) ?></i></small></div>
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
    </script>

</body>

</html>