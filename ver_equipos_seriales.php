<?php
session_start();
include "./conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id_equipo = $_GET['id'];

    // Consulta para obtener los detalles de los equipos por serial
    $sql = $mysqli->query("SELECT * FROM equipos_especificos WHERE id_equipo = $id_equipo");

    if ($sql->num_rows > 0) {
        $detalle = $sql->fetch_object();
    } else {
        echo "No se encontraron equipos con ese ID de referencia.";
        exit();
    }
} else {
    echo "ID de equipo no especificado.";
    exit();
}

$id_equipo = $detalle->id_equipo;

// Obtener los equipos con seriales a partir de un equipo general 
$equipos = [];
if ($id_equipo > 0) {
    $equipos_stmt = $mysqli->prepare("
    SELECT e.Nombre, ee.serial 
    FROM equipos_especificos ee
    INNER JOIN equipos e ON ee.id_equipo = e.id
    WHERE e.id = ?
    ");

    if ($equipos_stmt) {
        $equipos_stmt->bind_param("i", $id_equipo);
        $equipos_stmt->execute();
        $equipos_result = $equipos_stmt->get_result();
        $equipos = $equipos_result->fetch_all(MYSQLI_ASSOC);
        $equipos_stmt->close();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <title>Detalle asignacion | ESFIM</title>

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
                        <span class="user-img"><img src="assets/img/profiles/avatarsoldado.jpg" alt="" />
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avatarsoldado.jpg" alt="" />
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
                    <h4>Lista de Equipos por serial</h4>
                    <div class="page-btn">
                        <a href="productlist.php" class="btn"><img src="assets/img/icons/back.svg" alt="img" class="me-1" /></a>
                    </div>
                </div>
                <div class="page-btn">
                    <a href="add_equipo_especifico.php?id=<?php echo $id_equipo; ?>" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-1" />Agregar Serial</a>
                </div>

            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">

                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img" /></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img" /></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Serial</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "./conexion.php";

                                // Cambiamos la consulta para obtener el nombre
                                $sql = $mysqli->query("
        SELECT ee.id, ee.serial, e.Nombre 
        FROM equipos_especificos ee
        INNER JOIN equipos e ON ee.id_equipo = e.id
        WHERE ee.id_equipo = $id_equipo
    ");

                                $contador = 1; // Inicializa el contador
                                while ($datos = $sql->fetch_object()) { ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td> <!-- Muestra el contador -->
                                        <td><?php echo $datos->Nombre; ?></td> <!-- Muestra el nombre -->
                                        <td><?php echo $datos->serial; ?></td>
                                        <td>
                                            <a class="me-3" href="edit_equipo_especifico.php?id=<?php echo $datos->id; ?>">
                                                <img src="assets/img/icons/edit.svg" alt="img" />
                                            </a>
                                            <a class="me-3" href="javascript:void(0);" onclick="confirmDeletion(<?php echo $datos->id; ?>)">
                                                <img src="assets/img/icons/delete.svg" alt="img" />
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $contador++; // Incrementa el contador en cada iteración
                                } ?>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡Este cambio no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir a la página de eliminación si el usuario confirma
                    window.location.href = `eliminar_equipo_especifico.php?id=${id}`;
                }
            });
        }
    </script>

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