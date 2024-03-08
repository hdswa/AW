

<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/producto.php';
require_once __DIR__.'/includes/clases/cafeteria.php';
$tituloPagina = 'Título Cambiar';
$name= $_GET['name'];
$productos = Producto::getCafeAllItemsByOwner($name); // Assuming getCafeterias() is a function that returns an array of cafeterias
$cafeteria= Cafeteria::getCafeteriaByName($name);

if ($cafeteria==false){
    $tituloPagina = 'Cafeteria no encontrada';
    $contenidoPrincipal = <<<EOS
    <h1>No tienes una cafeteria propia</h1>
    <p>Para montar tu propia cafeteria rellane el siguiente formulario</p>
    <form action="crearCafeteria.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="descripcion">Descripcion:</label>
        <input type="text" id="descripcion" name="descripcion" required><br>
        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" required><br>
        <label for="ubicacion">Ubicacion:</label>
        <input type="text" id="ubicacion" name="ubicacion" required><br>
        <label for="foto">Foto:</label>
        <input type="text" id="foto" name="foto" required><br>
        <input type="submit" value="Crear cafeteria">
    </form>
    EOS;
    require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
    exit;
}
$contenidoPrincipal = <<<EOS
<h1>$name</h1>
EOS;
$contenidoPrincipal .= '<div class="grid-container">';

foreach ($productos as $producto) {
    $foto_URL=".";
    $foto_URL .=$producto->getFoto();
    $nombre = $producto->getNombre();
    $precio = $producto->getPrecio();
    $precio .="€";
    $descripcion = $producto->getDescripcion();
    
    //foto cuadrada 200px
    $contenidoPrincipal .= "<div class='cafeteria-item'>";
    $contenidoPrincipal .="<img src='$foto_URL' alt='Image description' style='max-width: 200px; max-height: 200px;'>";
    $contenidoPrincipal .="<h2>$nombre</h2>";
    $contenidoPrincipal .="<h3>$precio</h3>";
    $contenidoPrincipal .="<p>$descripcion</p>";
    $contenidoPrincipal .= "</div><br>";
    //boton para añadir
}
$contenidoPrincipal .="<h3>Buton para añadir al carrito</h3>";
$contenidoPrincipal .= '</div>';
require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>