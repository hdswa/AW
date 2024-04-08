<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/producto.php';
$tituloPagina = 'Añadir nuevo producto';
        $contenidoPrincipal = <<<EOS
        <h1>Añade tu nuevo producto</h1>
        <p>Para añadir un nuevo producto rellane el siguiente formulario</p>

        <form action="procesarAddProducto.php" method="post" enctype='multipart/form-data'>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" re+quired><br>
            <label for="precio">precio en €:</label>
            <input type="number" id="precio" name="precio" required><br>
            <label for="descripcion">descripcion:</label>
            <input type="text" id="descripcion" name="descripcion" required><br>
            <label for="foto">Foto:</label>
            <input type='file' name='foto' required>
            <input type="submit" value="Añadir Producto">
        </form>
        EOS;
require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>