<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Perfil';
$contenidoPrincipal = <<<EOS
<h1>Perfil de Usuario</h1>
EOS;

if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $user =  \es\ucm\fdi\aw\usuarios\Usuario::buscaUsuario($nombreUsuario);


    if ($user) {
        $perfil = $user->perfilUsuario();
        $contenidoPrincipal .= $perfil;
        $formCambiarFotoPerfil = new \es\ucm\fdi\aw\usuarios\FormularioCambiarFotoPerfil($nombreUsuario);
        $formCambiarFotoPerfil = $formCambiarFotoPerfil->gestiona();
        $contenidoPrincipal .= $formCambiarFotoPerfil;

    } else {
        $contenidoPrincipal .= "<p>Error al cargar el perfil del usuario.</p>";
    }

    $contenidoPrincipal .= "<h1>Mis comentarios </h1>";
    $comentarios = \es\ucm\fdi\aw\comentarios\Comentarios::getComentariosPorUsuario($nombreUsuario);

    // Comprobar si la lista de comentarios está vacía
    if (empty($comentarios)) {
        $contenidoPrincipal .= "<p>Todavía no has realizado ningún comentario.</p>";
    } else {
        foreach ($comentarios as $comentario) {
            $contenidoPrincipal .= "<div class='comentario'>";
            $contenidoPrincipal .= "<h2>" . htmlspecialchars($comentario->getUsuario()) . "</h2>";
            $contenidoPrincipal .= "<h3> Cafeteria:" . htmlspecialchars($comentario->getCafeteriaComentada()) . "</h3>";
            $contenidoPrincipal .= "<p><b>Valoración:</b> " . htmlspecialchars($comentario->getValoracion()) . "/5</p>";
            $contenidoPrincipal .= "<p><b>Comentario:</b> " . htmlspecialchars($comentario->getMensaje()) . "</p>";
            $contenidoPrincipal .= "</div>";
        }
    }

} else {
    $contenidoPrincipal = "<p>Por favor, <a href='login.php'>inicia sesión</a> para poder acceder a tu perfil.</p>";
}




$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

