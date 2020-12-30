<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Icono de pestaña -->
    <link rel="shortcut icon" href="<?php echo RUTA; ?>icono.png" type="image/x-icon">
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo RUTA; ?>resources/css/signin.css">
    <link rel="stylesheet" href="<?php echo RUTA; ?>resources/css/bootstrap.min.css">
    <script src="<?php echo RUTA ?>resources/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <!-- Color navegador -->
    <meta name="theme-color" content="#202020">
    <title>Asistencias H&A</title>
</head>

<body>

    <!-- Incio de Formulario -->
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <!-- Icono de Usuario -->
        <img class="mb-4" src="<?php echo RUTA; ?>resources/img/logo.png" alt="" width="300" height="80" style="display: block; margin: auto;">
        <h1 class="h3 font-weight-small" style="text-align: center;">Resgistrar Asistencia</h1>
        <p class="text-center"><a data-toggle="modal" data-target="#consultar" class="btn btn-link" title="!Esta función ya está disponible¡">Consulta tus asistencias aquí ➟</a></p>
        <!-- Botón para ocultar campos de imagen y comentario -->
        <div class="custom-control custom-switch" style="text-align: center;">
            <input type="checkbox" id="customSwitch1" name="registro" value="Salida" class="custom-control-input">
            <label class="custom-control-label" for="customSwitch1">Registrar salida (click aquí)</label>
        </div>
        <div style="padding-bottom: 15px;"></div>
        <!-- Caja de Texto de Usuario -->
        <label for="inputEmail" class="sr-only">Correo Electrónico</label>
        <input type="email" id="inputEmail" class="form-control text-center" name="usuario" placeholder="Correo Electrónico" required autofocus>
        <!-- Caja de imagen de pantalla -->
        <div class="custom-file mb-1" id="file1_block">
            <input type="file" id="file1" class="custom-file-input" name="thumb" placeholder="Imagen de pantalla" required>
            <label class="custom-file-label" id="label1">Imagen de pantalla</label>
        </div>
        <!-- Caja de imagen de colaborador -->
        <div class="custom-file mb-1" id="file2_block">
            <input type="file" id="file2" class="custom-file-input" name="thumb2" placeholder="Imagen de colaborador" required>
            <label class="custom-file-label" id="label2">Imagen de colaborador</label>
        </div>
        <!-- Area de texto para justificación -->
        <textarea name="comentario" id="comentario" class="form-control text-justify" placeholder="Nota o justificación (opcional): En este apartado se escribirán justificaciones en caso de que haya alguna falta por enfermedad, salida de la empresa, vacaciones, etc..."></textarea>
        <!-- Impresion de errores de Inicio de Sesion -->
        <?php if (!empty($errores)) : ?>
            <?php echo $errores; ?>
        <?php endif; ?>
        <!-- Botón para Registrarse -->
        <!-- <a href="#" class="btn btn-link col-12" data-toggle="modal" data-target="#exampleModalLong">Click para más Información ➟?</a>-->
        <p class="text-center"><a href="<?php echo RUTA; ?>admin/" class="btn btn-link">Ir a administración de asistencias ➟</a></p>
        <!-- Botón para Ingresar -->
        <button class="btn btn-primary btn-block col-12" type="submit">Registrar</button>
    </form>
    <!-- Terminación de Formulario -->

    <!-- Consultar Asistencias -->
    <div class="modal fade" id="consultar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consulta tus asistencias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars(RUTA . 'views/stm/consultasist.php'); ?>" method="POST">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Ingresa tu correo electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Consultar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS, Popper.js, and jQuery -->
    <script src="<?php echo RUTA ?>resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?php echo RUTA ?>resources/js/bootstrap.min.js"></script>
    <script src="<?php echo RUTA ?>resources/js/exit.js"></script>
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        })
    </script>
</body>

</html>