<?php
class Carrito{
    private $owner;
    private $itemList;
    private $pagado;


    public function __construct($owner,$itemList,$pagado){

        $this->owner=$owner;
        $this->itemList=$itemList;
        $this->pagado=$pagado;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function addItem($newItemJson) {
        // Decode the existing item list (assuming it's a valid JSON string)
        $itemList = json_decode($this->itemList, true);
      
        // If decoding fails, handle the error appropriately (e.g., throw an exception)
        if ($itemList === null) {
          throw new Exception("Invalid JSON format for item list");
        }
      
        // Decode the new item JSON string
        $newItem = json_decode($newItemJson, true);
      
        // If decoding fails, handle the error appropriately (e.g., return a message)
        if ($newItem === null) {
          return "Invalid JSON format for new item";
        }
      
        // Add the new item to the list
        $itemList[] = $newItem;
      
        // Encode the updated item list back to JSON
        $this->itemList = json_encode($itemList);
      }
      

    public function getpagado() {
        return $this->pagado;
    }

    public function Pagado() {
        $this->$pagado = true;
    }

    public function getPrecioFinal() {
        // Decode the item list (assuming it's a valid JSON string)
        $itemList = json_decode($this->itemList, true);
      
        // If decoding fails, handle the error appropriately (e.g., throw an exception)
        if ($itemList === null) {
          throw new Exception("Invalid JSON format for item list");
        }
      
        // Initialize total price to 0
        $totalPrice = 0;
      
        // Iterate through each item in the list
        foreach ($itemList as $item) {
          // Extract quantity and price (assuming they are present)
          $cantidad = isset($item['Cantidad']) ? $item['Cantidad'] : 0;
          $precio = isset($item['Precio']) ? $item['Precio'] : 0.0;
      
          // Calculate subtotal for the item
          $subtotal = $cantidad * $precio;
      
          // Add subtotal to the total price
          $totalPrice += $subtotal;
        }
      
        // Return the total price
        return $totalPrice;
    }
      
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
?>