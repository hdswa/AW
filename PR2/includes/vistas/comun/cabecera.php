<?php

require_once __DIR__.'/../helper/usuarios.php';

?>
<header>
<<<<<<< Updated upstream
	<a href="index.php" class="logo"><img src="img/basic/logo_sinfondo.png" name="logo" width="75"></a>

	<div class="icons">
        <a href="comentarios.php"><img src="img/basic/comentarios.png" name="comentarios" width="50"></a>

        <a href="cesta.php"><img src="img/basic/cesta.png" name="cesta" width="50"></a>

        <a href="login.php"><img src="img/basic/user.png" name="login" width="50"></a>
=======
	<a href="index.php" class="logo"><img src="./img/basic/logo_sinfondo.png" name="logo" width="75"></a>
    <div class="icons">
        <a href="comentarios.php"><img src="./img/basic/comentarios.png" name="comentarios" width="50"></a>
        <a href="carrito.php"><img src="./img/basic/cesta.png" name="cesta" width="50"></a>
        <a href="perfil.php"><img src="./img/basic/user.png" name="login" width="50"></a>
    </div>
    <div class="saludo">
        <?= mostrarSaludo() ?>
>>>>>>> Stashed changes
    </div>
</header>