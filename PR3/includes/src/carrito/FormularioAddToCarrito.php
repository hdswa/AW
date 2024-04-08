<?php
namespace es\ucm\fdi\aw\carrito;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioAddToCarrito extends Formulario{
    private $name;
    private $price;
    public function __construct($name,$price) {
        $this->name = $name;
        $this->price = $price;
        parent::__construct('formAddCafeteria');
        
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precioProducto'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        $precio = $this->price;

        $html = <<<EOS
        $htmlErroresGlobales
        
        <input type="hidden" name="nombreProducto" value="$name">
        <input type="hidden" name="precioProducto" value="$precio">
        <label for="cantidad-$name">Cantidad:</label>
        <input type="number" id="cantidad-$name" name="cantidad" value="1" min="1" required>
        <input type="submit" value="Añadir al carrito">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreProducto || empty($nombreProducto) ) {
            $this->errores['nombreProducto'] = 'El nombreProducto de usuario no puede estar vacío';
        }
        
        $precioProducto = trim($datos['precioProducto'] ?? '');
        $precioProducto = filter_var($precioProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precioProducto || empty($precioProducto) ) {
            $this->errores['precioProducto'] = 'El precioProducto no puede estar vacío.';
        }

        $cantidad = $datos['cantidad'] ?? '';
        
        if (count($this->errores) === 0) {
            $owner=$_SESSION['nombre'];
            $carrito = \es\ucm\fdi\aw\carrito\Carrito::getCarritoByOwner($owner);
            if ($carrito === false) {
                // Carrito no encontrado, crea un nuevo carrito vacío
                $carrito = new Carrito($owner, json_encode([]), 0);
            }
            $nuevoItem = json_encode([
                "Nombre" => $nombreProducto,
                "Cantidad" => $cantidad,
                // Aquí deberías incluir una lógica para obtener el precio real del producto desde la base de datos
                "Precio" => $precioProducto
            ]);
            try {
                $carrito->addItem($nuevoItem);
                
                // Guarda el carrito actualizado en la base de datos
                if (!$carrito->save()) {
                    throw new Exception("Error al guardar el carrito.");
                }
            
                // Redirige al usuario de vuelta al carrito
                header('Location: carrito.php?name=' . urlencode($owner));
                exit;
            } catch (Exception $e) {
                echo "Ocurrió un error al añadir el producto al carrito: " . $e->getMessage();
                // Considera agregar manejo adecuado de errores aquí
            }
            

    }
        

}

}



?>