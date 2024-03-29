<?php


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/comentarios.php';
require_once __DIR__.'/includes/clases/usuario.php';

$tituloPagina = 'Inicio';

$contenidoPrincipal = "<h1>Inicio</h1>";
if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $user = Usuario::buscaUsuario($nombreUsuario);
    // Obtener los usuarios seguidos por el usuario actual
    $usuariosSeguidos = $user->encontrarSeguidos();

   
    if ($usuariosSeguidos == []) {
        $contenidoPrincipal .= "<p>Todavía no sigues a nadie. Comienza a seguir a otros perfiles para ver valoraciones y comentarios aquí.</p>";
    } else {

        // Obtener los comentarios de esos usuarios
        $comentarios = Comentarios::getComentariosDeSeguidos($usuariosSeguidos);


        $contenidoPrincipal = "<h2>Echa un vistazo a los últimos comentarios realizados por tus amigos:</h2>";

        foreach ($comentarios as $comentario) {
            $contenidoPrincipal .= "<div class='comentario'>";
            $contenidoPrincipal .= "<h2>" . htmlspecialchars($comentario->getUsuario()) . "</h2>";
            $contenidoPrincipal .= "<h3> Cafeteria:" . htmlspecialchars($comentario->getCafeteriaComentada()) . "</h3>";
            $contenidoPrincipal .= "<p><b>Valoración:</b> " . htmlspecialchars($comentario->getValoracion()) . "/5</p>";
            $contenidoPrincipal .= "<p><b>Comentario:</b> " . htmlspecialchars($comentario->getMensaje()) . "</p>";
            $contenidoPrincipal .= "</div>";
        }
    }
}else {
    $contenidoPrincipal =  "<p>Por favor, <a href='login.php'>inicia sesión</a> para poder acceder a tu perfil.</p>";
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

