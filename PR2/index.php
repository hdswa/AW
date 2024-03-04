<?php session_start() ?>
<!DOCTYPE html>

<html lang = "es">
	<head>
		<link rel="stylesheet" type="text/css" href="estilo.css" />
		<meta charset="utf-8">
		<title>Portada</title>
	</head>

	<body>

		<div id="contenedor"> <!-- Inicio del contenedor -->

			<?php
				require_once 'vistas/cabecera.php';
				require_once 'vistas/sidebarIzq.php';
			?>
			<main>
			<article>
				<h1>Página principal</h1>
			</article>
			</main>
			
		</div> <!-- Fin del contenedor -->

	</body>
</html>