<?php


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/usuario.php';



$tituloPagina = 'Perfil';
$contenidoPrincipal =<<<EOS
<h1>Perfil de Usuario</h1>
EOS;

if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre']; 
    $user = Usuario::buscaUsuario($nombreUsuario);

    
    if ($user) {
        $perfil = $user->perfilUsuario();
        $contenidoPrincipal .= $perfil;
    
    } else {
       $contenidoPrincipal .= "<p>Error al cargar el perfil del usuario.</p>";
    }


}
else {
    $contenidoPrincipal =  "<p>Por favor, <a href='login.php'>inicia sesión</a> para poder acceder a tu perfil.</p>";
}


    


require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';

