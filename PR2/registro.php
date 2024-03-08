<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
<h1>Crear cuenta</h1>
<form action="procesarRegistro.php" method="POST">
<fieldset>
	<legend>Datos para el registro</legend>
	
	<div>
		<label for="username">Usuario:</label>
		<input id="username" type="text" name="username" placeholder="Usuario" />
	</div>
	<div>
		<label for="email">Email:</label>
		<input id="email" type="text" name="email" placeholder="Email"/>
	</div>
	<div>
		<label for="password">Contraseña:</label>
		<input id="password" type="password" name="password" placeholder="Contraseña"/>
	</div>
	<div>
		<label for="password2">Reintroduce la contraseña:</label>
		<input id="password2" type="password" name="password2" placeholder="Contraseña"/>
	</div>
	<div>
		<button type="submit" name="registro">CREAR CUENTA</button>
	</div>
</fieldset>
</form>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
