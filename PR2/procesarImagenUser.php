<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once 'includes/config.php'; // Ajusta la ruta según sea necesario
require_once 'includes/clases/usuario.php'; // Ajusta la ruta según sea necesario

session_start();


// Verifica si el usuario está logueado y si el formulario se ha enviado
if (isset($_SESSION['login']) && isset($_FILES['fotoPerfil'])) {
    $nombreUsuario = $_SESSION['nombre']; // O utiliza $_SESSION para obtener el nombre de usuario, según tu lógica de aplicación
    $archivo = $_FILES['fotoPerfil'];
    
    // Verificar errores comunes de carga
    if ($archivo['error'] == UPLOAD_ERR_OK) {
        // Define la ruta donde se almacenará la imagen
        $directorioDestino = __DIR__ . '/img/perfiles/';
        $nombreArchivo = basename($archivo['name']);
        $rutaArchivo = $directorioDestino . $nombreUsuario . "_" . $nombreArchivo;
        $ruta_DB = "./img/perfiles/" . $nombreUsuario . "_" . $nombreArchivo;
        // Verifica el tipo de archivo (asegúrate de que sea una imagen)
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Intenta mover el archivo subido al directorio destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                // Aquí actualizas la base de datos con la nueva ruta de la imagen
                $user = Usuario::buscaUsuario($nombreUsuario);
                if ($user) {
                    // Asume que existe un método en Usuario para actualizar la foto
                    // Este método debería implementarse de acuerdo a tus necesidades
                    if ($user->setFotoDePerfil($ruta_DB)) {
                        echo "La imagen ha sido actualizada correctamente.";
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

// Redirigir al usuario de vuelta a su perfil o a otra página
header('Location: perfil.php');
