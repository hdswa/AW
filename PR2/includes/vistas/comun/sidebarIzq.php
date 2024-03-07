<?php
require_once 'includes/config.php';
require_once 'includes/clases/usuario.php';
$status = 0;
if (isset($_SESSION["login"]) && ($_SESSION["login"] == true)){ // Logged In
    $status = 1;
}

?>

<nav id="sidebarIzq">
	<ul>
		<li><a href="<?= RUTA_APP ?>/index.php">Inicio</a></li>
		<li><a href="<?= RUTA_APP ?>/seguidos.php">Seguidos</a></li>
		<li><a href="<?= RUTA_APP ?>/cafeterias.php">Cafeterias</a></li>
		<?php
			if ($status == 0) {
				echo ' <a href="./login.php">
							Iniciar Sesión
							</a> <br> <br>';
			} else {
				echo ' <a href="./logout.php">
							Cerrar Sesión
							</a> <br> <br> ';
			}

		?>
	</ul>
</nav>
