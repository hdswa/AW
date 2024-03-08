<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);


require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/Carrito.php';

// Comprueba que el usuario está logueado y que el nombre del producto y la cantidad están establecidos
if (!isset($_SESSION['nombre']) || !isset($_POST['nombreProducto']) || !isset($_POST['cantidad'])) {
    // No logueado o falta información; redirigir o mostrar error
    die("Acción inválida.");
}

$owner = $_SESSION['nombre'];
$nombreProducto = $_POST['nombreProducto'];
$precio = $_POST['precioProducto'];
$cantidad = (int) $_POST['cantidad'];

// Intenta obtener el carrito del usuario. Si no existe, crea uno nuevo.
$carrito = Carrito::getCarritoByOwner($owner);
if ($carrito === false) {
    // Carrito no encontrado, crea un nuevo carrito vacío
    $carrito = new Carrito($owner, json_encode([]), 0);
}

// Construye el nuevo item
$nuevoItem = json_encode([
    "Nombre" => $nombreProducto,
    "Cantidad" => $cantidad,
    // Aquí deberías incluir una lógica para obtener el precio real del producto desde la base de datos
    "Precio" => $precio
]);

// Añade el nuevo producto al carrito
try {
    $carrito->addItem($nuevoItem);
    
    // Guarda el carrito actualizado en la base de datos
    if (!$carrito->save()) {
        throw new Exception("Error al guardar el carrito.");
    }

    // Redirige al usuario de vuelta al carrito
    header('Location: carrito.php?name=' . urlencode($owner));
    exit;
} catch (Exception $e) {
    echo "Ocurrió un error al añadir el producto al carrito: " . $e->getMessage();
    // Considera agregar manejo adecuado de errores aquí
}
