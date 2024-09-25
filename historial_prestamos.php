<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}


$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];


// Incluir la conexión a la base de datos
include "./conexion.php";

// Verificar si se ha enviado una búsqueda
$nombre_equipo = isset($_POST['nombre_equipo']) ? $_POST['nombre_equipo'] : '';

// Construir la consulta SQL
$sql_query = "SELECT * FROM historial_prestamos";

// Si se ha ingresado un nombre de equipo, agregar la cláusula WHERE
if (!empty($nombre_equipo)) {
  $sql_query .= " WHERE Equipo LIKE '%$nombre_equipo%'";
}

$sql = $mysqli->query($sql_query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <title>Historial Prestamos | ESFIM</title>

  //Logo De plataforma
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
              <a href="javascript:void(0);"><img src="assets/img/icons/dashboard.svg" alt="img" /><span>
                  Historial</span>
                <span class="menu-arrow"></span></a>
              <ul>
                <li><a href="historial_asignaciones.php">Asignaciones</a></li>
                <li><a href="historial_prestamos.php">Prestamos</a></li>
                <li><a href="historial_entregas.php">Entregas</a></li>
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
          <h4>Historial de Prestamos</h4>
          <h6>Lista de prestamos</h6>
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

          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
            Buscar por Equipos
          </button>

          <div class="table-responsive">
            <table class="table datanew">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Codigo Prestamo</th>
                  <th>Prestamista</th>
                  <th>Fecha prestamo</th>
                  <th>Accion</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "./conexion.php";
                $sql = $mysqli->query("SELECT * FROM prestamos");

                $contador = 1; // Inicializa el contador
                while ($datos = $sql->fetch_object()) { ?>
                  <tr>
                    <td><?php echo $contador; ?></td> <!-- Muestra el contador -->
                    <td><?php echo $datos->Cod_prestamo; ?></td>
                    <td><?php echo $datos->Nombre_usuario; ?></td>
                    <td><?php echo $datos->Fecha_prestamo; ?></td>
                    <td>
                      <a href="ver_detalles_prestamos.php?id=<?php echo $datos->id; ?>">
                        <img src="assets/img/icons/eye.svg" alt="img" />
                      </a>
                      <a href="uploads/<?php echo $datos->docPdf; ?>" download>
                        <img src="assets/img/icons/download.svg" alt="img" />
                      </a>
                    </td>
                  </tr>
                <?php
                  $contador++; // Incrementa el contador en cada iteración
                } ?>
              </tbody>

            </table>


            <!-- Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Buscar Prestamos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- Formulario de búsqueda -->
                    <form id="searchForm" onsubmit="return false;">
                      <div class="col-lg-4 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="nombre_equipo" class="form-control" placeholder="Ingrese Nombre del Equipo" oninput="searchPrestamos()" />
                        </div>
                      </div>
                    </form>

                    <!-- Tabla de resultados -->
                    <div class="table-responsive mt-3">
                      <table class="table datanew" id="resultsTable">
                        <thead>
                          <tr>
                            <th>Código Prestamo</th>
                            <th>Asignado A</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Los resultados se llenarán aquí mediante AJAX -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
    function searchPrestamos() {
      const input = document.querySelector('input[name="nombre_equipo"]');
      const filter = input.value;

      // Realizar la búsqueda mediante AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "search_prestamos.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          document.querySelector('#resultsTable tbody').innerHTML = this.responseText;
        }
      };
      xhr.send("nombre_equipo=" + encodeURIComponent(filter));
    }
  </script>


  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/jquery.slimscroll.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
  <script src="assets/plugins/apexchart/chart-data.js"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>