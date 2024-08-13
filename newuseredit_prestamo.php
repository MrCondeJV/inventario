<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];

include "./conexion.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id_usuario = $_GET['id'];

  $stmt = $mysqli->prepare("SELECT * FROM usuarios_prestamo WHERE id = ?");
  $stmt->bind_param("i", $id_usuario);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $usuario = $resultado->fetch_assoc();

  if (!$usuario) {
    header("Location: userlists_prestamo.php");
    exit();
  }

  $stmt->close();
} else {
  header("Location: userlists_prestamo.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $Documento = trim($_POST['Documento']);
  $Nombre = trim($_POST['Nombre']);
  $Cargo = trim($_POST['Cargo']);
  $Unidad = trim($_POST['Unidad']);
 

  // Validar campos
  if (empty($Documento) || empty($Nombre) || empty($Cargo) || empty($Unidad)) {
    echo "Todos los campos son obligatorios.";
  } else {
    // Actualizar el usuario en la base de datos
    $stmt = $mysqli->prepare("UPDATE usuarios_prestamo SET documento = ?, nombre = ?, cargo = ?, unidad  = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $Documento, $Nombre, $Cargo, $Unidad, $id_usuario);

    if ($stmt->execute()) {
      header("Location: userlists_prestamo.php");
      exit();
    } else {
      echo "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

  <title>Editar Usuario | ESFIM</title>

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
          <img src="assets/img/logos/esfim_logo.png" alt="" />
        </a>
        <a href="index.php" class="logo-small">
          <img src="assets/img/logos/esfim_logo.png" alt="" />
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
          <h4>Administracion de Usuarios de prestamo</h4>
          <h6>Editar/Actualizar Usuario</h6>
        </div>
      </div>
      <div class="card shadow">
        <div class="card-body">
          <form method="post" action="">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Documento</label>
                  <input type="text" name="Documento" value="<?php echo htmlspecialchars($usuario['documento']); ?>" />
                </div>
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="Nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" />
                </div>
                <div class="form-group">
                  <label>Cargo</label>
                  <input type="text" name="Cargo" value="<?php echo htmlspecialchars($usuario['cargo']); ?>" />
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Unidad</label>
                  <input type="text" name="Unidad" value="<?php echo htmlspecialchars($usuario['unidad']); ?>" />
                </div>
              
              <div class="col-lg-12">
                <button type="submit" class="btn btn-success me-2">Guardar</button>
                <a href="userlists_prestamo.php" class="btn btn-danger">Cancelar</a>
              </div>
            </div>
          </form>
        </div>
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
</body>

</html>