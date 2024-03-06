<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/cafeteria.php';
// Get the value of the 'name' parameter from the URL
$name = $_GET['name'];

$contenidoPrincipal = <<<EOS
<h1>$name</h1>
EOS;
require __DIR__.'/includes/vistas/plantillas/plantilla.php';



?>