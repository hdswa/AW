<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Aplicacion.php';
require_once __DIR__.'/includes/clases/usuario.php';

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);


$formEnviado = isset($_POST['registro']);
if (! $formEnviado ) {
	header('Location: registro.php');
	exit();
}

require_once __DIR__.'/includes/utils.php';

$erroresFormulario = [];


$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $username || empty($username=trim($username)) || mb_strlen($username) < 5) {
	$erroresFormulario['username'] = 'El username tiene que tener una longitud de al menos 5 caracteres.';
}
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $email || empty($email=trim($email)) || mb_strlen($email) < 5) {
	$erroresFormulario['username'] = 'El email tiene que tener una longitud de al menos 5 caracteres.';
}
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
	$erroresFormulario['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
	$erroresFormulario['password2'] = 'Los passwords deben coincidir';
}

if (count($erroresFormulario) === 0) {//register
	$foto="";
	$user = new Usuario($username, $email, $password, $foto);

	if ($user->register($username, $email, $password, $foto)) {
		// $_SESSION['login'] = true;
		// $_SESSION['nombre'] = $nombre;
		// $_SESSION['esAdmin'] = false;
		header('Location: index.php');
		exit();
	} else {
		$erroresFormulario[] = 'El usuario ya existe';
	}
	
}

if ($_SESSION["login"] == true) {
    $mensaje = "Bienvenido/a {$_SESSION["nombre"]}";
    echo "<meta http-equiv='refresh' content='0; url=index.php?mensaje=" . $mensaje . "'>";
} else {
    $mensaje = "Usuario erróneo";
    echo "<meta http-equiv='refresh' content='0; url=login.php?mensaje=" . $mensaje . "'>";
}

$tituloPagina = 'Registro';

$erroresGlobalesFormulario = generaErroresGlobalesFormulario($erroresFormulario);
$erroresCampos = generaErroresCampos(['username', 'email', 'password', 'password2'], $erroresFormulario);
$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$erroresGlobalesFormulario
<form action="procesarRegistro.php" method="POST">
<fieldset>
	<legend>Datos para el registro</legend>
	<div>
		<label for="username">email de usuario:</label>
		<input id="username" type="text" name="username" value="$username" />
		{$erroresCampos['username']}
	</div>
	<div>
		<label for="email">email:</label>
		<input id="email" type="text" name="email" value="$email" />
		{$erroresCampos['email']}
	</div>
	<div>
		<label for="password">Password:</label>
		<input id="password" type="password" name="password" value="$password" />
		{$erroresCampos['password']}
	</div>
	<div>
		<label for="password2">Reintroduce el password:</label>
		<input id="password2" type="password" name="password2" value="$password2" />
		{$erroresCampos['password2']}
	</div>
	<div>
		<button type="submit" name="registro">Registrar</button>
	</div>
</fieldset>
</form>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
