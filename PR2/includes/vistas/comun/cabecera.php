<?php
function mostrarSaludo() {
	$rutaApp = RUTA_APP;
	$html='';
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		$html = "Bienvenido, {$_SESSION['nombre']} <a href='{$rutaApp}/logout.php'>Cerrar sesión</a>";
	} else {
		$html = "Usuario desconocido. <a href='{$rutaApp}/login.php'>Iniciar sesión</a> <a href='{$rutaApp}/registro.php'>Registro</a>";
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