<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

$app = Aplicacion::getInstance();

$status = 0;
if (isset($_SESSION["login"]) && ($_SESSION["login"] == true)){ // Logged In
    $status = 1;
}

?>

<header>
<a href="index.php" class="logo"><img src="./img/basic/logo_sinfondo.png" name="logo" width="75"></a>

    <a href="<?= RUTA_APP ?>/index.php">Inicio</a> <br> <br>
		<a href="<?= RUTA_APP ?>/seguidos.php">Seguidos</a> <br> <br>
		<a href="<?= RUTA_APP ?>/cafeterias.php">Cafeterías</a> <br> <br>
		
		<?php
			if ($status == 0) {	
				echo ' <a href="./login.php">
				Iniciar sesión
				</a> <br> <br>';
			} 
			else {
				echo ' <a href="' . RUTA_APP . '/cafeteriaDetail.php?owner=' . (isset($_SESSION['nombre']) ? urlencode($_SESSION['nombre']) : '') . '">
				Mi cafetería
				</a> <br> <br>';
				echo ' <a href="./logout.php">
				Cerrar sesión
				</a> <br> <br>';
			}

			if(isset($_SESSION['esAdmin'])&&$_SESSION['esAdmin']=1){
				?>
					<a href="<?= RUTA_APP ?>/admin.php">Panel de Administrador</a> <br> <br>
				<?php
	
				}
	
		?>
    
    <div class="icons">
        <a href="carrito.php"><img src="./img/basic/cesta.png" name="cesta" width="50"></a>
        <a href="perfil.php"><img src="./img/basic/user.png" name="login" width="50"></a>
    </div>
</header>

