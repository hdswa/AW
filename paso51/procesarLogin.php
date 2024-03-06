

<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/utils.php';
require_once __DIR__.'/includes/Usuario.php'; // Asegúrate de incluir la clase Usuario
require_once __DIR__.'/includes/Aplicacion.php'; 

$formEnviado = isset($_POST['login']);
if (!$formEnviado) {
    header('Location: login.php');
    exit();
}

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$nombreUsuario || empty($nombreUsuario = trim($nombreUsuario))) {
    $erroresFormulario['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$password || empty($password = trim($password))) {
    $erroresFormulario['password'] = 'El password no puede estar vacío.';
}

if (count($erroresFormulario) === 0) {
    $usuario = Usuario::login($nombreUsuario, $password);
   
    if ($usuario) {
		//session_start();
        // Usuario autenticado correctamente
        $_SESSION['login'] = true;
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['esAdmin'] = $usuario->getRol() === 'admin'; // Asume que 'admin' es el rol administrativo
        echo  $_SESSION['login'] . $_SESSION['usuario_id'];
		header('Location: index.php');
        exit();
    } else {
        // Autenticación fallida
        $erroresFormulario[] = "El usuario o el password no coinciden";
    }
}

