<?php
use es\ucm\fdi\aw\Aplicacion;

require_once __DIR__.'/includes/config.php';
$cafeterias = \es\ucm\fdi\aw\cafeterias\Cafeteria::getAllCafe();
$tituloPagina = 'Inicio';

$contenidoPrincipal="";
if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin']=1){
  $contenidoPrincipal.="<h1>Bienvenido administrador</h1> <br>";
  $contenidoPrincipal.="<h2>Puedes usar la opción de arriba a la derecha para acceder al panel de control de administrador</h2>";
}
else{

  if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre'];

    $usuariosSeguidos = $app->getUsuariosSeguidos($nombreUsuario);  // Asume que esta función existe y devuelve un array de objetos Usuario


    // Deberías inicializar la variable aquí para asegurarte de que tiene un valor base.
    $contenidoPrincipal = "<h1>Inicio</h1>";


    if (empty($usuariosSeguidos)) {
      $contenidoPrincipal =  "<p>Aún no sigues a ningún usuario.<p>";
    }
    else{
      $comentariosSeguidos = es\ucm\fdi\aw\comentarios\Comentarios::getComentariosDeSeguidos($usuariosSeguidos);


      $comentariosHTML = "<div class='comentarios-seccion'>";
      foreach ($comentariosSeguidos as $comentario) {
          $comentariosHTML .= "<div class='comentario'>";
          $comentariosHTML .= "<h4>" . htmlspecialchars($comentario->getUsuario()) . "</h4>";
          $comentariosHTML .= "<h5>" . htmlspecialchars($comentario->getCafeteriaComentada()) . "</h5>";

          $comentariosHTML .= "<p>" . htmlspecialchars($comentario->getMensaje()) . "</p>";
          $comentariosHTML .= "<p>Valoración: " . htmlspecialchars($comentario->getValoracion()) . " estrellas</p>";
          $comentariosHTML .= "</div>";
      }
      $comentariosHTML .= "</div>";
      $contenidoPrincipal .= $comentariosHTML;

    }
  }
  else{
    $contenidoPrincipal = "<h1>Bienvenido a Zen Zest!</h1>";
    $contenidoPrincipal .= "<h2>Por favor, <a href='login.php'>inicia sesión</a> o <a href='registro.php'>regístrate</a> para acceder a todo el contenido.</h2>";
    $contenidoPrincipal .= "<p>Aquí puedes ver alguna de las cafeterías que están disponibles por tu zona.</p>";

    $contenidoPrincipal .= '<div class="cafeterias">';
    $i = 0; // Contador para controlar el número de cafeterías por fila
    foreach ($cafeterias as $cafeteria) {
        if ($i % 2 == 0) {
          // Si es el primer elemento de la fila, añadir etiqueta de apertura de fila
          $contenidoPrincipal .= '<div class="fila">';
        }
        $foto_URL=".";
        $foto_URL.=$cafeteria->getFoto();
        
        $nombre = $cafeteria->getNombre();

        $contenidoPrincipal .= "<div class='cafeteria'>";
        $contenidoPrincipal .="<img src='$foto_URL'>";
        $contenidoPrincipal .="<h2><a href='cafeterias.php'>$nombre</a></h2>";
        $contenidoPrincipal .= "</div>";

        $i++;

        if ($i % 2 == 0 || $i == count($cafeterias)) {
            // Si es el último elemento de la fila o el último elemento en general, añadir etiqueta de cierre de fila
            $contenidoPrincipal .= '</div>';
        }
    }
    $contenidoPrincipal .= '</div>';
  }
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

