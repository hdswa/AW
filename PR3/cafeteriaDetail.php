

<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Cafeteria';
$contenidoPrincipal="";


if (isset($_GET['name'])){
    $name= $_GET['name'];
    $productos = \es\ucm\fdi\aw\productos\Producto::getCafeAllItemsByOwner($name); // Assuming getCafeterias() is a function that returns an array of cafeterias
    $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($name);
    $descripcion=$cafeteria->getDescripcion();
    $likes =$cafeteria->getCantidadDeLikes();
    }
if (isset($_GET['owner'])){
    $owner=$_GET['owner'];
    $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByOwnerName($owner);
    if ($cafeteria==false){
        $tituloPagina = 'Cafeteria no encontrada';
        

        $formCafe=new \es\ucm\fdi\aw\cafeterias\FormularioAddCafeteria();
        $formCafe=$formCafe->gestiona(); 

        $contenidoPrincipal=<<<EOF
        $formCafe
        EOF;
      
        $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        $app->generaVista('/plantillas/plantilla.php', $params);
        exit;
        }
    
        $name=$cafeteria->getNombre();
        $productos = \es\ucm\fdi\aw\productos\Producto::getCafeAllItemsByOwner($name);
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
    // $contenidoPrincipal .= <<<HTML
    // <form action="procesarAñadirAlCarrito.php" method="post">
    //     <input type="hidden" name="nombreProducto" value="$nombre">
    //     <input type="hidden" name="precioProducto" value="$precio">
    //     <label for="cantidad-$nombre">Cantidad:</label>
    //     <input type="number" id="cantidad-$nombre" name="cantidad" value="1" min="1" required>
    //     <input type="submit" value="Añadir al carrito">
    // </form>
    // HTML;
    $formCarrito= new \es\ucm\fdi\aw\carrito\FormularioAddToCarrito($nombre,$precio);
    $formCarrito=$formCarrito->gestiona();
    $contenidoPrincipal.=<<<EOF
    $formCarrito
    EOF;

    $contenidoPrincipal .= "</div><br>"; 
}


///Updated upstream

if (isset($owner)&&$owner==$_SESSION['nombre']){

    $formAddProducto=new \es\ucm\fdi\aw\productos\FormularioAddProducto($name);
    $formAddProducto=$formAddProducto->gestiona();
    $contenidoPrincipal .=$formAddProducto;
   
    $contenidoPrincipal .= "<h2>Editar Foto Cafeteria</h2>";
    $formchangeFoto=new \es\ucm\fdi\aw\cafeterias\FormularioCambiarFotoCafeteria($name);
    $formchangeFoto=$formchangeFoto->gestiona();
    $contenidoPrincipal .=$formchangeFoto;
    // $contenidoPrincipal .="<form action='procesarImagenes.php?cafe=$name' method='post' enctype='multipart/form-data'>
    //         <input type='file' name='foto' required>
    //         <button type='submit'>Cambiar foto Cafeteria</button>
    //     </form>";

}



//$contenidoPrincipal .= '</div>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

?>