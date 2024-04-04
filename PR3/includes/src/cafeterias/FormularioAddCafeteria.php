<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioAddCafeteria extends Formulario{

    public function __construct() {
        parent::__construct('formAddCafeteria', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php'), 'enctype' => 'multipart/form-data']);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion','categoria','ubicacion','foto'], $this->errores, 'span', array('class' => 'error'));
     
        $html = <<<EOS
        $htmlErroresGlobales
        <h1>Vaya! Parece que aún no has creado tu propia cafetería...</h1>
        <p>Para comenzar, por favor, rellena el siguiente formulario:</p>
       
            <fieldset>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required><br>
                {$erroresCampos['nombre']}
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required><br>
                {$erroresCampos['descripcion']}
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" required><br>
                {$erroresCampos['categoria']}
                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion" required><br>
                {$erroresCampos['ubicacion']}
                <label for="foto">Foto:</label>
                <input type='file' name='foto' id='foto' required>
                {$erroresCampos['foto']}
                <input type="submit" value="Crea tu cafetería">
            </fieldset>
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre de usuario no puede estar vacío';
        }
        
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'El descripcion no puede estar vacío.';
        }

        $categoria = trim($datos['categoria'] ?? '');
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $categoria || empty($categoria) ) {
            $this->errores['categoria'] = 'El categoria no puede estar vacío.';
        }

        $ubicacion = trim($datos['ubicacion'] ?? '');
        $ubicacion = filter_var($ubicacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $ubicacion || empty($ubicacion) ) {
            $this->errores['ubicacion'] = 'El ubicacion no puede estar vacío.';
        }
       
        
        // $foto = trim($datos['foto'] ?? '');
        // $foto = filter_var($foto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // if ( ! $foto || empty($foto) ) {
        //     $this->errores['foto'] = 'El foto no puede estar vacío.';
        // }
      
        
        if (count($this->errores) === 0) {

            $archivo = $_FILES['foto'];
            $nombreArchivo = basename($archivo['name']);

            $directorioDestino = dirname(__DIR__, 3) . '/img/cafeterias/';
            $rutaCarpeta = "/img/cafeterias/";
            $ruta_archivo = $directorioDestino . $nombreArchivo;
            $ruta_DB= $rutaCarpeta . $nombreArchivo;
            
            if(move_uploaded_file($archivo['tmp_name'], $ruta_archivo)){
                echo "El archivo se subio correctamente";
            }
            else{
                $this->errores[] = "Error al subir el archivo";
            }

            $owner = $_SESSION['nombre'];
            $cafeteria = new Cafeteria($nombre, $descripcion,$owner, $categoria, $ubicacion, $ruta_DB, 0);
            if(!$cafeteria->saveCafeteria()){
                $this->errores[] = "La cafeteria ya existe o algo salio mal en la creacion de la cafeteria";
            }
            
        
        

    }
        

}

}



?>