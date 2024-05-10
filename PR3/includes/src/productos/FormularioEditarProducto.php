<?php
namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditarProducto extends Formulario{
    private $nombreProducto;
    private $precio;
    private $descripcion;
    private $foto;
    private $cafeteriaNombre;
    private $nombreBackup;
    public function __construct($nombreProducto, $precio, $descripcion, $foto,$cafeteriaNombre) {
        $this->nombreBackup = $nombreProducto;
        $this->nombreProducto = $nombreProducto;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->foto = $foto;
        $this->cafeteriaNombre = $cafeteriaNombre;
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?name=$cafeteriaNombre");
       
      
        parent::__construct('formeditproducto', ['urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion), 'enctype' => 'multipart/form-data']); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['cafeteriaNombre','nombreProducto','precio','foto','owner'], $this->errores, 'span', array('class' => 'error'));
       
        $foto=$this->foto;
        $foto=".".$foto;

        $html = <<<EOS
        $htmlErroresGlobales
        
        <fieldset>
        <input type="hidden" name="nombreBackup" value="$this->nombreProducto">
        <label for="nombreProducto">Nombre del Producto:</label>
        <input type="text" name="nombreProducto" value="$this->nombreProducto">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" step="0.01" value="$this->precio">
       
        <label for="foto">Foto:</label>
        <img src="$foto" alt="Foto del producto" width="100" height="100">
        <input type='file' name='foto' id='foto'>
        <label for="descripcion">Descripcion:</label>
        <input type="text" name="descripcion" value="$this->descripcion">
        <input type="submit" value="Editar Producto">
        </fieldset>
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreProducto || empty($nombreProducto) ) {
            $this->errores['nombreProducto'] = 'El nombreProducto de usuario no puede estar vacío';
        }
        $nombreBackup = trim($datos['nombreBackup'] ?? '');
        $nombreBackup = filter_var($nombreBackup, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreBackup || empty($nombreBackup) ) {
            $this->errores['nombreBackup'] = 'El nombreBackup de usuario no puede estar vacío';
        }
       
     
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'El descripcion de usuario no puede estar vacío';
        }
        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precio || empty($precio) ) {
            $this->errores['precio'] = 'El precio de usuario no puede estar vacío';
        }
        

        // var_dump($nombreProducto);
        // var_dump($precio);
        // var_dump($descripcion);
        // var_dump($foto);
        // var_dump($this->cafeteriaNombre);

        // var_dump($this->errores);
        // die();


        if (count($this->errores) === 0) {
   
            $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?producto=$nombreBackup&&cafeNombre=$this->cafeteriaNombre");
            
            $producto= Producto::getProductoByNameAndOwner($nombreBackup,$this->cafeteriaNombre);
        
            if($nombreProducto!==''){
                
                $producto->setNombre($nombreProducto);
                $this->nombreBackup=$nombreProducto;
            }
            if($precio!==''){
                
                $producto->setPrecio($precio);
            }
            if($descripcion!==''){
                
                $producto->setDescripcion($descripcion);
            }
            // if($foto!==''){
            //     $producto->setFoto($foto);
            // }
                
       
            
            $producto->updateProductoByName($nombreBackup);
        }

}
}





?>