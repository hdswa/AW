<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditarLikes extends Formulario{
    private $name;
 
    public function __construct($name) {
        $this->name = $name;
       
        parent::__construct('fomreditcaftelike', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php?action=cafeteria')]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['cantidadLikes','nombreCafeteria'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        
        $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($name);
        $likes=$cafeteria->getCantidadDeLikes();
        $html = <<<EOS
        $htmlErroresGlobales
        
        <input type="number" name="cantidadLikes" value="$likes">
        <input type="hidden" name="nombreCafeteria" value="$name">
        <input type="submit" value="Cambiar">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $cantidadLikes = trim($datos['cantidadLikes'] ?? '');
        $cantidadLikes = filter_var($cantidadLikes, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $cantidadLikes || empty($cantidadLikes) ) {
            $this->errores['cantidadLikes'] = 'El cantidadLikes de usuario no puede estar vacío';
        }
        $nombreCafeteria = trim($datos['nombreCafeteria'] ?? '');
        $nombreCafeteria = filter_var($nombreCafeteria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreCafeteria || empty($nombreCafeteria) ) {
            $this->errores['nombreCafeteria'] = 'El nombreCafeteria de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
           
          $cafeteria= \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($nombreCafeteria);

          $cafeteria->setCantidadDeLikes($cantidadLikes);
          $cafeteria->updateCafeteria($nombreCafeteria);
        //    $cafeteria->deleteFoto();
            }
            

    }
        

}





?>