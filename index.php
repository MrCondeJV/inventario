<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];

include "./conexion.php";

// Consultar cantidad de préstamos
$sql_prestamos = $mysqli->query("SELECT COUNT(*) AS total_registros FROM prestamos");
$datos_prestamos = $sql_prestamos->fetch_object()->total_registros;

// Consultar cantidad de entregas
$sql_entregas = $mysqli->query("SELECT COUNT(*) AS total_registros FROM entregas");
$datos_entregas = $sql_entregas->fetch_object()->total_registros;

// Consultar cantidad de asignaciones
$sql_asignaciones = $mysqli->query("SELECT COUNT(*) AS total_registros FROM asignaciones");
$datos_asignaciones = $sql_asignaciones->fetch_object()->total_registros;

// Cerrar la conexión
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <title>Dashboard | ESFIM</title>

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
                  <h6><?php echo $nombre; ?></h6>
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

    <!-- Main content starts here -->
    <div class="page-wrapper">
      <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row">
            <div class="col-sm-12">
              <h3 class="page-title">Dashboard</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item active">Inicio</li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <div class="container-fluid">
          <div class="row">
            <!-- PRESTAMOS TOTALES -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Prestamos Totales
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $datos_prestamos; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-handshake fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ENTREGAS TOTALES -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Entregas Totales
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $datos_entregas; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-box-open fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ASIGNACIONES TOTALES -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Asignaciones Totales
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $datos_asignaciones; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Donut Chart -->



        <div class="card shadow">
        <h5 class="card-title text-center mb-4" style="font-size: 2.7rem;">Distribución Total</h5>
          <div class="card-body">
            
            <canvas id="myChart"></canvas>
          </div>
        </div>

        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/feather.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
        <script src="assets/plugins/apexchart/chart-data.js"></script>
        <script src="vendor/chart.js/Chart.min.js"></script>
        <script src="assets/js/script.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Page level custom scripts -->
        <script>
          var ctx = document.getElementById('myChart').getContext('2d');
          var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ["Prestamos", "Entregas", "Asignaciones"],
              datasets: [{
                label: 'Totales',
                data: [<?php echo $datos_prestamos; ?>, <?php echo $datos_entregas; ?>, <?php echo $datos_asignaciones; ?>],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
              }],
            },
            options: {
              maintainAspectRatio: false,
              responsive: true,
              animation: {
                duration: 3000, // Duración de la animación en milisegundos
                easing: 'easeOutBounce', // Tipo de curva de animación
                animateRotate: true, // Animar la rotación
                animateScale: true, // Animar la escala
              },
              tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
              },
              legend: {
                display: true
              },
              cutoutPercentage: 80,
            }
          });
        </script>

</body>

</html>