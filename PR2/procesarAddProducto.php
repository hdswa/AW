<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/producto.php';
require_once __DIR__.'/includes/clases/cafeteria.php';

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

$descripcion = $_POST['descripcion'];

$archivo = $_FILES['foto'];
$directorioDestino = __DIR__ . '/img/productos/';
$rutaCarpeta = "./img/productos/";

$cafeteria = Cafeteria::getCafeteriaByOwnerName($_SESSION['nombre']);
$nombreCafeteria = $cafeteria->getNombre();


if ($archivo['error'] == UPLOAD_ERR_OK) {
    // Define la ruta donde se almacenará la imagen
    $nombreArchivo = basename($archivo['name']);
    $rutaArchivo = $directorioDestino . $nombre . "_" . $nombreArchivo;
    $ruta_DB = $rutaCarpeta . $nombre . "_" . $nombreArchivo;
    // Verifica el tipo de archivo (asegúrate de que sea una imagen)
    $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
    if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])) {
        // Intenta mover el archivo subido al directorio destino
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            //ha subido el archivo a la carpeta correspondiente
            $producto= new Producto($nombre,$nombreCafeteria,$precio,$ruta_DB,$descripcion);
            if ($producto) {
                //producto creado
                $producto->saveProducto();
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
header('Location: index.php');
?>