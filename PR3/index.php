<?php
use es\ucm\fdi\aw\Aplicacion;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';

$nombreUsuario = $_SESSION['nombre'];

$usuariosSeguidos = $app->getUsuariosSeguidos($nombreUsuario);  // Asume que esta función existe y devuelve un array de objetos Usuario


// Deberías inicializar la variable aquí para asegurarte de que tiene un valor base.
$contenidoPrincipal = "<h1>Página principal</h1>";


if (empty($usuariosSeguidos)) {
  $contenidoPrincipal =  "<p>No hay usuarios seguidos o la función no devuelve datos válidos.<p>";
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

$tituloPagina = 'Portada';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

