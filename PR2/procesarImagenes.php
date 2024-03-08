<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once 'includes/config.php'; // Ajusta la ruta según sea necesario
require_once 'includes/clases/cafeteria.php'; // Ajusta la ruta según sea necesario
require_once 'includes/clases/producto.php'; // Ajusta la ruta según sea necesario
$contenidoPrincipal="";
$contenidoPrincipal.="asdasda";
$tituloPagina = 'Procesar imagen';
if(isset($_GET['cafe'])){
    $directorioDestino = __DIR__ . '/img/cafeterias/';
    $rutaCarpeta = "/img/cafeterias/";
    $name=$_GET['cafe'];
    $cafeteria= Cafeteria::getCafeteriaByName($name);
   
}
$contenidoPrincipal.="<h2>Imagen actualizada correctamente $name</h2>";
if (isset($_POST['producto'])){
    
}

// Verifica si el usuario está logueado y si el formulario se ha enviado
if (isset($_SESSION['login']) && isset($_FILES['foto'])) {
    
    $archivo = $_FILES['foto'];
    
    // Verificar errores comunes de carga
    if ($archivo['error'] == UPLOAD_ERR_OK) {
        // Define la ruta donde se almacenará la imagen
        
        $nombreArchivo = basename($archivo['name']);
        $rutaArchivo = $directorioDestino . $name . "_" . $nombreArchivo;
        $ruta_DB = $rutaCarpeta . $name . "_" . $nombreArchivo;
        // Verifica el tipo de archivo (asegúrate de que sea una imagen)
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])) {
            
            // Intenta mover el archivo subido al directorio destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                
                $cafeteria= Cafeteria::getCafeteriaByName($name);
                if ($cafeteria) {
                    echo "cafeteria existe";
                    if ($cafeteria->setFoto($ruta_DB)) {
                     
                    } else {
                        echo "Hubo un error al actualizar la imagen en la base de datos.";
                       
                    }
                }
            } else {
                echo "Hubo un error al mover el archivo subido.";
               
            }
        } else {
            echo "Formato de archivo no permitido. Solo se admiten imágenes (jpg, jpeg, png, gif).";
           
        }
    } else {
        echo "Error al subir el archivo: " . $archivo['error'];
        
    }
} else {
    echo "No estás autorizado para realizar esta acción.";
  
}

header('Location: index.php');
// Redirigir al usuario de vuelta a su perfil o a otra página

