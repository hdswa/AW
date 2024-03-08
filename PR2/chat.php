<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Chat';

$contenidoPrincipal = <<<EOS
EOS;

$contenidoPrincipal = '';

if (!isset($_SESSION["login"])) {
	$contenidoPrincipal .= <<<EOS
	<h1>Usuario no registrado!</h1>
	<p>Debes iniciar sesión para ver el contenido...</p>
	EOS;
} else {
	$contenidoPrincipal .= <<<EOS
	<h1>Chats de {$_SESSION['nombre']}</h1>
	<p> Listado de chats </p>
	EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
