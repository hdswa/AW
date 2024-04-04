

<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/producto.php';
require_once __DIR__.'/includes/clases/cafeteria.php';
$tituloPagina = 'Cafeteria';
$contenidoPrincipal="";

if (isset($_GET['name'])){
    $name= $_GET['name'];
    $productos = Producto::getCafeAllItemsByOwner($name); // Assuming getCafeterias() is a function that returns an array of cafeterias
    $cafeteria= Cafeteria::getCafeteriaByName($name);
    $descripcion=$cafeteria->getDescripcion();
    $likes =$cafeteria->getCantidadDeLikes();
    }
if (isset($_GET['owner'])){
    $owner=$_GET['owner'];
    $cafeteria= Cafeteria::getCafeteriaByOwnerName($owner);
    if ($cafeteria==false){
        $tituloPagina = 'Cafeteria no encontrada';
        $contenidoPrincipal = <<<EOS
        <h1>Vaya! Parece que aún no has creado tu propia cafetería...</h1>
        <p>Para comenzar, por favor, rellena el siguiente formulario:</p>
        <form action="procesarAddCafeteria.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required><br>
            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" required><br>
            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required><br>
            <label for="foto">Foto:</label>
            <input type='file' name='foto' required>
            <input type="submit" value="Crea tu cafetería">
        </form>
        EOS;
        require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
        exit;
        }
    
        $name=$cafeteria->getNombre();
        $productos = Producto::getCafeAllItemsByOwner($name);
        $contenidoPrincipal.="<h2>asdasdasdasa</h2>";
    
}

$fotoCafe=$cafeteria->getFoto();
$fotoCafe=RUTA_APP.$fotoCafe;
$descripcion = $cafeteria->getDescripcion();
$likes = $cafeteria->getCantidadDeLikes();
$contenidoPrincipal = <<<EOS
<div class= 'cafeteria'>
<h1>Cafeteria: $name</h1>

<img src='$fotoCafe'alt='Image description' style='max-width: 200px; max-height: 200px;'>
<h3>Descripcion: $descripcion </h3>
<h3>Likes: $likes </h3>
</div>
<div class='productos'>
<h1>Productos</h1>

EOS;
//$contenidoPrincipal .= '<div class="grid-container">';

// Dentro del bucle que muestra los productos en $contenidoPrincipal
foreach ($productos as $producto) {
    $foto_URL = RUTA_APP . htmlspecialchars($producto->getFoto());
    $nombre = htmlspecialchars($producto->getNombre());
    $precio = htmlspecialchars($producto->getPrecio());
    $descripcion = htmlspecialchars($producto->getDescripcion());

    $contenidoPrincipal .= "<div class='cafeteria-item'>";
    $contenidoPrincipal .= "<img src='$foto_URL' alt='Descripción de la imagen' style='max-width: 200px; max-height: 200px;'>";
    $contenidoPrincipal .= "<h2>$nombre</h2>";
    $contenidoPrincipal .= "<h3>$precio €</h3>";
    $contenidoPrincipal .= "<p>$descripcion</p>";

    // Formulario para añadir al carrito, ahora incluye cantidad y precio
    $contenidoPrincipal .= <<<HTML
    <form action="procesarAñadirAlCarrito.php" method="post">
        <input type="hidden" name="nombreProducto" value="$nombre">
        <input type="hidden" name="precioProducto" value="$precio">
        <label for="cantidad-$nombre">Cantidad:</label>
        <input type="number" id="cantidad-$nombre" name="cantidad" value="1" min="1" required>
        <input type="submit" value="Añadir al carrito">
    </form>
    HTML;

    $contenidoPrincipal .= "</div><br>"; 
}


///Updated upstream

if (isset($owner)&&$owner==$_SESSION['nombre']){
    $contenidoPrincipal .= "<a href='addProducto.php' class='square-button' style='background-color: gray; color: black;'>Add Product</a>";
    $contenidoPrincipal .="<br>";
    $contenidoPrincipal .= "<h2>Editar Foto Cafeteria</h2>";
    $contenidoPrincipal .="<form action='procesarImagenes.php?cafe=$name' method='post' enctype='multipart/form-data'>
            <input type='file' name='foto' required>
            <button type='submit'>Cambiar foto Cafeteria</button>
        </form>";

}



//$contenidoPrincipal .= '</div>';

require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>