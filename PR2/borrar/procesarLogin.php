<?php

require_once 'includes/config.php';
require_once 'includes/helper/usuarios.php';
require_once 'includes/helper/autorizacion.php';
require_once 'includes/helper/login.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;
$loged = Usuario::login($username, $password);
$usuario = Usuario::buscaUsuario($username);
if (!$loged) {
	$htmlFormLogin = buildFormularioLogin($username, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'includes/vistas/comun/layout.php';
	exit();
}

$_SESSION['username'] = $usuario->username;
$_SESSION['rol'] = $usuario->rol;
$_SESSION['nombre'] = $usuario->nombre;

if($_SESSION['rol'] == "usuario"){
	$contenidoPrincipal=<<<EOS
		<h1>Bienvenido ${_SESSION['nombre']}</h1>
		<p>Usa el menú superior para navegar.</p>
	EOS;
}
else if($_SESSION['rol'] == "admin"){
	$contenidoPrincipal=<<<EOS
		<h1>Bienvenido ${_SESSION['nombre']}</h1>
		<p>Selecciona en el menú superior lo que quieras gestionar.</p>
	EOS;
}

require 'includes/vistas/comun/layout.php';
