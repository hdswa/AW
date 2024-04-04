<?php

session_start();

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/Carrito.php';

$tituloPagina = 'Procesar Pago';

// Inicializa contenido principal vacío
$contenidoPrincipal = '';

if (!isset($_SESSION['nombre']) || !isset($_POST['owner'])) {
    $contenidoPrincipal .= "<h1>Acceso denegado.</h1>";
} else {
    $owner = $_POST['owner'];

    // Asegúrate de que el usuario actual es el dueño del carrito
    if ($_SESSION['nombre'] !== $owner) {
        $contenidoPrincipal .= "<h1>Operación no permitida.</h1>";
    } else {
        $carrito = Carrito::getCarritoByOwner($owner);
        if (!$carrito) {
            $contenidoPrincipal .= "<h1>Carrito no encontrado.</h1>";
        } else {
            if ($carrito->realizarPago()) {
                $contenidoPrincipal .= "<h1>Compra realizada con éxito.</h1>";
                // Opcional: Redirigir al usuario a una página de confirmación
                // header('Location: confirmacionPago.php');
                // exit;
            } else {
                $contenidoPrincipal .= "<h1>Hubo un problema al realizar la compra.</h1>";
            }
        }
    }
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
