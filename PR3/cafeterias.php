<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Título cafetrías';
// $cafeterias = Cafeteria::getAllCafe(); // Assuming getCafeterias() is a function that returns an array of cafeterias
$cafeterias = \es\ucm\fdi\aw\cafeterias\Cafeteria::getAllCafe();

$contenidoPrincipal = <<<EOS
<h1>Zen zest</h1>
EOS;


if (isset($_SESSION['nombre'])) {

    //session [user]cafeteria si existe poner tu cafeteria sino poner quieres crear tu propia cafeteria
    $contenidoPrincipal .= '<div class="grid-container" style="display:flex;">';
    foreach ($cafeterias as $cafeteria) {
        $foto_URL=".";
        $foto_URL.=$cafeteria->getFoto();
        
        $nombre = $cafeteria->getNombre();
        //foto cuadrada 200px
        $contenidoPrincipal .= "<div class='cafeteria-item'>";
        $contenidoPrincipal .="<img src='$foto_URL' alt='Image description' style='max-width: 200px; max-height: 200px;'>";
        $contenidoPrincipal .="<h2><a href='cafeteriaDetail.php?name=$nombre'>$nombre</a></h2>";
        $contenidoPrincipal .= "</div><br>";
    }
    $contenidoPrincipal .= '</div>';
}else {
    $contenidoPrincipal =  "<p>Por favor, <a href='login.php'>inicia sesión</a> para poder acceder a las cafeterías disponibles.</p>";
}


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);