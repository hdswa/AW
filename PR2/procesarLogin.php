<?php
require_once 'includes/config.php';
require_once 'includes/clases/usuario.php';

$tituloPagina = 'Inicia Sesión';

$nombre = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));


$usuario = Usuario::login($nombre, $password);

if (!$usuario) {
    $_SESSION['login'] = false;

} else {
    $_SESSION['login'] = true;
    $_SESSION['nombre'] = $usuario->getNombre();
    $_SESSION['rol'] = $usuario->getRol();
}

if ($_SESSION['login'] == true) {
    $mensaje = "Bienvenido/a ${_SESSION['nombre']}";
    echo "<meta http-equiv='refresh' content='0; url=index.php?mensaje=" . $mensaje . "'>";
} else {
    $mensaje = "El usuario o la contraseña no son válidos";
    echo "<meta http-equiv='refresh' content='0; url=login.php?mensaje=" . $mensaje . "'>";
}
?>