<?php
namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Producto {
    use MagicProperties;
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
            $rs->free();
        } else
        {
            $productos = array();
        }
       
        // Return the results
        return $productos;
    }


    public function saveProducto(){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Productos (Nombre, Cafeteria_Owner, Precio, Foto, Descripcion) VALUES ('%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($this->nombre),
            $conn->real_escape_string($this->cafeteriaOwner),
            $conn->real_escape_string($this->precio),
            $conn->real_escape_string($this->foto),
            $conn->real_escape_string($this->descripcion)
        );
        
        $result = $conn->query($query);
        
        if ($result) {
            return true;
        } else {
            return false;
        }

        $result->free();
    }

    public static function getProductoByNameAndOwner($name,$owner){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Productos WHERE Nombre='%s' AND Cafeteria_Owner='%s'", $conn->real_escape_string($name),$conn->real_escape_string($owner));
        $rs=$conn->query($query);
        if ($rs->num_rows > 0) {
            $fila = $rs->fetch_assoc();
            $producto = new Producto($fila['Nombre'],$fila['Cafeteria_Owner'],$fila['Precio'],$fila['Foto'],$fila['Descripcion']);
            $rs->free();
        } else
        {
            $producto = false;
        }
        return $producto;
    }

    public function añadirProducto() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = "INSERT INTO Productos (Nombre, Cafeteria_Owner, Precio, Foto, Descripcion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("ssdss", $this->nombre, $this->cafeteriaOwner, $this->precio, $this->foto, $this->descripcion);
            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                $stmt->close();
                return true;
            } else {
                error_log("Error al insertar el producto: " . $stmt->error);
                $stmt->close();
                return false;
            }
        } else {
            error_log("Error al preparar la declaración: " . $conn->error);
            return false;
        }
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
        $this->foto=$foto;
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

    

    public function deleteByNameAndOwner($name, $owner) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Productos WHERE Nombre='%s' AND Cafeteria_Owner='%s'", $conn->real_escape_string($name), $conn->real_escape_string($owner));
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }

        $result->free();
    }

    public function updateProducto() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Productos SET
                            Cafeteria_Owner = '%s',
                            Precio = '%s',
                            Foto = '%s',
                            Descripcion = '%s'
                          WHERE Nombre = '%s'",
            $conn->real_escape_string($this->cafeteriaOwner),
            $conn->real_escape_string($this->precio),
            $conn->real_escape_string($this->foto),
            $conn->real_escape_string($this->descripcion),
            $conn->real_escape_string($this->nombre)
        );
        $result = $conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}

