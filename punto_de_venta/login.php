<?php
include_once 'database.php';
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
$database = new Database();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['password'];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $res = $database->get_data($sql);

        if ($res['STATUS'] == 'OK') {
            $row = $res['DATA'][0];
            $verifyPassword = password_verify($contrasena, $row['contrasena']);
            if ($verifyPassword) {
                session_start();
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                header('Location: index.php');
            } else {
                echo '<script>alert("Contraseña incorrecta");</script>';
            }
        } else {
            echo 'Usuario no existe';
        }
    } catch (\Throwable $th) {
        echo $th->getMessage() . " error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script defer src="materialize/js/materialize.min.js"></script>
</head>

<body>
    <h1 class="center-align">Login</h1>
    <div class="container">
        <form action="" method="post">
            <!-- Form materialize css -->
            <div class="row">
                <div class="input-field col s12">
                    <input id="usuario" type="text" name="usuario" class="validate">
                    <label for="usuario">Usuario</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" name="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button class="btn waves-effect waves-light green" type="submit" name="action">Iniciar sesion
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <a class="waves-effect waves-light btn" href="registro.php">Registrarse</a>
    </div>
</body>

</html>