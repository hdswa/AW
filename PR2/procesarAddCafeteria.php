<?php
require_once __DIR__.'/includes/clases/cafeteria.php';

require_once __DIR__.'/includes/config.php';

$owner = $_SESSION['nombre'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$ubicacion = $_POST['ubicacion'];
$archivo = $_POST['foto'];

$directorioDestino = __DIR__ . '/img/cafeterias/';
$rutaCarpeta = "./img/cafeterias/";

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
                //ha subido el archivo 
                $cafeteria= new Cafeteria($nombre,$descripcion,$owner,$categoria,$ubicacion,$ruta_DB,0);
                if ($cafeteria) {
                    //producto creado
                    $cafeteria->saveCafeteria();
                }
                }
            } else {
                echo "Hubo un error al mover el archivo subido.";
               
            }
        } else {
            echo "Formato de archivo no permitido. Solo se admiten imágenes (jpg, jpeg, png, gif).";
           
        }
    
header('Location: index.php');


?>