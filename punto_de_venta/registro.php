<?php
session_start();
include_once 'database.php';
if (isset($_SESSION['usuario'])) {
  header('Location: index.php');
}
$database = new Database();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
  try {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['password'];
    $password2 = $_POST['password2'];
    if ($contrasena != $password2) {
      throw new Exception('Las contraseñas no coinciden');
    }
    $hashPassword = password_hash($contrasena, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (usuario, nombre, contrasena) VALUES ('$usuario', '$nombre', '$hashPassword')";
    $res = $database->exec($sql);
    if ($res) {
        $ret['STATUS'] = "OK";
        header('Location: login.php');
    } else {
        $ret['ERROR'] = $mysqli->error;
    }
  } catch (\Throwable $th) {
    echo $th->getMessage() . " error";
    return;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <script defer src="materialize/js/materialize.min.js"></script>
  <title>Registro</title>
</head>

<body>
  <!-- Registro con bootstrap -->
  <div class="container">
    <h1 class="center-align">Registro</h1>
    <form class="form-horizontal" action="" method="post">
      <div class="form-group row">
        <label for="usuario" class="col-sm-2 control-label">Usuario</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
        </div>
      </div>
      <div class="form-group row">
        <label for="nombre" class="col-sm-2 control-label">Nombre Completo</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre">
        </div>
      </div>
      <div class="form-group row">
        <label for="password" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
      </div>
      <div class="form-group row">
        <label for="password2" class="col-sm-2 control-label">Confirmar Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmar Password">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn green btn-default">Registrarse</button>
        </div>
      </div>
    </form>
    <a class="waves-effect waves-light btn" href="login.php">Iniciar sesion</a>
  </div>
</body>

</html>