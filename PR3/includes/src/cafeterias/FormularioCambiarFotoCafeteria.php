<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCambiarFotoCafeteria extends Formulario{
    private $cafeteriaNombre;
    public function __construct($cafeteriaNombre) {
        $this->cafeteriaNombre = $cafeteriaNombre;
        parent::__construct('formAddCafeteria', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php'), 'enctype' => 'multipart/form-data']);
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

            $directorioDestino = dirname(__DIR__, 3) . '/img/cafeterias/';
            $rutaCarpeta = "/img/cafeterias/";
            $ruta_archivo = $directorioDestino . $nombreArchivo;
            $ruta_DB= $rutaCarpeta . $nombreArchivo;
            
            if(move_uploaded_file($archivo['tmp_name'], $ruta_archivo)){
               
                $cafeteria = \es\ucm\fdi\aw\cafeterias\Cafeteria::getCafeteriaByName($this->cafeteriaNombre);
                if($cafeteria){
                    echo "Cafeteria ya existente";
                    if ($cafeteria->setFoto($ruta_DB)) {
                     
                    } else {
                        echo "Hubo un error al actualizar la imagen en la base de datos.";
                       
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

}



?>