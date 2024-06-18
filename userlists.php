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
        <a href="index.html" class="logo">
          <img src="assets/img/logos/esfim_logo.png" alt="" />
        </a>
        <a href="index.html" class="logo-small">
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
              <hr class="m-0" />
              <a class="dropdown-item" href="profile.html">
                <i class="me-2" data-feather="user"></i> Mi Perfil</a>
              <a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Configuracion</a>
              <hr class="m-0" />
              <a class="dropdown-item logout pb-0" href="login.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img" />Cerrar Sesión</a>
            </div>
          </div>
        </li>
      </ul>

      <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="profile.html">My Profile</a>
          <a class="dropdown-item" href="generalsettings.html">Settings</a>
          <a class="dropdown-item" href="cerrar_sesion.php">Logout</a>
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
                  Configuracion</span>
                <span class="menu-arrow"></span></a>
              <ul>
                <li><a href="generalsettings.php">General Settings</a></li>
              </ul>
            </li>
          </ul>
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

        <div class="card">
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
                  <tr>
                    <?php
                    include "./conexion.php";
                    $sql = $mysqli->query("SELECT * FROM usuarios");
                    while ($datos = $sql->fetch_object()) { ?>
                      <td><?php echo $datos->id ?></td>
                      <td><?php echo $datos->Documento ?></td>
                      <td><?php echo $datos->Nombre ?></td>
                      <td><?php echo $datos->Cargo ?></td>
                      <td><?php echo $datos->Unidad ?></td>
                      <td><?php echo $datos->Usuario ?></td>
                      <td><?php echo $datos->ID_Rol ?></td>
                      <td>
                        <a class="me-3" href="newuseredit.php">
                          <img src="assets/img/icons/edit.svg" alt="img" />
                        </a>
                        <a class="me-3 confirm-text" href="eliminar_usuario.php?id=<?php echo $datos->id; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                          <img src="assets/img/icons/delete.svg" alt="img" />
                        </a>
                      </td>
                  </tr>
                <?php }
                ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showpayment" tabindex="-1" aria-labelledby="showpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Show Payments</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Reference</th>
                  <th>Amount</th>
                  <th>Paid By</th>
                  <th>Paid By</th>
                </tr>
              </thead>
              <tbody>
                <tr class="bor-b1">
                  <td>2022-03-07</td>
                  <td>INV/SL0101</td>
                  <td>$ 1500.00</td>
                  <td>Cash</td>
                  <td>
                    <a class="me-2" href="javascript:void(0);">
                      <img src="assets/img/icons/printer.svg" alt="img" />
                    </a>
                    <a class="me-2" href="javascript:void(0);" data-bs-target="#editpayment" data-bs-toggle="modal" data-bs-dismiss="modal">
                      <img src="assets/img/icons/edit.svg" alt="img" />
                    </a>
                    <a class="me-2 confirm-text" href="javascript:void(0);">
                      <img src="assets/img/icons/delete.svg" alt="img" />
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createpayment" tabindex="-1" aria-labelledby="createpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Payment</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Customer</label>
                <div class="input-group">
                  <input type="text" value="2022-03-07" class="datetimepicker" />
                  <a class="scanner-set input-group-text">
                    <img src="assets/img/icons/datepicker.svg" alt="img" />
                  </a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Reference</label>
                <input type="text" value="INV/SL0101" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Received Amount</label>
                <input type="text" value="1500.00" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Paying Amount</label>
                <input type="text" value="1500.00" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Payment type</label>
                <select class="select">
                  <option>Cash</option>
                  <option>Online</option>
                  <option>Inprogress</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label>Note</label>
                <textarea class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-submit">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editpayment" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Payment</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Customer</label>
                <div class="input-group">
                  <input type="text" value="2022-03-07" class="datetimepicker" />
                  <a class="scanner-set input-group-text">
                    <img src="assets/img/icons/datepicker.svg" alt="img" />
                  </a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Reference</label>
                <input type="text" value="INV/SL0101" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Received Amount</label>
                <input type="text" value="1500.00" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Paying Amount</label>
                <input type="text" value="1500.00" />
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Payment type</label>
                <select class="select">
                  <option>Cash</option>
                  <option>Online</option>
                  <option>Inprogress</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label>Note</label>
                <textarea class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-submit">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
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
</body>

</html>