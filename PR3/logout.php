<?php
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION['username']);
//unset($_SESSION['roles']);
unset($_SESSION['nombre']);

session_destroy();
session_start();

$contenidoPrincipal =  "<p>Sesión cerrada correctamente.<p>";

header('Location: index.php');

?>
