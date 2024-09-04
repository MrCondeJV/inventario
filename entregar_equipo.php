<?php
session_start();

// Verificar sesión activa
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Incluir archivo de conexión
include "./conexion.php";

// Obtener el nombre de usuario y rol de la sesión
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];

// Obtener la lista de usuarios
$usuarios = [];
$usuarios_stmt = $mysqli->query("SELECT id, nombre FROM usuarios_prestamo");
if ($usuarios_stmt) {
    $usuarios = $usuarios_stmt->fetch_all(MYSQLI_ASSOC);
}

// Obtener el usuario seleccionado (si existe)
$usuario_id = isset($_GET['usuario_id']) ? (int)$_GET['usuario_id'] : 0;

// Obtener los préstamos del usuario seleccionado
$prestamos = [];
if ($usuario_id > 0) {
    $prestamos_stmt = $mysqli->prepare("SELECT dp.id, e.Nombre AS Nombre_equipo, dp.Cantidad_prestada, e.Serie 
        FROM detalles_prestamo dp
        INNER JOIN equipos e ON dp.serie_equipo = e.Serie
        INNER JOIN prestamos p ON dp.id_prestamo = p.id
        WHERE p.usuario_id = ?");
    if ($prestamos_stmt) {
        $prestamos_stmt->bind_param("i", $usuario_id);
        $prestamos_stmt->execute();
        $prestamos_result = $prestamos_stmt->get_result();
        $prestamos = $prestamos_result->fetch_all(MYSQLI_ASSOC);
        $prestamos_stmt->close();
    }
}

// Procesar la entrega de todos los equipos
if (isset($_POST['entregar_todo'])) {
    $marcar_entrega_stmt = $mysqli->prepare("UPDATE detalles_prestamo SET Estado = 1 
        WHERE id_prestamo IN (SELECT id FROM prestamos WHERE usuario_id = ?)");
    if ($marcar_entrega_stmt) {
        $marcar_entrega_stmt->bind_param("i", $_POST['usuario_id']);
        if ($marcar_entrega_stmt->execute()) {
            header("Location: entregar_equipo.php?usuario_id=" . $_POST['usuario_id'] . "&success=true");
            exit();
        } else {
            header("Location: entregar_equipo.php?usuario_id=" . $_POST['usuario_id'] . "&error=true");
            exit();
        }
        $marcar_entrega_stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Entregar Equipo | ESFIM</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logos/esfim_logo.png" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left active">
                <a href="index.php" class="logo">
                    <img src="assets/img/logos/esfim_logo.png" alt="logo" />
                </a>
                <a href="index.php" class="logo-small">
                    <img src="assets/img/logos/esfim_logo.png" alt="logo" />
                </a>
                <a id="toggle_btn" href="javascript:void(0);"> </a>
            </div>
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="avatar" />
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="avatar" />
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6><?php echo htmlspecialchars($nombre); ?></h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="cerrar_sesion.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="logout-icon" />Cerrar Sesión</a>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="dashboard-icon" /><span>
                                    Dashboard</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/product.svg" alt="product-icon" /><span>
                                    Equipos</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="productlist.php">Lista Equipos</a></li>
                                <li><a href="addproducto.php">Agregar Equipo</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="users-icon" /><span>
                                    Usuarios</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="newuser.php">Nuevo Usuario</a></li>
                                <li><a href="userlists.php">Lista Usuarios</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="img" /><span>
                                    Usuarios Prestamos</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="newuser_prestamo.php">Nuevo Usuario </a></li>
                                <li><a href="userlists_prestamo.php">Lista Usuarios</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg" alt="settings-icon" /><span>
                                    Acciones</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="asignar_equipo.php">Asignar Equipo</a></li>
                                <li><a href="prestar_equipo.php">Prestar Equipo</a></li>
                                <li><a href="entregar_equipo.php">Entregar Equipo</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="historial.php"><img src="assets/img/icons/dashboard.svg" alt="img" /><span>
                                    Historial</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="historial_asignaciones.php">Asignaciones</a></li>
                                <li><a href="historial_prestamos.php">Prestamos</a></li>
                                <li><a href="historial_entregas.php">Entregas</a></li>
                            </ul>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <?php if (isset($_GET['success'])) : ?>
                    <div class="alert alert-success">Equipos entregados exitosamente.</div>
                <?php elseif (isset($_GET['error'])) : ?>
                    <div class="alert alert-danger">Hubo un error al procesar la entrega. Por favor, inténtelo de nuevo.</div>
                <?php endif; ?>

                <div class="page-title">
                    <h4>Entrega de Equipos</h4>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <form action="entregar_equipo.php" method="GET">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="usuario">Seleccionar Usuario</label>
                                    <select class="select form-control" name="usuario_id" id="usuario" onchange="this.form.submit()">
                                        <option value="">Seleccione un usuario</option>
                                        <?php foreach ($usuarios as $usuario) : ?>
                                            <option value="<?php echo $usuario['id']; ?>" <?php if ($usuario['id'] == $usuario_id) echo 'selected'; ?>><?php echo htmlspecialchars($usuario['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if ($usuario_id > 0) : ?>
                        <form action="procesar_entrega_todo.php" method="POST">
                            <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
                            <input type="hidden" name="equipos" id="equiposField">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if (count($prestamos) > 0) : ?>
                                        <div class="form-group">
                                            <label>Equipos a cargo</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Equipo</th>
                                                                <th>Cantidad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="equiposTableBody">
                                                            <?php foreach ($prestamos as $prestamo) : ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($prestamo['Nombre_equipo']); ?></td>
                                                                    <td><?php echo htmlspecialchars($prestamo['Cantidad_prestada']); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Observaciones</label>
                                                    <div class="card">
                                                        <textarea class="form-control" name="observaciones" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success" name="entregar_todo">Entregar Todo</button>
                                        </div>
                                    <?php else : ?>
                                        <div class="alert alert-info">El usuario seleccionado no tiene equipos a cargo.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    <?php else : ?>
                        <div class="alert alert-info">Seleccione un usuario para ver los equipos a entregar.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        $(document).ready(function() {
            // Llenar el campo oculto con los datos de los equipos cuando se envíe el formulario
            $('form').on('submit', function() {
                var equiposData = [];
                $('#equiposTableBody tr').each(function() {
                    var nombreEquipo = $(this).find('td').first().text();
                    var cantidad = $(this).find('td').last().text();
                    equiposData.push({
                        nombre: nombreEquipo,
                        cantidad: cantidad
                    });
                });

                $('#equiposField').val(JSON.stringify(equiposData));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inicializar Select2 para el select de usuarios
            $('#usuario').select2({
                placeholder: 'Seleccione un usuario',
                allowClear: true
            });
        });
    </script>

</body>

</html>