<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
<form action="procesarRegistro.php" method="POST">
<fieldset>
	<legend>Datos para el registro</legend>
	
	<div>
		<label for="username">Username:</label>
		<input id="username" type="text" name="username" />
	</div>
	<div>
		<label for="email">Email:</label>
		<input id="email" type="text" name="email" />
	</div>
	<div>
		<label for="password">Password:</label>
		<input id="password" type="password" name="password" />
	</div>
	<div>
		<label for="password2">Reintroduce el password:</label>
		<input id="password2" type="password" name="password2" />
	</div>
	<div>
		<button type="submit" name="registro">Registrar</button>
	</div>
</fieldset>
</form>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
