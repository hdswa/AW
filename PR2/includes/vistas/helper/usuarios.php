<?php
require_once 'autorizacion.php';

function saludo()
{
    $html = '';

    if (estaLogado()) {
        $urlLogout = Utils::buildUrl('/logout.php');
        $html = <<<EOS
        Hola, {$_SESSION['nombre']}. Si quieres puedes <a href="{$urlLogout}"> cerrar sesión</a>
        EOS;
    } else {
        $urlLogin = Utils::buildUrl('/login.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$urlLogin}">Login</a>
        EOS;
    }

    return $html;
}


function logout()
{
    //Doble seguridad: unset + destroy
    unset($_SESSION['username']);
    //unset($_SESSION['roles']);
    unset($_SESSION['nombre']);
    
    session_destroy();
    session_start();
}
