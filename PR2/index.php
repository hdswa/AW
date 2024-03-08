<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/Comentarios.php';

$tituloPagina = 'Comentarios Recientes';
$nombreUsuario = $_SESSION['nombre']; // Asegúrate de que el usuario está logueado

$user = Usuario::buscaUsuario($nombreUsuario);
// Obtener los usuarios seguidos por el usuario actual
$usuariosSeguidos = $user->encontrarSeguidos();
// Obtener los comentarios de esos usuarios
$comentarios = Comentarios::getComentariosDeSeguidos($usuariosSeguidos);

$contenidoPrincipal = "<h1>Comentarios Recientes de Usuarios Seguidos</h1>";

foreach ($comentarios as $comentario) {
    $contenidoPrincipal .= "<div class='comentario'>";
    $contenidoPrincipal .= "<h2>Comentado por: " . htmlspecialchars($comentario->getUsuario()) . "</h2>";
    $contenidoPrincipal .= "<p>Valoración: " . htmlspecialchars($comentario->getValoracion()) . "</p>";
    $contenidoPrincipal .= "<p>" . htmlspecialchars($comentario->getMensaje()) . "</p>";
    $contenidoPrincipal .= "</div>";
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

