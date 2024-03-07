<?php
require_once 'includes/config.php';
require_once 'includes/clases/usuario.php';

$mensaje = "";


$nombre = htmlspecialchars(trim(strip_tags($_POST["nombre"])));
$password = htmlspecialchars(trim(strip_tags($_POST["password"])));

$usuario = Usuario::login($nombre, $password);

if (!$usuario ) {
    $_SESSION['login'] = false;
} else {
    $_SESSION['login'] = true;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['esAdmin'] = false;
}


if ($_SESSION['login'] == true) {
    $mensaje = "Bienvenido/a ${_SESSION['nombre']}";
    echo "<meta http-equiv='refresh' content='0; url=index.php?mensaje=" . $mensaje . "'>";
} else {
    $mensaje = "El usuario o la contraseña no son válidos";
    echo "<meta http-equiv='refresh' content='0; url=login.php?mensaje=" . $mensaje . "'>";
}


?>


