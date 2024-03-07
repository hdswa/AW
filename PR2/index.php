<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Portada';

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
	<h1>Bienvenido/a ${_SESSION['nombre']}</h1>
	<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam augue sem, molestie vel elementum quis, consequat consectetur velit. Sed malesuada in arcu quis placerat. Proin sed ligula leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer pretium, sapien ut ornare ornare, odio felis vulputate nisi, at hendrerit libero sapien ut sapien. Vestibulum laoreet auctor suscipit. Suspendisse id eros ut diam egestas luctus. Donec consequat, leo eu pretium sollicitudin, metus mi suscipit risus, non porta augue purus nec velit. Donec lobortis magna eget feugiat porttitor. In suscipit arcu quis urna lobortis dapibus.</p>
	EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
