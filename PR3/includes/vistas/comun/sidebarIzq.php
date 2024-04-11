<?php
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

$app = Aplicacion::getInstance();

$status = 0;
if (isset($_SESSION["login"]) && ($_SESSION["login"] == true)){ // Logged In
    $status = 1;
}

?>

<nav id="sidebarIzq">
	<ul>
		<li><a href="<?= RUTA_APP ?>/index.php">Inicio</a></li>
		<li><a href="<?= RUTA_APP ?>/seguidos.php">Seguidos</a></li>
		<li><a href="<?= RUTA_APP ?>/cafeterias.php">Cafeterías</a></li>
		
		<?php
			if ($status == 0) {	
				echo ' <a href="./login.php">
				Iniciar sesión
				</a> <br> <br>';
			} 
			else {
				echo ' <a href="' . RUTA_APP . '/carrito.php?name=' . (isset($_SESSION['nombre']) ? urlencode($_SESSION['nombre']) : '') . '">
				Carrito
				</a> <br> <br>';
				echo ' <a href="' . RUTA_APP . '/cafeteriaDetail.php?owner=' . (isset($_SESSION['nombre']) ? urlencode($_SESSION['nombre']) : '') . '">
				Mi cafetería
				</a> <br> <br>';
				echo ' <a href="./logout.php">
				Cerrar sesión
				</a> <br> <br> ';
			}

		?>
	</ul>
</nav>
