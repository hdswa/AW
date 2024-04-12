<?php
use es\ucm\fdi\aw\Aplicacion;

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Portada';

if (isset($_SESSION['nombre'])) {
  $nombreUsuario = $_SESSION['nombre'];

  $usuariosSeguidos = $app->getUsuariosSeguidos($nombreUsuario);  // Asume que esta función existe y devuelve un array de objetos Usuario


  // Deberías inicializar la variable aquí para asegurarte de que tiene un valor base.
  $contenidoPrincipal = "<h1>Página principal</h1>";


  if (empty($usuariosSeguidos)) {
    $contenidoPrincipal =  "<p>No sigues todavia a ningun usuario.<p>";
  }
  else{
    $comentariosSeguidos = es\ucm\fdi\aw\comentarios\Comentarios::getComentariosDeSeguidos($usuariosSeguidos);


    $comentariosHTML = "<div class='comentarios-seccion'>";
    foreach ($comentariosSeguidos as $comentario) {
        $comentariosHTML .= "<div class='comentario'>";
        $comentariosHTML .= "<h4>Comentado por: " . htmlspecialchars($comentario->getUsuario()) . "</h4>";
        $comentariosHTML .= "<p>" . htmlspecialchars($comentario->getMensaje()) . "</p>";
        $comentariosHTML .= "<p>Valoración: " . htmlspecialchars($comentario->getValoracion()) . " estrellas</p>";
        $comentariosHTML .= "</div>";
    }
    $comentariosHTML .= "</div>";
    $contenidoPrincipal .= $comentariosHTML;

  }
}
else{
  $contenidoPrincipal = "<p>Por favor, <a href='login.php'>inicia sesión</a> para acceder al contenido.</p>";
}



$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

