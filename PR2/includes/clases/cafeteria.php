
<?php
class cafeteria {
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
        return $this->dueno;
    }

    public function setDueno($dueno) {
        $this->dueno = $dueno;
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

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getCantidadDeLikes() {
        return $this->cantidadDeLikes;
    }

    public function setCantidadDeLikes($cantidadDeLikes) {
        $this->cantidadDeLikes = $cantidadDeLikes;
    }
}

?>