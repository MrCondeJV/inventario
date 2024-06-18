<?php
session_start();
require "./conexion.php";


if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT ID, Nombre, Usuario, contrasena, ID_Rol FROM usuarios WHERE Usuario = '$usuario' ";
    $resultado = $mysqli->query($sql);
    $num = $resultado->num_rows;

    if ($num > 0) {

        $row = $resultado->fetch_assoc();
        $password_bd = $row['contrasena'];
        $pass_c = sha1($password);


        if ($password_bd == $pass_c) {

            $_SESSION['id'] = $row['ID'];
            $_SESSION['nombre'] = $row['Nombre'];
            $_SESSION['ID_Rol'] = $row['ID_Rol'];
            header("Location: index.php");
        } else {
            echo "La contraseña es Incorrecta!!";
        }
    } else {
        echo "No existe Usuario";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="assets/img/logos/esfim_logo.png" alt="img">
                        </div>
                        <div class="login-userheading">
                            <h3>Iniciar Sesión</h3>
                            <h4>Por favor, ingrese a su cuenta</h4>
                        </div>
                        <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-login">
                                <label>Usuario</label>
                                <div class="form-addons">
                                    <input type="text" placeholder="Ingrese su usuario" name="usuario">
                                    <img src="assets/img/icons/users1.svg" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Contraseña</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input" placeholder="Ingrese su contraseña" name="password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login btn-primary btn-user btn-block ">
                                Iniciar Sesión
                            </button>
                        </form>

                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>