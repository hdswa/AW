<?php
namespace es\ucm\fdi\aw\comentarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEliminarComentario extends Formulario{
    private $id;
 
    public function __construct($id) {
        $this->id = $id;
        parent::__construct('formdeleteComment', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php?action=comentario')]); 

    }
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['idCommentario'], $this->errores, 'span', array('class' => 'error'));
        $id = $this->id;
        

        $html = <<<EOS
        $htmlErroresGlobales
       
        <input type="hidden" name="idCommentario" value="$id">
        <input type="submit" value="Eliminar Comentario">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $idCommentario = $datos['idCommentario'];
        $idCommentario = filter_var($idCommentario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $idCommentario || empty($idCommentario) ) {
            $this->errores['idCommentario'] = 'El idCommentario de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
           $comentario=\es\ucm\fdi\aw\comentarios\Comentarios::getComentarioById($idCommentario);
           $comentario->deleteComentario($idCommentario);
            }
    }
        

}





?>