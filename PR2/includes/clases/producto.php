<?php


class Producto {
    private $id;
    private $nombre;
    private $cafeteriaOwner;
    private $precio;
    private $descripcion;
    private $foto;

    public function __construct($nombre, $cafeteriaOwner, $precio, $foto,$descripcion) {
        $this->nombre = $nombre;
        $this->cafeteriaOwner = $cafeteriaOwner;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->foto=$foto;
    }
   
    public static function getCafeAllItemsByOwner($cafeName){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("SELECT * FROM Productos WHERE Cafeteria_Owner='%s'", $conn->real_escape_string($cafeName));
        $rs=$conn->query($query);
        if ($rs->num_rows > 0) {
            while ($fila = $rs->fetch_assoc()) {
                $productos[] = new Producto($fila['Nombre'],$fila['Cafeteria_Owner'],$fila['Precio'],$fila['Foto'],$fila['Descripcion']);
            }
        } else
        {
            $productos = array();
        }
       
        // Return the results
        return $productos;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCafeteriaOwner() {
        return $this->cafeteriaOwner;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getFoto(){
        return $this->foto;
    }
    public function setFoto($foto){
        $this->foto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    
    // Add other setter methods if needed

    public function save() {
        // Implement the logic to save the product to the database
    }

    public function update() {
        // Implement the logic to update the product in the database
    }

    public function delete() {
        // Implement the logic to delete the product from the database
    }

    // Add other functions as per your requirements
}

?>