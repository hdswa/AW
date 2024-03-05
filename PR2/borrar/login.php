<?php

require_once './includes/config.php';
require_once './includes/helper/login.php';
require_once './includes/helper/usuarios.php';


$tituloPagina = 'Login';

$htmlFormLogin = buildFormularioLogin();
$logado = estaLogado();
$saludo=saludo();
if ($logado){
    $contenidoPrincipal=<<<EOS
    <h1>Acceso al sistema</h1>
    $saludo
    EOS;
}
else {
    $contenidoPrincipal=<<<EOS
    <h1>Acceso al sistema</h1>
    $htmlFormLogin
    EOS;
}

require 'includes/vistas/comun/layout.php';
