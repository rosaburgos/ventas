<?php
include_once 'database.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  try {
    $database = new Database(); 
    $productosSeleccionados = json_decode($_POST['selectedProducts']);
    $idVenta = random_int(1, 99999999);
    $usuarioId = $_SESSION['usuario'];
    console_log($usuarioId);
    foreach ($productosSeleccionados as $producto) {
      $sql = "Insert into ventas (id, usuario, producto, cantidad ) values ($idVenta, '$usuarioId', $producto->id, $producto->cantidad)";      
      $database->exec($sql);      
      $sql2 = "Update productos set cantidad = cantidad - $producto->cantidad where id = $producto->id";
      $database->exec($sql2); 
    }
  } catch (\Throwable $th) {  
    console_log($sql);
    console_log($th->getMessage() . "Error");
  }  
}