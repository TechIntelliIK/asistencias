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
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA; ?>resources/css/datatables.min.css">
    <!-- Color navegador -->
    <meta name="theme-color" content="#202020">
    <title>Colaboradores</title>
</head>

<body>

    <!-- Navbar -->
    <?php require 'navbar.php' ?>

    <div style="padding-top: 100px"></div>
    <div class="container content-fluid pt-3">
        <?php echo $errores; ?>
        <div class="row justify-content-center">
            <?php if (!empty($empleados)) : ?>

                <div class="table-responsive">
                    <table id="table_asist" class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No. Nomina</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleados as $empleado) : ?>
                                <tr>
                                    <td><?php echo $empleado['id_empleado'] ?></td>
                                    <td><?php echo $empleado['empleado'] ?></td>
                                    <td><a href="mailto:<?php echo $empleado['email'] ?>" class="text-info"><?php echo $empleado['email'] ?></a></td>
                                    <td>
                                        <div class="btn-group col-12" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-info col-6" data-toggle="modal" data-target="#editUser" data-registro="<?php echo base64_encode($empleado['id_empleado']) ?>" data-nombre="<?php echo $empleado['empleado'] ?>" data-usuario="<?php echo $empleado['email'] ?>">Editar</button>
                                            <button type=" button" class="btn btn-danger col-6" data-toggle="modal" data-target="#deleteUser" data-nombre="<?php echo $empleado['empleado'] ?>" data-registro="<?php echo base64_encode($empleado['email']) ?>">Elminar</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-dark text-white">
                            <tr>
                                <th>No. Nomina</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Crear Admin -->
                <div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo colaborador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="form-group">
                                        <label for="id_emp" class="col-form-label">No. de Nomina:</label>
                                        <input type="number" class="form-control" id="id_emp" name="id_emp" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="user" class="col-form-label">Correo electrónico: </label>
                                        <input type="email" class="form-control" id="user" name="user" autocomplete="off" required>
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

                <!-- Editar Admin -->
                <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Administrador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars(RUTA . 'admin/stm/update.usuarios.php'); ?>" method="POST">
                                    <input type="hidden" name="iduser" id="iduser">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="user" class="col-form-label">Correo electrónico: </label>
                                        <input type="email" class="form-control" id="user" name="user" autocomplete="off" required>
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

                <!-- Modal Eliminar -->
                <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro de </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars(RUTA . 'admin/stm/delete.usuarios.php'); ?>" method="POST">
                                    <input type="hidden" id="iduser" name="iduser">
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

            <?php else : ?>
                <div class="table-responsive">
                    <table id="table_asist" class="table table-striped">
                        <thead class="thead-dark">
                        <tbody>
                        </tbody>
                        <tfoot class="bg-dark text-white">
                            <tr>
                                <th>No. Nomina</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>h>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif ?>

        </div>
    </div>

    <div style="padding-top: 20px"></div>

    <!-- JS, Popper.js, and jQuery -->
    <script src="<?php echo RUTA ?>resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?php echo RUTA ?>resources/js/bootstrap.min.js"></script>
    <script>
        $('#editUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_user = button.data('registro')
            var nombre = button.data('nombre')
            var correo = button.data('usuario')
            var modal = $(this)
            modal.find('.modal-title').text('Editar registro de ' + nombre)
            modal.find('.modal-body #iduser').val(id_user)
            modal.find('.modal-body #name').val(nombre)
            modal.find('.modal-body #user').val(correo)
        })

        $('#deleteUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_user = button.data('registro')
            var nombre = button.data('nombre')
            var modal = $(this)
            modal.find('.modal-title').text('Eliminar registro de ' + nombre)
            modal.find('.modal-body #iduser').val(id_user)
        })

        $(document).ready(function() {
            $('#table_asist').DataTable({
                responsive: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No hay registros",
                    "info": "Mostrando del _PAGE_ al _PAGES_ de _TOTAL_ registros",
                    "infoEmpty": "No hay registros",
                    "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "order": [
                    [3, "desc"]
                ]
            });
        });
    </script>
    <script type="text/javascript" src="<?php echo RUTA ?>resources/js/datatables.min.js"></script>

</body>

</html>