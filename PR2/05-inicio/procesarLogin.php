<?php
require_once __DIR__.'/includes/config.php';

$formEnviado = isset($_POST['login']);
if (! $formEnviado ) {
	header('Location: login.php');
	exit();
}

require_once __DIR__.'/includes/utils.php';

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) ) {
	$erroresFormulario['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) ) {
	$erroresFormulario['password'] = 'El password no puede estar vacío.';
}

if (count($erroresFormulario) === 0) {
	$conn = $app->getConexionBd();
	
	$query=sprintf("SELECT * FROM Usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows == 0 ) {
			// No se da pistas a un posible atacante
			$erroresFormulario[] = "El usuario o el password no coinciden";
		} else {
			$fila = $rs->fetch_assoc();
			if ( ! password_verify($password, $fila['password'])) {
				$erroresFormulario[] = "El usuario o el password no coinciden";
			} else {
				$idUsuario = $fila['id'];

				$query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
				, $idUsuario
				);
				$rs = $conn->query($query);
				if ($rs) {
					$rolesRows = $rs->fetch_all(MYSQLI_ASSOC);
					$rs->free();
		
					$roles = [];
					foreach($rolesRows as $rol) {
						$roles[] = $rol['rol'];
					}
	
					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $fila['nombre'];
					$_SESSION['esAdmin'] = array_search(ADMIN_ROLE, $roles) !== false;
					header('Location: index.php');
					exit();
			
				} else {
					error_log("Error BD ({$conn->errno}): {$conn->error}");
				}
			}
		}
		$rs->free();
	} else {
		echo "Error SQL ({$conn->errno}):  {$conn->error}";
		exit();
	}
}

$tituloPagina = 'Login';

$erroresGlobalesFormulario = generaErroresGlobalesFormulario($erroresFormulario);
$erroresCampos = generaErroresCampos(['nombreUsuario', 'password'], $erroresFormulario);
$contenidoPrincipal= <<<EOS
<h1>Acceso al sistema</h1>
$erroresGlobalesFormulario
<form action="procesarLogin.php" method="POST">
<fieldset>
	<legend>Usuario y contraseña</legend>
	<div>
		<label for="nombreUsuario">Nombre de usuario:</label>
		<input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
		{$erroresCampos['nombreUsuario']}
	</div>
	<div>
		<label for="password">Password:</label>
		<input id="password" type="password" name="password" value="$password" />
		{$erroresCampos['password']}
	</div>
	<div>
		<button type="submit" name="login">Entrar</button>
	</div>
</fieldset>
</form>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
