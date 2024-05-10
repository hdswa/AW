<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;


class Cafeteria{

use MagicProperties;
private $nombre;
private $descripcion;
private $owner;
private $categoria;
private $ubicacion;
private $foto;
private $cantidadDeLikes;

public function __construct($nombre, $descripcion, $owner, $categoria, $ubicacion,$foto, $cantidadDeLikes) {
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->owner = $owner;
    $this->categoria = $categoria;
    $this->ubicacion = $ubicacion;
    $this->foto = $foto;
    $this->cantidadDeLikes = $cantidadDeLikes;
}

public function saveCafeteria() {
    $conn = Aplicacion::getInstance()->getConexionBd();
    
    if(self::getCafeteriaByName($this->nombre) != false){
        return false;
    }
    $query = sprintf("INSERT INTO Cafeteria (Nombre, Descripcion, Owner, Categoria, Ubicacion, Foto, Cantidad_de_likes) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $conn->real_escape_string($this->nombre),
        $conn->real_escape_string($this->descripcion),
        $conn->real_escape_string($this->owner),
        $conn->real_escape_string($this->categoria),
        $conn->real_escape_string($this->ubicacion),
        $conn->real_escape_string($this->foto),
        $conn->real_escape_string($this->cantidadDeLikes)
    );
    
    $result = $conn->query($query);
    
    if ($result) {
        return true;
    } else {
        return false;
    }
}

public function updateCafeteria($name) {
    $conn = Aplicacion::getInstance()->getConexionBd();
    $name = html_entity_decode($name, ENT_QUOTES, 'UTF-8');
    $query = sprintf("UPDATE Cafeteria SET 
                        Descripcion = '%s',
                        Owner = '%s',
                        Categoria = '%s',
                        Ubicacion = '%s',
                        Foto = '%s',
                        Cantidad_de_likes = '%s'
                      WHERE Nombre = '%s'",
        $conn->real_escape_string($this->descripcion),
        $conn->real_escape_string($this->owner),
        $conn->real_escape_string($this->categoria),
        $conn->real_escape_string($this->ubicacion),
        $conn->real_escape_string($this->foto),
        $conn->real_escape_string($this->cantidadDeLikes),
        $conn->real_escape_string($name)
    );

    $result = $conn->query($query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

public static function getAllCafe() {
    
    $conn = Aplicacion::getInstance()->getConexionBd();
    
    $query = "SELECT * FROM Cafeteria";
    $rs = $conn->query($query);
    if ($rs->num_rows > 0) {
        while($fila = $rs->fetch_assoc()){
        $cafeterias[] = new cafeteria($fila['Nombre'], $fila['Descripcion'], $fila['Owner'], $fila['Categoria'], $fila['Ubicacion'],$fila['Foto'], $fila['Cantidad_de_likes']);
        }
        $rs->free();
    } else
    {
        $cafeterias = array();
    }
    
    // Return the results
    return $cafeterias;
}

public static function getCafeteriaByName($name){
    $conn = Aplicacion::getInstance()->getConexionBd();
    $name = html_entity_decode($name, ENT_QUOTES, 'UTF-8');
    
    $query = sprintf("SELECT * FROM Cafeteria C WHERE C.Nombre = '%s'", $conn->real_escape_string($name));
    $rs = $conn->query($query);
    if ($rs->num_rows > 0) {
        $fila = $rs->fetch_assoc();
        $cafeteria = new cafeteria($fila['Nombre'], $fila['Descripcion'], $fila['Owner'], $fila['Categoria'], $fila['Ubicacion'],$fila['Foto'], $fila['Cantidad_de_likes']);
        $result=$cafeteria;
        $rs->free();
    } else
    {
        $result = false;
    }
    return $result;

}
public static function getCafeteriaByOwnerName($name){
    $conn = Aplicacion::getInstance()->getConexionBd();
    $name = html_entity_decode($name, ENT_QUOTES, 'UTF-8');
    $query = sprintf("SELECT * FROM Cafeteria C WHERE C.Owner = '%s'", $conn->real_escape_string($name));
    $rs = $conn->query($query);
    if ($rs->num_rows > 0) {
        $fila = $rs->fetch_assoc();
        $cafeteria = new cafeteria($fila['Nombre'], $fila['Descripcion'], $fila['Owner'], $fila['Categoria'], $fila['Ubicacion'],$fila['Foto'], $fila['Cantidad_de_likes']);
        $result=$cafeteria;
        $rs->free();
    } else
    {
        $result = false;
    }
    return $result;

}
public function getNombre() {
    return $this->nombre;
}

public function setNombre($nombre) {
    $this->nombre = $nombre;
}

public function getDescripcion() {
    return $this->descripcion;
}

public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
}

public function getDueno() {
    return $this->owner;
}

public function setDueno($dueno) {
    $this->owner = $dueno;
}

public function getCategoria() {
    return $this->categoria;
}

public function setCategoria($categoria) {
    $this->categoria = $categoria;
}

public function getUbicacion() {
    return $this->ubicacion;
}

public function setUbicacion($ubicacion) {
    $this->ubicacion = $ubicacion;
}

public function getFoto() {
    return $this->foto;
}


public function getCantidadDeLikes() {
    return $this->cantidadDeLikes;
}

public function setCantidadDeLikes($cantidadDeLikes) {
    $this->cantidadDeLikes = $cantidadDeLikes;
}

public function setFoto($foto) {
    $this->foto = $foto;

        // Obtén la conexión a la base de datos
    $conn = Aplicacion::getInstance()->getConexionBd();

    // Prepara la consulta SQL para actualizar la ruta de la foto de perfil
    $query = sprintf("UPDATE Cafeteria C SET C.Foto='%s' WHERE C.Nombre='%s'",
                    $conn->real_escape_string($foto),
                    $conn->real_escape_string($this->nombre));

    // Ejecuta la consulta
    if ($conn->query($query) === TRUE) {
        return true; // Actualización exitosa
    } else {
        error_log("Error al actualizar la foto de perfil: " . $conn->error);
        return false; // Error al actualizar
    }
}

    public static function yaDioLike($idUsuario, $nombreCafeteria) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $stmt = $conn->prepare("SELECT 1 FROM Likes_cafeteria WHERE id_usuario = ? AND nombre_cafeteria = ?");
        $stmt->bind_param('ss', $idUsuario, $nombreCafeteria);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }


    public static function incrementarLikes($idCafeteria, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
       

       /* // Primero, verifica si el usuario ya ha dado "like" a la cafetería
        $stmt = $conn->prepare("SELECT * FROM Likes_cafeteria WHERE id_usuario = ? AND nombre_cafeteria = ?");
        $stmt->bind_param('ss', $idUsuario, $idCafeteria);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false; // El usuario ya ha dado "like" a esta cafetería
        }
*/
        // Si no, inserta el nuevo "like"
        $stmt = $conn->prepare("INSERT INTO Likes_cafeteria (id_usuario, nombre_cafeteria) VALUES (?, ?)");
        $stmt->bind_param('ss', $idUsuario, $idCafeteria);
        $result = $stmt->execute();

        header("Location: cafeteriaDetail.php?name=" . urlencode($idCafeteria));
        exit();
    }

    public static function disminuirLikes($idCafeteria, $idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Eliminar el like de la tabla Likes_cafeteria
        $stmt = $conn->prepare("DELETE FROM Likes_cafeteria WHERE id_usuario = ? AND nombre_cafeteria = ?");
        $stmt->bind_param('ss', $idUsuario, $idCafeteria);
        $stmt->execute();

        // Disminuir el contador de likes en la tabla Cafeteria
        $stmt = $conn->prepare("UPDATE Cafeteria SET Cantidad_de_likes = Cantidad_de_likes - 1 WHERE Nombre = ?");
        $stmt->bind_param('s', $idCafeteria);
        $stmt->execute();

        header("Location: cafeteriaDetail.php?name=" . urlencode($idCafeteria));
        exit();
    }




    public static function obtenerCantidadLikes($nombre) {
        $conn = Aplicacion::getInstance()->getConexionBd();
       
        $stmt = $conn->prepare("SELECT COUNT(*) AS likes FROM Likes_cafeteria WHERE nombre_cafeteria = ?");
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        return $fila['likes'];
    }
	
    public function deleteFoto(){
      
        self::setFoto("/img/cafeterias/default.png");
     }
 
     public function deleteCafeteria(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        // Prepara la consulta SQL para actualizar la ruta de la foto de perfil
        $query = sprintf("DELETE FROM Cafeteria WHERE Nombre='%s'",
                        $conn->real_escape_string($this->nombre));
        // Ejecuta la consulta
        if ($conn->query($query) === TRUE) {
            return true; // Actualización exitosa
        } else {
            error_log("Error al borrar : " . $conn->error);
            return false; // Error al actualizar
        }
    }
}



