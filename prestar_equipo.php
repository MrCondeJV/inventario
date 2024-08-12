<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];

include "./conexion.php";

// Obtener la lista de equipos de la base de datos
$equipos = [];
if ($equipos_stmt = $mysqli->prepare("SELECT id, Nombre FROM equipos")) {
    $equipos_stmt->execute();
    $equipos_result = $equipos_stmt->get_result();
    while ($row = $equipos_result->fetch_assoc()) {
        $equipos[] = $row;
    }
    $equipos_stmt->close();
}

// Obtener la lista de usuarios de la base de datos
$usuarios = [];
if ($usuarios_stmt = $mysqli->prepare("SELECT id, nombre FROM usuarios")) {
    $usuarios_stmt->execute();
    $usuarios_result = $usuarios_stmt->get_result();
    while ($row = $usuarios_result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $usuarios_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Prestar Equipo | ESFIM</title>
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
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
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
                            <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg" alt="settings-icon" /><span>
                                    Acciones</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="prestar_equipo.php">Prestar Equipo</a></li>
                                <li><a href="entregar_equipo.php">Entregar Equipo</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Préstamo de Equipos</h4>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <form action="procesar_prestamo.php" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="usuario">Seleccionar Usuario</label>
                                    <select class="select form-control" name="usuario_id" id="usuario">
                                        <?php foreach ($usuarios as $usuario) : ?>
                                            <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="buscarEquipo">Buscar por Nombre de Equipo</label>
                                    <input type="text" class="form-control" id="buscarEquipo" placeholder="Ingrese el nombre del equipo">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Seleccionar Equipos</label>
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
                                                    <?php foreach ($equipos as $equipo) : ?>
                                                        <tr>
                                                            <td>
                                                                <label>
                                                                    <input class="form-check-input" type="checkbox" name="equipos[<?php echo $equipo['id']; ?>][seleccionado]" value="1">
                                                                    <?php echo htmlspecialchars($equipo['Nombre']); ?>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" name="equipos[<?php echo $equipo['id']; ?>][cantidad]" min="1" value="1">
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Recomendaciones tecnicas</label>
                                    <div class="card">

                                        <textarea class="form-control" name="recomendaciones" rows="3"></textarea>


                                    </div>
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

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success me-2">Prestar</button>
                                <a href="index.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>



                </div>
                </form>



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
        // Filtrar equipos dinámicamente por nombre
        $(document).ready(function() {
            $('#buscarEquipo').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('#equiposTableBody tr').each(function() {
                    var nombreEquipo = $(this).find('label').text().toLowerCase();
                    if (nombreEquipo.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    
</body>

</html>