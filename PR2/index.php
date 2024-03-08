<?php


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/comentarios.php';
require_once __DIR__.'/includes/clases/usuario.php';

$tituloPagina = 'Inicio';
$nombreUsuario = $_SESSION['nombre']; // Asegúrate de que el usuario está logueado

$user = Usuario::buscaUsuario($nombreUsuario);
// Obtener los usuarios seguidos por el usuario actual
$usuariosSeguidos = $user->encontrarSeguidos();
// Obtener los comentarios de esos usuarios
$comentarios = Comentarios::getComentariosDeSeguidos($usuariosSeguidos);

$contenidoPrincipal = "<h1>Inicio</h1>";
$contenidoPrincipal = "<h2>Mira los ultimos comentarios realizados por tus amigos </h2>";

foreach ($comentarios as $comentario) {
    $contenidoPrincipal .= "<div class='comentario'>";
    $contenidoPrincipal .= "<h2>" . htmlspecialchars($comentario->getUsuario()) . "</h2>";
    $contenidoPrincipal .= "<p><b>Valoración:</b> " . htmlspecialchars($comentario->getValoracion()) . "/5</p>";
    $contenidoPrincipal .= "<p><b>Comentario:</b> " . htmlspecialchars($comentario->getMensaje()) . "</p>";
    $contenidoPrincipal .= "</div>";
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

