<?php

require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Aplicacion.php';

class Carrito {
    private $owner;
    private $itemList;
    private $pagado;

    public function __construct($owner, $itemList, $pagado) {
        $this->owner = $owner;
        $this->itemList = $itemList;
        $this->pagado = $pagado;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function addItem($newItemJson) {
        $itemList = json_decode($this->itemList, true);
        if ($itemList === null) {
            $itemList = [];
        }

        $newItem = json_decode($newItemJson, true);
        if ($newItem === null) {
            throw new Exception("Invalid JSON format for new item");
        }

        // Add the new item to the list
        $itemList[] = $newItem;

        // Encode the updated item list back to JSON
        $this->itemList = json_encode($itemList);
    }

    public function getPagado() {
        return $this->pagado;
    }

    public function setPagado() {
        $this->pagado = true;
    }

    public function getPrecioFinal() {
        $itemList = json_decode($this->itemList, true);
        if ($itemList === null) {
            throw new Exception("Invalid JSON format for item list");
        }

        $totalPrice = 0;
        foreach ($itemList as $item) {
            $cantidad = isset($item['Cantidad']) ? $item['Cantidad'] : 0;
            $precio = isset($item['Precio']) ? $item['Precio'] : 0.0;
            $subtotal = $cantidad * $precio;
            $totalPrice += $subtotal;
        }

        return $totalPrice;
    }

    public function realizarPago() {
      $conn = Aplicacion::getInstance()->getConexionBd();
      $query = sprintf("UPDATE carrito SET Pagado=1 WHERE Owner='%s' AND Pagado=0",
                       $conn->real_escape_string($this->owner));
  
      if ($conn->query($query) === TRUE) {
          return true;
      } else {
          error_log("Error al actualizar el estado de pago: " . $conn->error);
          return false;
      }
  }

    public function save() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($this->existsInDB()) {
            $query = sprintf("UPDATE carrito SET Item_list='%s', Pagado=%d WHERE Owner='%s'",
                $conn->real_escape_string($this->itemList),
                $this->pagado,
                $conn->real_escape_string($this->owner));
        } else {
            $query = sprintf("INSERT INTO carrito (Owner, Item_list, Pagado) VALUES ('%s', '%s', %d)",
                $conn->real_escape_string($this->owner),
                $conn->real_escape_string($this->itemList),
                $this->pagado);
        }

        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            error_log("Error al guardar el carrito: " . $conn->error);
            return false;
        }
    }

    private function existsInDB() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM carrito WHERE Owner = '%s'", 
                         $conn->real_escape_string($this->owner));

        $rs = $conn->query($query);
        if ($rs && $rs->num_rows > 0) {
            $rs->free();
            return true;
        }
        return false;
    }

    // Implementación del método getCarritoByOwner sigue igual
    public static function getCarritoByOwner($owner) {
      $conn = Aplicacion::getInstance()->getConexionBd();
      $query = sprintf("SELECT * FROM carrito C WHERE C.Owner = '%s' AND C.Pagado=false", $owner);
    
      $rs = $conn->query($query);
      $result = false;
    
      if ($rs) { // Execute error handling even if query execution is successful
        if ($rs->num_rows == 1) {
          $fila = $rs->fetch_assoc();
          $carrito = new Carrito($fila['Owner'], $fila['Item_list'], $fila['Pagado']);
          $result = $carrito;
        } else { // No cart found
          // $result = "No tienes un carrito activo."; // Replace with your desired message
          $carrito= new Carrito($owner,[],false);
        }
        $rs->free();
      } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
      }
    
      return $result;
    }
}



