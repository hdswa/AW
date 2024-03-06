<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/utils.php';
require_once __DIR__.'/includes/Usuario.php'; 
require_once __DIR__.'/includes/Aplicacion.php'; 

$formEnviado = isset($_POST['registro']);
if (!$formEnviado) {
    header('Location: registro.php');
    exit();
}

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$nombreUsuario || empty($nombreUsuario = trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
    $erroresFormulario['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
}

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$nombre || empty($nombre = trim($nombre)) || mb_strlen($nombre) < 5) {
    $erroresFormulario['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$password || empty($password = trim($password)) || mb_strlen($password) < 5) {
    $erroresFormulario['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$password2 || empty($password2 = trim($password2)) || $password != $password2) {
    $erroresFormulario['password2'] = 'Los passwords deben coincidir';
}

if (count($erroresFormulario) === 0) {
    $usuarioCreado = Usuario::crea($nombreUsuario, $nombre, $password, "user"); // Asumiendo 'user' como rol por defecto
    if ($usuarioCreado) {
		//session_start();
        $_SESSION['login'] = true;
		$_SESSION['usuario_id'] = $usuarioCreado->getId();
        $_SESSION['nombre'] = $usuarioCreado->getNombre(); // O $_SESSION['nombre'] = $nombre; dependiendo de qué nombre quieras almacenar en la sesión
        $_SESSION['esAdmin'] = false; // Asume que todos los nuevos registros no son administradores
        header('Location: index.php');
        exit();
    } else {
        $erroresFormulario[] = "El usuario ya existe o no se pudo registrar";
    }
}
else{
	echo "hay errores";
}

// Código relacionado con la presentación de errores y el formulario de registro sigue aquí






/*
require_once __DIR__.'/includes/config.php';

$formEnviado = isset($_POST['registro']);
if (! $formEnviado ) {
	header('Location: registro.php');
	exit();
}

require_once __DIR__.'/includes/utils.php';

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
	$erroresFormulario['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
}

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombre || empty($nombre=trim($nombre)) || mb_strlen($nombre) < 5) {
	$erroresFormulario['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
	$erroresFormulario['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
	$erroresFormulario['password2'] = 'Los passwords deben coincidir';
}

if (count($erroresFormulario) === 0) {
	$conn = $app->getConexionBd();
	
	$query=sprintf("SELECT * FROM Usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows > 0 ) {
			$erroresFormulario[] = 'El usuario ya existe';
			$rs->free();
		} else {
			$query=sprintf("INSERT INTO Usuarios(nombreUsuario, nombre, password) VALUES('%s', '%s', '%s')"
					, $conn->real_escape_string($nombreUsuario)
					, $conn->real_escape_string($nombre)
					, password_hash($password, PASSWORD_DEFAULT)
			);
			if ( $conn->query($query) ) {
				$idUsuario = $conn->insert_id;
				$query=sprintf("INSERT INTO RolesUsuario(rol, usuario) VALUES(%d, %d)"
					, USER_ROLE
					, $idUsuario
				);
				if ( $conn->query($query) ) {
					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $nombre;
					$_SESSION['esAdmin'] = false;
					header('Location: index.php');
					exit();
				} else {
					echo "Error SQL ({$conn->errno}):  {$conn->error}";
					exit();
				}
			} else {
				echo "Error SQL ({$conn->errno}):  {$conn->error}";
				exit();
			}
		}		
	} else {
		echo "Error SQL ({$conn->errno}):  {$conn->error}";
		exit();
	}
}

$tituloPagina = 'Registro';

$erroresGlobalesFormulario = generaErroresGlobalesFormulario($erroresFormulario);
$erroresCampos = generaErroresCampos(['nombreUsuario', 'nombre', 'password', 'password2'], $erroresFormulario);
$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$erroresGlobalesFormulario
<form action="procesarRegistro.php" method="POST">
<fieldset>
	<legend>Datos para el registro</legend>
	<div>
		<label for="nombreUsuario">Nombre de usuario:</label>
		<input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
		{$erroresCampos['nombreUsuario']}
	</div>
	<div>
		<label for="nombre">Nombre:</label>
		<input id="nombre" type="text" name="nombre" value="$nombre" />
		{$erroresCampos['nombre']}
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
*/