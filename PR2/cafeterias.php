<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Título cafetrías';

$contenidoPrincipal = <<<EOS
<h1>Zen zest</h1>
<p> Contenido de cafeterías. </p>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
