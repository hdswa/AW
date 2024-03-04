<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Ver contenido</title>
</head>

<body>

<div id="contenedor">

<?php
	require('cabecera.php');
	require('sidebarIzq.php');
?>

<main>
	<article>
	<?php
		if (!isset($_SESSION['login'])) {
			echo "<h1>Usuario no registrado!</h1>";
			echo "<p>Debes iniciar sesión para ver el contenido</p>";
		} else {
	?>
		<h1>Automóviles olvidados</h1>
		<p>  Automóviles olvidados  Automóviles olvidados   Automóviles olvidados </p>
        <p>  Automóviles olvidados  Automóviles olvidados   Automóviles olvidados </p>
        <p>  Automóviles olvidados  Automóviles olvidados   Automóviles olvidados </p>
	<?php
		}
	?>
	</article>
</main>
<?php

	require('sidebarDer.php');
	require('pie.php');

?>
</div>

</body>
</html>