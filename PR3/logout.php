<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;

$app->logout();

$contenidoPrincipal =  "<p>Sesión cerrada correctamente.<p>";

header('Location: index.php');

?>
