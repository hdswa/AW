<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/carrito.php';

$tituloPagina = 'Título Cambiar';
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
    
    $contenidoPrincipal .="<h2>$item_name----$item_price €----$item_quantity uds---SUM: $item_subtotal € </h2>";
    
  }
  $total=$carrito->getPrecioFinal();
  $contenidoPrincipal .= "<h2>Total: $total €</h2>";
  $contenidoPrincipal.="<h3>añadir boton de pagar con JS o un form y poder quitar items de tu lista</h3>";
  }
  catch(Exception $e){
    echo "An error occurred: " . $e->getMessage();
  }
} else {
  $contenidoPrincipal .="No tienes items en el carrito haga una compra";
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>
