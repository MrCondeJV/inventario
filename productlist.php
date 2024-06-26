<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol']
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
 
  <title>Lista Equipos | ESFIM</title>

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
            <h4>Lista de Equipos</h4>
            <h6>Administra tus equipos</h6>
          </div>
          <div class="page-btn">
            <a href="addproducto.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-1" />Agregar Equipo</a>
          </div>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <div class="table-top">
              <div class="search-set">
                <div class="search-path">
                  <a class="btn btn-filter" id="filter_search">
                    <img src="assets/img/icons/filter.svg" alt="img" />
                    <span><img src="assets/img/icons/closes.svg" alt="img" /></span>
                  </a>
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
                  <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img" /></a>
                  </li>
                  <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img" /></a>
                  </li>
                </ul>
              </div>
            </div>

            <div class="card mb-0" id="filter_inputs">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="row">
                      <div class="col-lg col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option>Choose Product</option>
                            <option>Macbook pro</option>
                            <option>Orange</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option>Choose Category</option>
                            <option>Computers</option>
                            <option>Fruits</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option>Choose Sub Category</option>
                            <option>Computer</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option>Brand</option>
                            <option>N/D</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option>Price</option>
                            <option>150.00</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-1 col-sm-6 col-12">
                        <div class="form-group">
                          <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg" alt="img" /></a>
                        </div>
                      </div>
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
                    <th>Cod. Serie</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                    include "./conexion.php";
                    $sql = $mysqli->query("SELECT * FROM equipos");
                    while ($datos = $sql->fetch_object()) { ?>
                      <td><?php echo $datos->id ?></td>
                      <td><?php echo $datos->Serie ?></td>
                      <td><?php echo $datos->Nombre ?></td>
                      <td><?php echo $datos->Categoria ?></td>
                      <td><?php echo $datos->Estado ?></td>
                      <td><?php echo $datos->Cantidad ?></td>
                      <td>
                        <img src="<?php echo $datos->Imagen ?>" alt="Imagen" class="img-thumbnail" style="width: 60px; height: 60px;">
                      </td>
                      <td>
                        <a class="me-3" href="editproduct.php?id=<?php echo $datos->id  ?>">
                          <img src="assets/img/icons/edit.svg" alt="img" />
                        </a>
                        <a class="me-3 confirm-text" href="eliminar_equipo.php?id=<?php echo $datos->id; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?');">
                          <img src="assets/img/icons/delete.svg" alt="img" />
                        </a>
                      </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
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