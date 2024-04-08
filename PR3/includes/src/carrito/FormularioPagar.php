<?php
namespace es\ucm\fdi\aw\carrito;
require_once __DIR__ . '/../../config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioPagar extends Formulario{
    private $owner;
    public function __construct($owner) {
        $this->owner = $owner;
        parent::__construct('formAddCafeteria', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/carrito.php?success=1'), 'enctype' => 'multipart/form-data']);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['foto'], $this->errores, 'span', array('class' => 'error'));
     
        $html = <<<EOS
        $htmlErroresGlobales
     
            <fieldset>
            <input type="submit" value="Pagar">
            </fieldset>
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        if (count($this->errores) === 0) {
            $carrito= \es\ucm\fdi\aw\carrito\Carrito::getCarritoByOwner($this->owner);
            if(!$carrito){
                $contenidoPrincipal .= "<h1>Carrito no encontrado.</h1>";
            }
            else{
                if ($carrito->realizarPago()) {
                    $contenidoPrincipal .= "<h1>Compra realizada con éxito.</h1>";
                    // Opcional: Redirigir al usuario a una página de confirmación
                    // header('Location: confirmacionPago.php');
                    // exit;
                } else {
                    $contenidoPrincipal .= "<h1>Hubo un problema al realizar la compra.</h1>";
                }
            }
            }
          echo "pagado";

          return $contenidoPrincipal;
    }
   
    

}





?>