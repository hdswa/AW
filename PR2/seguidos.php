<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Seguidos';

$contenidoPrincipal = <<<EOS
<h1>Zen zest</h1>
<p> Contenido de seguidos. </p>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
