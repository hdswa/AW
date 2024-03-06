<?php
<?php

class Producto {
    private $id;
    private $nombre;
    private $cafeteriaOwner;
    private $precio;
    private $descripcion;

    public function __construct($nombre, $cafeteriaOwner, $precio, $descripcion) {
        $this->nombre = $nombre;
        $this->cafeteriaOwner = $cafeteriaOwner;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
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