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
    <title>Iniciar Sesión</title>
</head>

<body>

    <!-- Incio de Formulario -->
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <!-- Icono de Usuario -->
        <img class="mb-4" src="<?php echo RUTA; ?>resources/img/logo.png" alt="" width="300" height="80" style="display: block; margin: auto;">
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center;">Iniciar Sesión</h1>
        <label for="inputEmail" class="sr-only">Correo Electrónico</label>
        <!-- Caja de Texto de Usuario -->
        <input type="email" id="inputEmailLog" class="form-control text-center" name="usuario" placeholder="Correo Electrónico" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <!-- Caja de Texto de COntraseña -->
        <input type="password" id="inputPassword" class="form-control text-center" name="contrasena" placeholder="Contraseña" required>
        <!-- Impresion de errores de Inicio de Sesion -->
        <?php if (!empty($errores)) : ?>
            <?php echo $errores; ?>
        <?php endif; ?>
        <!-- Botón para Registrarse -->
        <p class="text-center"><a href="<?php echo RUTA; ?>" class="btn btn-link">Ir a registro de asistencia</a></p>
        <!-- Botón para Ingresar -->
        <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
    </form>
    <!-- Terminación de Formulario -->

    <!-- JS, Popper.js, and jQuery -->
    <script src="<?php echo RUTA ?>resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?php echo RUTA ?>resources/js/bootstrap.min.js"></script>

</body>

</html>