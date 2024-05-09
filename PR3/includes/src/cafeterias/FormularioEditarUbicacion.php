<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditarUbicacion extends Formulario{
    private $name;
 
    public function __construct($name) {
        $this->name = $name;
       
        parent::__construct('formeditcafelikes', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php?action=cafeteria')]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['ubicacion','nombreCafeteria'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        
        $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($name);
        $ubicacion=$cafeteria->getUbicacion();
        $html = <<<EOS
        $htmlErroresGlobales
        <input type="hidden" name="nombreCafeteria" value="$name">
        <input type="text" name="ubicacion" value="$ubicacion">
        <input type="submit" value="Cambiar">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $ubicacion = trim($datos['ubicacion'] ?? '');
        $ubicacion = filter_var($ubicacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $ubicacion || empty($ubicacion) ) {
            $this->errores['ubicacion'] = 'El ubicacion de usuario no puede estar vacío';
        }
        $nombreCafeteria = trim($datos['nombreCafeteria'] ?? '');
        $nombreCafeteria = filter_var($nombreCafeteria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreCafeteria || empty($nombreCafeteria) ) {
            $this->errores['nombreCafeteria'] = 'El nombreCafeteria de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($nombreCafeteria);

          $cafeteria->setUbicacion($ubicacion);
          $cafeteria->updateCafeteria($nombreCafeteria);
        //    $cafeteria->deleteFoto();
            }
            

    }
        

}





?>