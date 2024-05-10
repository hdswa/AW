<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\cafeterias\FormularioEditLikes;

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Admin';
$contenidoPrincipal='';



if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ADMIN_ROLE)) {

  if(isset($_GET['action'])){
    $action =$_GET['action'];
    
    if($action==='user'){
      $contenidoPrincipal="<h1>Menu para el control de Usuarios</h1>";
      $usuarios = \es\ucm\fdi\aw\usuarios\Usuario::getAllUser();
      
     $contenidoPrincipal.="<table>";
     $contenidoPrincipal.="<tr><th>Nombre</th><th>Email</th><th>Foto</th><th>Editar</th></tr>";
     foreach($usuarios as $usuario){
      $name=$usuario->getNombre();
      $email=$usuario->getEmail();
      $foto=$usuario->getFoto();

  
     
      $formDeleteFoto=new \es\ucm\fdi\aw\usuarios\FormularioEliminarFoto($name);
      $formDeleteFoto=$formDeleteFoto->gestiona();
  
      $formDeleteUsuario=new \es\ucm\fdi\aw\usuarios\FormularioEliminarUsuario($name);
      $formDeleteUsuario=$formDeleteUsuario->gestiona();
      $contenidoPrincipal.=<<<EOS
      <tr>
      <td>
      <h3>$name</h3>
      </td>
      <td>
      <h3>$email</h3>
      </td>
      <td>
      <img src='$foto'alt='Image description' style='max-width: 100px; max-height: 100px;'>
      </td>
      <td>  
      <div class='table-data-button-div'>
      $formDeleteFoto
      $formDeleteUsuario
      
      </div>
      </td>
      </tr>

      EOS;
     }
    }

    else if($action==='cafeteria'){
      $contenidoPrincipal="<h1>Menu para el control de Cafeterías</h1>";
      $cafeterias = \es\ucm\fdi\aw\cafeterias\Cafeteria::getAllCafe();
      $contenidoPrincipal.="<table>";
      $contenidoPrincipal.="<tr><th>Nombre</th><th>Dueño</th><th>Foto</th><th>Ubicación</th><th>likes</th><th>Editar</th></tr>";
      foreach($cafeterias as $cafeteria){
        $nombreCafe=$cafeteria->getNombre();
        $owner=$cafeteria->getDueno();
        $foto=$cafeteria->getFoto();
        $ubicacion=$cafeteria->getUbicacion();
        $likes=$cafeteria->getCantidadDeLikes();

        $formDeleteFoto=new \es\ucm\fdi\aw\cafeterias\FormularioEliminarFoto($nombreCafe);
        $formDeleteFoto=$formDeleteFoto->gestiona();
        
        $formEditLikes=new \es\ucm\fdi\aw\cafeterias\FormularioEditarLikes($nombreCafe);
        $formEditLikes=$formEditLikes->gestiona();
        $foto=".".$foto;
        
      
        
        $formEditUbicacion = new \es\ucm\fdi\aw\cafeterias\FormularioEditarUbicacion($nombreCafe);
        $formEditUbicacion=$formEditUbicacion->gestiona();

        $formDeleteCafeteria = new \es\ucm\fdi\aw\cafeterias\FormularioEliminarCafeteria($nombreCafe);
        $formDeleteCafeteria = $formDeleteCafeteria->gestiona();

        $formVerProductos = new \es\ucm\fdi\aw\cafeterias\FormularioVerProductos($nombreCafe);
        $formVerProductos = $formVerProductos->gestiona();

        $productURL = Aplicacion::getInstance()->resuelve("/admin.php?action=productos&cafeName=$nombreCafe");
        $URL = "./admin.php?action=productos";

        $contenidoPrincipal.=<<<EOS
        <tr>
        <td>
        <h3>$nombreCafe</h3>
        </td>
        <td>
        <h3>$owner</h3>
        </td>
        <td>
        <img src='$foto'alt='Image description' style='max-width: 100px; max-height: 100px;'>
        </td>
        <td>
        $formEditUbicacion
        </td>
        <td>
        $formEditLikes
        </td>
        <td>  
        <div class='table-data-button-div'>
    
        $formDeleteFoto
        
        

        
        <form method="get" action="$URL">
        <input type="hidden" name="action" value="productos">
        <input type="hidden" name="cafeName" value="$nombreCafe">
      
        <input type="submit" value="Productos disponibles">
         </form>
        $formDeleteCafeteria

       
        
        </div>
        </td>
        </tr>
  
        EOS;
        
      }

    }
    else if($action==='productos'){
      $cafeName=$_GET['cafeName'];
      $contenidoPrincipal="<h1>Menu para el control de Cafeterías</h1>";
      $productos = \es\ucm\fdi\aw\productos\Producto::getCafeAllItemsByOwner($cafeName);
      $contenidoPrincipal.="<h2>Nombre de Cafeteria:".$cafeName."</h2>";
      $contenidoPrincipal.="<table>";
      $contenidoPrincipal.="<tr><th>Nombre</th><th>Precio</th><th>Foto</th><th>Descripcion</th><th>Editar</th></tr>";
      foreach($productos as $producto){

        $nombre=$producto->getNombre();
        $precio=$producto->getPrecio();
        $foto=$producto->getFoto();
        $descripcion=$producto->getDescripcion();
        $foto=".".$foto;

        $formDeleteFoto= new \es\ucm\fdi\aw\productos\FormularioEliminarFoto($nombre,$cafeName);
        $formDeleteFoto= $formDeleteFoto->gestiona();

        $formDeleteProducto = new \es\ucm\fdi\aw\productos\FormularioEliminarProducto($nombre,$cafeName);
        $formDeleteProducto = $formDeleteProducto->gestiona();
        $contenidoPrincipal.=<<<EOS
        <tr>
        <td>
        <h3>$nombre</h3>
        </td>
        <td>
        <h3>$precio</h3>
        </td>
        <td>
        <img src='$foto'alt='Image description' style='max-width: 100px; max-height: 100px;'>
        </td>
        <td>
        $descripcion
        </td>
       
        <td>  
        <div class='table-data-button-div'>
        $formDeleteFoto
        $formDeleteProducto
        </div>
        </td>
        </tr>
  
        EOS;
      }
    }
    else if($action==='comentario'){
     
      $contenidoPrincipal="<h1>Menu para el control de Comentarios</h1>";
      $comentarios=\es\ucm\fdi\aw\comentarios\Comentarios::getAllComentarios();
      $contenidoPrincipal.="<table>";
      $contenidoPrincipal.="<tr><th>Usuario</th><th>Cafeteria Comentada</th><th>Valoracion</th><th>Mensaje</th><th>Editar</th></tr>";
      foreach($comentarios as $comentario){

        $nombre=$comentario->getUsuario();
        $cafeteria=$comentario->getCafeteriaComentada();
        $valoracion=$comentario->getValoracion();
        $mensaje=$comentario->getMensaje();

        $id=$comentario->getID();

        $formDeleteCommentario= new \es\ucm\fdi\aw\comentarios\FormularioEliminarComentario($id);
        $formDeleteCommentario = $formDeleteCommentario->gestiona();
        $contenidoPrincipal.=<<<EOS
        <tr>
        <td>
        
        <h3>$nombre</h3>
        </td>
        <td>
        <h3>$cafeteria</h3>
        </td>
        <td>
        <h3>$valoracion</h3>
        </td>
        <td>
        <h3>$mensaje</h3>
        </td>
       
        <td>  
        <div class='table-data-button-div'>
        $formDeleteCommentario
        </div>
        </td>
        </tr>
  
        EOS;
      }
    }
  }
 
  else{
  $contenidoPrincipal=<<<EOS
    <h1>Consola de administración:</h1>
    <p>Aquí se muestran todos los controles de administración disponibles.</p>
  EOS;

 
  $contenidoPrincipal .= '<div class="grid-container">';

  $contenidoPrincipal .= "<div class='cafeteria-item'>";
  $contenidoPrincipal .="<h2><a href='admin.php?action=user'>Control de Usuarios</a></h2>";
  $contenidoPrincipal .= "</div><br>";

  $contenidoPrincipal .= "<div class='cafeteria-item'>";
  $contenidoPrincipal .="<h2><a href='admin.php?action=cafeteria'>Control de Cafeterías</a></h2>";
  $contenidoPrincipal .= "</div><br>";

  $contenidoPrincipal .= "<div class='cafeteria-item'>";
  $contenidoPrincipal .="<h2><a href='admin.php?action=comentario'>Control de Comentarios</a></h2>";
  $contenidoPrincipal .= "</div><br>";
  $contenidoPrincipal .= '</div>';
 }
} else {
  $contenidoPrincipal=<<<EOS
  <h1>Acceso Denegado!</h1>
  <p>No tienes permisos suficientes para administrar la web.</p>
  EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);



?>


<script>
    // JavaScript to handle form submission and redirection
    document.getElementById("redirectForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission
        var productURL = "<?php echo Aplicacion::getInstance()->resuelve('/admin.php?action=productos'); ?>";
        var cafeName = "<?php echo $nombreCafe; ?>";
        window.location.href = productURL + "&cafeName=" + encodeURIComponent(cafeName);
    });
</script>