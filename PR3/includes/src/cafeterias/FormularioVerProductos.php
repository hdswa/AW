<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioVerProductos extends Formulario{
    private $name;
 
    public function __construct($name) {
        $this->name = $name;
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/admin.php?action=productos&cafeName=$name");
        $cafeName="&cafeName=$name";
        
        parent::__construct('fomreditcaftelike', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php?action=productos'.$cafeName)]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreCafeteria'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        

        $html = <<<EOS
        $htmlErroresGlobales
        
        <input type="hidden" name="nombreCafeteria" value="$name">
        <input type="submit" value="Ver Productos">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $nombreCafeteria = trim($datos['nombreCafeteria'] ?? '');
        $nombreCafeteria = filter_var($nombreCafeteria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreCafeteria || empty($nombreCafeteria) ) {
            $this->errores['nombreCafeteria'] = 'El nombreCafeteria de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $urlRedireccion = Aplicacion::getInstance()->resuelve("/admin.php?action=productos&cafeName=$nombreCafeteria");
            header("Location:$urlRedireccion");
            }
    }
        

}





?>