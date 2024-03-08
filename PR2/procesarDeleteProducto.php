<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/producto.php';

$name = $_GET['productoName'];
$owner = $_GET['cafeName'];

$producto = Producto::getProductoByNameAndOwner($name,$owner);
$producto->deleteByNameAndOwner($name,$owner);

unset($producto); // Free the variable
header('Location: cafeteriaDetail.php?name='.$owner);

?>