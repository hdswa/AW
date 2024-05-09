<?php
namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioAddProducto extends Formulario
{
    private $cafeteriaNombre;
    public function __construct($cafeteriaNombre) {
        $this->cafeteriaNombre = $cafeteriaNombre;
        parent::__construct('formLogin', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php'),'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombreUsuario = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'precio','descripcion','foto'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
        <h1>Añade tu nuevo producto</h1>
        <p>Para añadir un nuevo producto rellane el siguiente formulario</p>

        
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="precio">Precio en €:</label>
            <input type="number" id="precio" name="precio" required><br>
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required><br>
            <label for="foto">Foto:</label>
            <input type='file' name='foto' required>
            <input type="submit" value="Añadir Producto">
        
        </fieldset>
        EOF;
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
        
        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precio || empty($precio) ) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
        }
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'El descripcion no puede estar vacío.';
        }
        


        if (count($this->errores) === 0) {
            $archivo = $_FILES['foto'];
            $nombreArchivo = basename($archivo['name']);

            $directorioDestino = dirname(__DIR__, 3) . '/img/productos/';
            $rutaCarpeta = "/img/productos/";
            $ruta_archivo = $directorioDestino . $nombreArchivo;
            $ruta_DB= $rutaCarpeta . $nombreArchivo;

            if(move_uploaded_file($archivo['tmp_name'], $ruta_archivo)){
                echo "El archivo se subio correctamente";

                $producto = new Producto($nombre,$this->cafeteriaNombre,$precio,$ruta_DB,$descripcion);
                if($producto->saveProducto()){
                    echo "Producto guardado correctamente";
                }
                else{
                    $this->errores[] = "Error al guardar el producto";
                }

            }
            else{
                $this->errores[] = "Error al subir el archivo";
            }

        }
    }
}
