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
public static function getAllCafe() {
    
    $conn = Aplicacion::getInstance()->getConexionBd();
    
    $query = "SELECT * FROM Cafeteria";
    $rs = $conn->query($query);
    if ($rs->num_rows > 0) {
        while($fila = $rs->fetch_assoc()){
        $cafeterias[] = new cafeteria($fila['Nombre'], $fila['Descripcion'], $fila['Owner'], $fila['Categoria'], $fila['Ubicacion'],$fila['Foto'], $fila['Cantidad_de_likes']);
        }
    } else
    {
        $cafeterias = array();
    }
    $rs->free();
    // Return the results
    return $cafeterias;
}

public static function getCafeteriaByName($name){
    $conn = Aplicacion::getInstance()->getConexionBd();
    
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
}

?>