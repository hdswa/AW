<?php

session_start();

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/Carrito.php';

if (!isset($_SESSION['nombre']) || !isset($_POST['owner'])) {
    die("Acceso denegado.");
}

$owner = $_POST['owner'];

// Asegúrate de que el usuario actual es el dueño del carrito
if ($_SESSION['nombre'] !== $owner) {
    die("Operación no permitida.");
}

$carrito = Carrito::getCarritoByOwner($owner);
if (!$carrito) {
    die("Carrito no encontrado.");
}

if ($carrito->realizarPago()) {
    echo "Compra realizada con éxito.";
    // Aquí puedes redirigir al usuario a una página de confirmación o al inicio
    // header('Location: confirmacionPago.php');
    exit;
} else {
    echo "Hubo un problema al realizar la compra.";
}