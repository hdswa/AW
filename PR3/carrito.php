<?php

require_once __DIR__.'/includes/config.php';



$tituloPagina = 'Carrito';
$name= $_SESSION['nombre'];

$contenidoPrincipal="";

if(isset($_GET['success'])){
  $contenidoPrincipal .= "<h1>Compra realizada con éxito.</h1>";
}
else{
  


$carrito = \es\ucm\fdi\aw\carrito\Carrito::getCarritoByOwner($name);

$contenidoPrincipal = <<<EOS
  <h1>Carrito de $name</h1>
  EOS;

if (isset($_SESSION['nombre'])) {
    if(!$carrito){
      $contenidoPrincipal .="No tienes productos en el carrito, añade alguno!";
    }
    else{
    try{
    
    $lista = $carrito->getItemList();
    $itemList = json_decode($lista, true);
    foreach ($itemList as $item) {
      $item_name=$item['Nombre'];
      $item_price=$item['Precio'];
      $item_quantity=$item['Cantidad'];
      $item_subtotal=$item_price*$item_quantity;
      
      $contenidoPrincipal .="<h5><bold>$item_name</bold> :  $item_price € x $item_quantity uds  =  $item_subtotal € </h5>";
      
    }
    $total=$carrito->getPrecioFinal();
    $contenidoPrincipal .= "<h4>Total: $total €</h4>";
    $formularioPago = new \es\ucm\fdi\aw\carrito\FormularioPagar($name);
    $formularioPago = $formularioPago->gestiona();
    $contenidoPrincipal .= $formularioPago;
    // $contenidoPrincipal .= <<<HTML
    //   <form action="realizarPago.php" method="post">
    //       <input type="hidden" name="owner" value="$name">
    //       <input type="submit" value="Pagar">
    //   </form>
    // HTML;
    }
    catch(Exception $e){
      echo "An error occurred: " . $e->getMessage();
    }
  }
  
}else {
  $contenidoPrincipal =  "<p>Por favor, <a href='login.php'>inicia sesión</a> para poder acceder a tu carrito.</p>";
}
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);


