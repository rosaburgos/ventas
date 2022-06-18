<?php
session_start();
include_once 'database.php';
if (!(isset($_SESSION['usuario']))) {
  header('Location: login.php');
}
$database = new Database();
$result = $database->get_data("SELECT * FROM productos");
if ($result['STATUS'] == 'OK') {
  $productos = $result['DATA'];
} else {
  $productos = [];
}

$productosSeleccionados = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $result = $database->get_data("SELECT * FROM productos WHERE id = " . $_POST['id']);
    http_response_code(200);
    echo (json_encode($result['DATA'][0]));
    return;
  } catch (\Throwable $th) {
    console_log($th->getMessage());
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
  <title>Inicio</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <link rel="stylesheet" href="css/estilos.css">
  <script defer src="materialize/js/materialize.min.js"></script>
  <script defer src="js/venta.js"></script>
</head>

<body>
  <div class="my-5 container d-flex flex-column justify-content-center">
    <div class="row btn-logout">
      <div class="col">
        <a href="logout.php" class="btn red">Cerrar sesión
          <i class="material-icons right">exit_to_app</i>
        </a>
      </div>
    </div>
    <h1 class="text-center">Productos en venta</h1>
    <div class="row">
      <?php foreach ($productos as $producto) { ?>
        <div class="col s4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $producto['nombre'] ?></h5>
              <p class="card-text"><?php echo "$" . number_format($producto['precio'], 2) ?></p>
              <p class="card-text"><?php echo "Disponible: " . $producto['cantidad'] ?></p>
              <a href="#" class="btn-floating btn-large waves-effect waves-light blue" onclick="addProduct(<?php echo $producto['id'] ?>)">
                <i class="material-icons btn-add">add</i>
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <h1 class="text-center">Listado de productos seleccionados</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Ref</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Precio</th>
          <th scope="col">Importe</th>
        </tr>
      </thead>
      <tbody id="tbody">
      </tbody>
      <tbody id="tbody2">
      </tbody>
    </table>
    <div class="btn-container">
      <button class="btn" onclick="comprar()">Comprar</button>
    </div>
  </div>
</body>

</html>