<?php

function estaLogado()
{
    return isset($_SESSION['nombre']);
}

function esMismoUsuario($username)
{
    return estaLogado() && $_SESSION['nombre'] == $nombre;
}

function usernameLogado()
{
    return $_SESSION['nombre'] ?? false;
}

function esAdmin(){
    return estaLogado() && $_SESSION['rol']=='admin';
}

function verificaLogado($urlNoLogado)
{
    if (! estaLogado()) {
        Utils::redirige($urlNoLogado);
    }
}
