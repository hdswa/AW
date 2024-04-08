<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCambiarFotoPerfil extends Formulario{
    private $nombre;
    public function __construct($nombre) {
        $this->nombre = $nombre;
        parent::__construct('formFotoPerfil', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/perfil.php'), 'enctype' => 'multipart/form-data']);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['foto'], $this->errores, 'span', array('class' => 'error'));
     
        $html = <<<EOS
        $htmlErroresGlobales
     
            <fieldset>
                <label for="foto">Foto:</label>
                <input type='file' name='foto' id='foto' required>
                {$erroresCampos['foto']}
                <input type="submit" value="Cambia tu foto">
            </fieldset>
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        if (count($this->errores) === 0) {

            $archivo = $_FILES['foto'];
            $nombreArchivo = basename($archivo['name']);

            $directorioDestino = dirname(__DIR__, 3) . '/img/perfiles/';
            $rutaCarpeta = "/img/perfiles/";
            $ruta_archivo = $directorioDestino . $nombreArchivo;
            $ruta_DB= $rutaCarpeta . $nombreArchivo;
            
            if(move_uploaded_file($archivo['tmp_name'], $ruta_archivo)){
                $user = \es\ucm\fdi\aw\usuarios\Usuario::buscaUsuario($this->nombre);
                if($user){
                    if ($user->setFotoDePerfil($ruta_DB)) {
                        echo "La imagen ha sido actualizada correctamente.";
                    } else {
                        echo "Hubo un error al actualizar la imagen en la base de datos.";
                    }
                }
                }
             else {
                echo "Hubo un error al mover el archivo subido.";
               
            }
            }
            else{
                $this->errores[] = "Error al subir el archivo";
            }

           
            
        
        

    }
        

}





?>