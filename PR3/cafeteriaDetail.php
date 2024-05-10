

<?php

use es\ucm\fdi\aw\comentarios\FormularioComentario;
use es\ucm\fdi\aw\cafeterias\FormularioLikeCafeteria;

ini_set('display_errors', 1);  // Activa la visualización de errores en el navegador
ini_set('display_startup_errors', 1);  // Activa la visualización de errores durante el inicio de PHP
error_reporting(E_ALL);  // Reporta todos los errores, incluyendo E_NOTICE y otros


require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Cafeteria';
$contenidoPrincipal="";



if(isset($_GET['producto'])){

$contenidoPrincipal="<h2>Editar Producto</h2>";

$nombreProducto = $_GET['producto'];
$cafeName=$_GET['cafeNombre'];   

$producto= \es\ucm\fdi\aw\productos\Producto::getProductoByNameAndOwner($nombreProducto,$cafeName);

$formEdit=new \es\ucm\fdi\aw\productos\FormularioEditarProducto($nombreProducto,$producto->getPrecio(),$producto->getDescripcion(),$producto->getFoto(),$cafeName);
$formEdit=$formEdit->gestiona();
$contenidoPrincipal.=$formEdit;
}
else{
if (isset($_GET['name'])){
    $name= $_GET['name'];
    $productos = \es\ucm\fdi\aw\productos\Producto::getCafeAllItemsByOwner($name); // Assuming getCafeterias() is a function that returns an array of cafeterias
    $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($name);
    $descripcion=$cafeteria->getDescripcion();
    $likes =$cafeteria->obtenerCantidadLikes($name);
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
       
    
}
$nombreUsuario = $_SESSION['nombre']; // Nombre del usuario actual
$owner = $cafeteria->getDueno();

$fotoCafe=$cafeteria->getFoto();
$fotoCafe=RUTA_APP.$fotoCafe;
$descripcion = $cafeteria->getDescripcion();
$cantidadLikes =$cafeteria->obtenerCantidadLikes($name);


$cafeteriaNombre = $cafeteria->getNombre(); 


$htmlLikeButton = '';
if ($owner != $nombreUsuario) {
    $yaDioLike = \es\ucm\fdi\aw\cafeterias\Cafeteria::yaDioLike($name, $cafeteriaNombre);
    $formLike = new FormularioLikeCafeteria($name);
    $htmlLikeButton = $formLike->gestiona();
}

$contenidoPrincipal = <<<EOS
<div class= 'cafeteria'>
<h1>Cafeteria: $name</h1>

<img src='$fotoCafe'alt='Image description' style='max-width: 200px; max-height: 200px;'>
<h3>Descripcion: $descripcion </h3>
<h3>Likes: $cantidadLikes </h3>
$htmlLikeButton <!-- Aquí se inserta el formulario de likes -->
</div>
<div class='productos'>

<h1 style="width:100%">Productos</h1>

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
    if($owner===$nombreUsuario){
        $formVerProd= new \es\ucm\fdi\aw\productos\FormularioVerProducto($nombre,$precio,$foto_URL,$owner,$cafeteriaNombre);
        $formVerProd=$formVerProd->gestiona();
        $contenidoPrincipal.=<<<EOF
        $formVerProd
        EOF;
       }
    $contenidoPrincipal .= "</div><br>"; 
}

$contenidoPrincipal .= "</div><br>"; 



$comentariosHTML = "<div class='comentarios-seccion'>";
$comentariosHTML .= "<h1>Comentarios</h1>";

$comentarios = \es\ucm\fdi\aw\comentarios\Comentarios::getComentariosPorCafeteria($cafeteriaNombre);
foreach ($comentarios as $comentario) {
    $comentariosHTML .= "<div class='comentario'>";
    $comentariosHTML .= "<h4>Comentado por: " . htmlspecialchars($comentario->getUsuario()) . "</h4>";
    $comentariosHTML .= "<p>" . htmlspecialchars($comentario->getMensaje()) . "</p>";
    $comentariosHTML .= "<p>Valoración: " . htmlspecialchars($comentario->getValoracion()) . " estrellas</p>";
    $comentariosHTML .= "</div>";
}
$comentariosHTML .= "</div>";

$contenidoPrincipal .= $comentariosHTML; 

$formComment = new FormularioComentario($name);
$htmlAddComment = $formComment->gestiona();


if ($owner != $nombreUsuario) {
$contenidoPrincipal .= "<div class='comentarios-add-seccion'>";
$contenidoPrincipal .= "<h2>Añade un Comentario</h2>";
$contenidoPrincipal .= $htmlAddComment; // Añade el formulario de comentario a la página
$contenidoPrincipal .= "</div>";
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


}
//$contenidoPrincipal .= '</div>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

?>