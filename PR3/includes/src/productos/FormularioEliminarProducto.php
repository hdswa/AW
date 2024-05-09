<?php
namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEliminarProducto extends Formulario{
    private $name;
    private $cafeName;
    public function __construct($name,$cafeName) {
        $this->name = $name;
        $this->cafeName=$cafeName;
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/admin.php?action=productos&cafeName=$cafeName");
        parent::__construct('formdeletePRoducto', ['urlRedireccion' => $urlRedireccion]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreCafeteria','nombreProducto'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        $cafeName = $this->cafeName;

        $html = <<<EOS
        $htmlErroresGlobales
        <input type="hidden" name="nombreProducto" value="$name">
        <input type="hidden" name="nombreCafeteria" value="$cafeName">
        <input type="submit" value="Eliminar Producto">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $nombreCafeteria = trim($datos['nombreCafeteria'] ?? '');
        $nombreCafeteria = filter_var($nombreCafeteria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreCafeteria || empty($nombreCafeteria) ) {
            $this->errores['nombreCafeteria'] = 'El nombreCafeteria de usuario no puede estar vacío';
        }
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreProducto || empty($nombreProducto) ) {
            $this->errores['nombreProducto'] = 'El nombreProducto de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $producto= \es\ucm\fdi\aw\productos\Producto::getProductoByNameAndOwner($nombreProducto,$nombreCafeteria);

           $producto->deleteByNameAndOwner($nombreProducto,$nombreCafeteria);
            }
            

    }
        

}





?>