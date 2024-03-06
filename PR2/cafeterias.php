<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/cafeteria.php';
$tituloPagina = 'Título cafetrías';
$cafeterias = cafeteria::getAllCafe(); // Assuming getCafeterias() is a function that returns an array of cafeterias

$contenidoPrincipal = <<<EOS
<h1>Zen zest</h1>
EOS;
$contenidoPrincipal .= '<div class="grid-container">';
foreach ($cafeterias as $cafeteria) {
    $nombre = $cafeteria->getNombre();
   
    $contenidoPrincipal .="<h2><a href='cafeteriaDetail.php?name=$nombre'>$nombre</a></h2>";
    $contenidoPrincipal.="<br>";
}
$contenidoPrincipal .= '</div>';
require __DIR__.'/includes/vistas/plantillas/plantilla.php';