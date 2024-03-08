<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/carrito.php';

$tituloPagina = 'Carrito';
$name= $_GET['name'];

$carrito = Carrito::getCarritoByOwner($name);

$contenidoPrincipal = <<<EOS
  <h1>Carrito de $name</h1>
  EOS;
// Check if getCarritoByOwner returned a Carrito object or a message
if (is_a($carrito, 'Carrito')) {
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
  $contenidoPrincipal .= <<<HTML
    <form action="realizarPago.php" method="post">
        <input type="hidden" name="owner" value="$name">
        <input type="submit" value="Pagar">
    </form>
  HTML;
  }
  catch(Exception $e){
    echo "An error occurred: " . $e->getMessage();
  }
} else {
  $contenidoPrincipal .="No tienes items en el carrito haga una compra";
}

require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';


