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
    <title>Administradores</title>
</head>

<body>

    <!-- Navbar -->
    <?php require 'navbar.php' ?>

    <div style="padding-top: 68px"></div>
    <div class="container content-fluid pt-3">
        <?php echo $errores; ?>
        <div class="row justify-content-center">
            <?php
            if (!empty($administradores)) {
                foreach ($administradores as $administrador) : ?>
                    <div class="card text-white mb-3 bg-dark" style="width: 18rem;">
                        <div class="card-header text-center h5"><?php echo $administrador['name'] ?></div>
                        <div class="card-body">
                            <h6 class="card-title">Usuario: <a href="mailto:<?php echo $administrador['user'] ?>" class="text-info"><?php echo $administrador['user'] ?></a></h6>
                            <!-- <p class="card-text">Contraseña: <a href="#" class="text-info">Ver ➥</a></p> -->
                            <div class="btn-group col-12" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info col-6" data-toggle="modal" data-target="#editUser" data-registro="<?php echo base64_encode($administrador['id_user']) ?>" data-nombre="<?php echo $administrador['name'] ?>" data-usuario="<?php echo $administrador['user'] ?>" data-pass="<?php echo $administrador['pass'] ?>">Editar</button>
                                <button type=" button" class="btn btn-danger col-6" data-toggle="modal" data-target="#deleteUser" data-nombre="<?php echo $administrador['name'] ?>" data-registro="<?php echo base64_encode($administrador['id_user']) ?>">Elminar</button>
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 pr-2"></div>
                <?php endforeach; ?>
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

    <!-- Crear Admin -->
    <div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Administrador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="user" class="col-form-label">Correo electrónico (usuario): </label>
                            <input type="email" class="form-control" id="user" name="user" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="pass" name="pass" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="pass2" class="col-form-label">Confirmar contraseña:</label>
                            <input type="password" class="form-control" id="pass2" name="pass2" autocomplete="off" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="<?php echo RUTA ?>resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?php echo RUTA ?>resources/js/bootstrap.min.js"></script>

</body>

</html>