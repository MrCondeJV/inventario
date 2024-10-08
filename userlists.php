﻿<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}


$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

  <title>Lista Usuarios | ESFIM</title>

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
          <h4>Lista de usuarios</h4>
          <h6>Administra tu usuario</h6>
        </div>
        <div class="page-btn">
          <a href="newuser.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" />Agregar Usuarios</a>
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
                  <a data-bs-toggle="tooltip" href="generar_informe_usuarios.php" target="_blank" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img" /></a>
                </li>

              </ul>
            </div>
          </div>

          <div class="card" id="filter_inputs">
            <div class="card-body pb-0">
              <div class="row">
                <div class="col-lg-2 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="text" placeholder="Ingrese Documento" />
                  </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12">
                  <div class="form-group">
                    <input type="text" placeholder="Ingrese Nombre" />
                  </div>
                </div>
                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                  <div class="form-group">
                    <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg" alt="img" /></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table datanew">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Documento</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Unidad</th>
                  <th>Usuario</th>
                  <th>Rol</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "./conexion.php";
                $sql = $mysqli->query("SELECT * FROM usuarios");

                $contador = 1; // Inicializa el contador
                while ($datos = $sql->fetch_object()) { ?>
                  <tr>
                    <td><?php echo $contador; ?></td> <!-- Muestra el contador -->
                    <td><?php echo $datos->Documento; ?></td>
                    <td><?php echo $datos->Nombre; ?></td>
                    <td><?php echo $datos->Cargo; ?></td>
                    <td><?php echo $datos->Unidad; ?></td>
                    <td><?php echo $datos->Usuario; ?></td>
                    <td><?php echo $datos->ID_Rol; ?></td>
                    <td>
                      <a class="me-3" href="newuseredit.php?id=<?php echo $datos->id; ?>">
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








  <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/js/jquery.slimscroll.min.js"></script>

  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/plugins/select2/js/select2.min.js"></script>

  <script src="assets/js/moment.min.js"></script>
  <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

  <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
  <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

  <script src="assets/js/script.js"></script>


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
          window.location.href = `eliminar_usuario.php?id=${id}`;
        }
      });
    }
  </script>
</body>

</html>