<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?php echo RUTA ?>admin/">Panel de Control</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link <?php echo $active_asis ?>" href="<?php echo RUTA ?>admin/panel.php">Asistencias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $active_admin ?>" href="<?php echo RUTA ?>admin/admins.php">Administradores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $active_emp ?>" href="<?php echo RUTA ?>admin/usuarios.php">Colaboradores</a>
            </li>
        </ul>
        <?php if ($_SERVER['PHP_SELF'] == '/admin/panel.php') : ?>
            <button type="button" class="btn btn-outline-info my-2 my-sm-0 text-white" data-toggle="modal" data-target="#export">Generar Reporte</button>&nbsp;
            <!-- <a class="btn btn-outline-success my-2 my-sm-0 text-white" href="<?php // echo RUTA 
                                                                                    ?>" target="_blank">Nueva Asistencia</a>&nbsp; -->
        <?php endif; ?>
        <a class="btn btn-outline-secondary my-2 my-sm-0 text-white" href="<?php echo RUTA ?>admin/logout.php">Cerrar Sesión</a>
    </div>
</nav>