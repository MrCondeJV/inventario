<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['ID_Rol'];

include "./conexion.php";

// Obtener el ID del equipo a editar desde la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_equipo = $_GET['id'];

    // Consulta para obtener los datos del equipo por su ID
    $stmt = $mysqli->prepare("SELECT * FROM equipos WHERE id = ?");
    $stmt->bind_param("i", $id_equipo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $equipo = $resultado->fetch_assoc();

    // Verificar si se encontró el equipo
    if (!$equipo) {
        // Redirigir si no se encuentra el equipo
        header("Location: productlist.php");
        exit();
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Redirigir si no se proporciona un ID válido
    header("Location: productlist.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación y limpieza de datos recibidos del formulario
    $serie = trim($_POST['Serie']);
    $nombre_equipo = trim($_POST['Nombre']);
    $categoria = trim($_POST['Categoria']);
    $estado = trim($_POST['Estado']);
    $cantidad = trim($_POST['Cantidad']);

    // Subida de imagen si se proporciona una nueva
    if ($_FILES['Imagen']['size'] > 0) {
        $imagen = $_FILES['Imagen'];
        $upload_directory = 'uploads/';
        $target_file = $upload_directory . basename($imagen['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si es una imagen real o un archivo falso
        $check = getimagesize($imagen['tmp_name']);
        if ($check === false) {
            echo "El archivo no es una imagen.";
            exit();
        }

        // Verificar el tamaño del archivo
        if ($imagen['size'] > 500000) {
            echo "Lo siento, el tamaño del archivo es demasiado grande.";
            exit();
        }

        // Permitir ciertos formatos de archivo
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            exit();
        }

        // Si pasa todas las verificaciones, intenta subir el archivo
        if (move_uploaded_file($imagen['tmp_name'], $target_file)) {
            $imagen_url = $target_file;
        } else {
            echo "Hubo un error al subir tu archivo.";
            exit();
        }
    } else {
        // Si no se proporciona una nueva imagen, conservar la imagen actual
        $imagen_url = $equipo['Imagen'];
    }

    // Actualizar los datos del equipo en la base de datos
    $stmt = $mysqli->prepare("UPDATE equipos SET Serie=?, Nombre=?, Categoria=?, Estado=?, Cantidad=?, Imagen=? WHERE id=?");
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
        exit();
    }

    $stmt->bind_param("ssssisi", $serie, $nombre_equipo, $categoria, $estado, $cantidad, $imagen_url, $id_equipo);

    if ($stmt->execute()) {
        // Redirigir a la lista de equipos después de la actualización exitosa
        header("Location: productlist.php");
        exit();
    } else {
        echo "Hubo un problema al actualizar el equipo: " . $stmt->error;
    }

    // Cerrar la consulta preparada
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg" />
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
    </div>
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Editar Equipo</h4>
                    <h6>Actualiza tu equipo</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form  method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Cod. Serie</label>
                                    <input type="text" name="Serie" value="<?php echo htmlspecialchars($equipo['Serie']); ?>" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nombre Equipo</label>
                                    <input type="text" name="Nombre" value="<?php echo htmlspecialchars($equipo['Nombre']); ?>" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="select" name="Categoria">
                                        <option>Escoger Categoria</option>
                                        <option <?php if ($equipo['Categoria'] == 'Tecnologia') echo 'selected'; ?>>Tecnologia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="select" name="Estado">
                                        <option>Escoger Estado</option>
                                        <option <?php if ($equipo['Estado'] == 'Nuevo') echo 'selected'; ?>>Nuevo</option>
                                        <option <?php if ($equipo['Estado'] == 'Bueno') echo 'selected'; ?>>Bueno</option>
                                        <option <?php if ($equipo['Estado'] == 'Regular') echo 'selected'; ?>>Regular</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="text" name="Cantidad" value="<?php echo htmlspecialchars($equipo['Cantidad']); ?>" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Imagen de Equipo</label>
                                    <div class="image-upload">
                                        <input type="file" id="inputFile" name="Imagen" class="form-control">
                                        <div class="image-uploads">
                                            <img src="assets/img/icons/upload.svg" alt="img" />
                                            <h4>Arrastra y suelta un archivo para cargar</h4>
                                        </div>
                                    </div>
                                </div>
                                <div id="fileName"></div> <!-- Aquí se mostrará el nombre del archivo -->
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const inputFile = document.getElementById('inputFile');
                                    const fileNameDiv = document.getElementById('fileName');

                                    inputFile.addEventListener('change', function() {
                                        const file = this.files[0];
                                        fileNameDiv.textContent = file.name;
                                    });

                                    // Para el soporte de arrastrar y soltar
                                    inputFile.addEventListener('dragover', function(e) {
                                        e.preventDefault();
                                        this.classList.add('dragover');
                                    });

                                    inputFile.addEventListener('dragleave', function() {
                                        this.classList.remove('dragover');
                                    });

                                    inputFile.addEventListener('drop', function(e) {
                                        e.preventDefault();
                                        this.classList.remove('dragover');

                                        const file = e.dataTransfer.files[0];
                                        fileNameDiv.textContent = file.name;
                                    });
                                });
                            </script>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success me-2">Guardar</button>
                                <a href="productlist.php" class="btn btn-danger">Cancelar</a>
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
