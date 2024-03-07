<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css" />
</head>
<body>
<div id="contenedor">
<?php
if(!isset($mensaje))
	$mensaje = "";
if(isset($_GET['mensaje'])){
    $mensaje = $_GET['mensaje'];}
require(RAIZ_APP.'/vistas/comun/cabecera.php');
require(RAIZ_APP.'/vistas/comun/sidebarIzq.php');
?>
	<div class="container">	
	<main>
		<article>
			
			<?= $contenidoPrincipal ?>
		</article>
	</main>
</div>
<?php

require(RAIZ_APP.'/vistas/comun/pie.php');
?>
</div>
</body>
</html>
