<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" /></head>
<body>
<?= $mensajes ?>
<div id="contenedor">
<?php
$params['app']->doInclude('/vistas/comun/cabecera.php');

?>
	<main>
	<?php $params['app']->doInclude('/vistas/comun/sidebarIzq.php'); ?>
		<div class="main">

			<?= $params['contenidoPrincipal'] ?>
		</div>
	</main>
<?php
?>
</div>
</body>
</html>
