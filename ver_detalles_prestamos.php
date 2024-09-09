<?php
session_start();
include "./conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id_prestamo = $_GET['id'];

    // Consulta para obtener los detalles del préstamo por su ID
    $sql = $mysqli->query("SELECT * FROM historial_prestamos WHERE id_prestamo = $id_prestamo");

    if ($sql->num_rows > 0) {
        $detalle = $sql->fetch_object();
    } else {
        echo "No se encontró el préstamo con ese ID.";
        exit();
    }
} else {
    echo "ID de préstamo no especificado.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <title>Detalle prestamo | ESFIM</title>

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
                    <img src="assets/img/logos/LOGO ESFIM SUB.png" alt="" width="50px" />
                </a>
                <a href="index.php" class="logo-small">
                    <img src="assets/img/logos/LOGO ESFIM SUB.png" alt="" width="50px" />
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
                        <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="" />
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="" />
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6><?php
                                        echo $nombre;

                                        ?></h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="cerrar_sesion.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img" />Cerrar Sesión</a>
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
                            <a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="img" /><span>
                                    Dashboard</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/product.svg" alt="img" /><span>
                                    Equipos</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="productlist.php">Lista Equipos</a></li>
                                <li><a href="addproducto.php">Agregar Equipo</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="img" /><span>
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
                            <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg" alt="img" /><span>
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
                <div class="page-title">
                    <h4>Detalles del Préstamo</h4>
                    <h6>Información detallada de los equipos prestados por <?php echo htmlspecialchars($detalle->Nombre_usuario); ?></h6>
                </div>
            </div>
            <div class="container">
                <h2>Detalles del Préstamo</h2>
                <table class="table table-bordered">
                    <tr>
                        <th>ID del Préstamo:</th>
                        <td><?php echo $detalle->id; ?></td>
                    </tr>
                    <tr>
                        <th>Código del Préstamo:</th>
                        <td><?php echo $detalle->id_prestamo; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre del Usuario:</th>
                        <td><?php echo $detalle->Nombre_usuario; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha del Préstamo:</th>
                        <td><?php echo $detalle->Fecha_prestamo; ?></td>
                    </tr>
                    <!-- Agrega más detalles según tu tabla de préstamos -->
                </table>
                <a href="historial_prestamos.php" class="btn btn-primary">Volver al Historial</a>
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
</body>

</html>