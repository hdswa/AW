<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

function mostrarSaludo()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new \es\ucm\fdi\aw\usuarios\FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido,{$nombreUsuario}". $htmlLogout;
      
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;
}

?>
<header>
<a href="index.php" class="logo"><img src="./img/basic/logo_sinfondo.png" name="logo" width="75"></a>
    <div class="icons">
        <a href="chat.php"><img src="./img/basic/comentarios.png" name="comentarios" width="50"></a>
        <a href="carrito.php"><img src="./img/basic/cesta.png" name="cesta" width="50"></a>
        <a href="perfil.php"><img src="./img/basic/user.png" name="login" width="50"></a>
    </div>
    <div class="saludo">
        <?= mostrarSaludo() ?>
    </div>
</header>