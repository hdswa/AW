<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/cafeteria.php';
$tituloPagina = 'Título cafetrías';
$cafeterias = Cafeteria::getAllCafe(); // Assuming getCafeterias() is a function that returns an array of cafeterias

$contenidoPrincipal = <<<EOS
<h1>Zen zest</h1>
EOS;

//session [user]cafeteria si existe poner tu cafeteria sino poner quieres crear tu propia cafeteria
$contenidoPrincipal .= '<div class="grid-container">';
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
require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';