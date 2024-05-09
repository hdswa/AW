<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEliminarFoto extends Formulario{
    private $name;
 
    public function __construct($name) {
        $this->name = $name;
       
        parent::__construct('formDeleteImg', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php?action=user')]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precioProducto'], $this->errores, 'span', array('class' => 'error'));
        $name = $this->name;
        

        $html = <<<EOS
        $htmlErroresGlobales
        
        <input type="hidden" name="nombreUsuario" value="$name">
        <input type="submit" value="Eliminar Foto">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || empty($nombreUsuario) ) {
            $this->errores['nombreUsuario'] = 'El nombreUsuario de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
          $usuario= \es\ucm\fdi\aw\usuarios\Usuario::buscaUsuario($nombreUsuario);

            $usuario->deleteFoto();
            }
            

    }
        

}





?>