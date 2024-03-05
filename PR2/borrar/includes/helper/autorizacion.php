<?php

function estaLogado()
{
    return isset($_SESSION['username']);
}

function esMismoUsuario($username)
{
    return estaLogado() && $_SESSION['username'] == $username;
}

function usernameLogado()
{
    return $_SESSION['username'] ?? false;
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
