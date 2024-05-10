<?php
namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioVerProducto extends Formulario{
    private $nombreProducto;
    private $precio;
    private $foto;
    private $owner;
    private $cafeteriaNombre;
 
    public function __construct($nombreProducto, $precio, $foto, $owner,$cafeteriaNombre) {
        $this->nombreProducto = $nombreProducto;
        $this->precio = $precio;
        $this->foto = $foto;
        $this->owner = $owner;
        $this->cafeteriaNombre = $cafeteriaNombre;
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?producto=$nombreProducto&&cafeNombre=$cafeteriaNombre");
       
        
        parent::__construct('formVerProducto', ['urlRedireccion' => Aplicacion::getInstance()->resuelve($urlRedireccion)]); 
    }


    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['cafeteriaNombre','nombreProducto','precio','foto','owner'], $this->errores, 'span', array('class' => 'error'));
       
        

        $html = <<<EOS
        $htmlErroresGlobales
        <input type="hidden" name="cafeteriaNombre" value="$this->cafeteriaNombre">
        <input type="hidden" name="nombreProducto" value="$this->nombreProducto">
        <input type="hidden" name="precio" value="$this->precio">
        <input type="hidden" name="foto" value="$this->foto">
        <input type="hidden" name="owner" value="$this->owner">
        <input type="submit" value="Editar Producto">
       
        EOS;

        return $html;
    }


    protected function procesaFormulario(&$datos)
    {
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreProducto || empty($nombreProducto) ) {
            $this->errores['nombreProducto'] = 'El nombreProducto de usuario no puede estar vacío';
        }
        $owner = trim($datos['owner'] ?? '');
        $owner = filter_var($owner, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $owner || empty($owner) ) {
            $this->errores['owner'] = 'El owner de usuario no puede estar vacío';
        }
        $foto = trim($datos['foto'] ?? '');
        $foto = filter_var($foto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $foto || empty($foto) ) {
            $this->errores['foto'] = 'El foto de usuario no puede estar vacío';
        }
        $cafeteriaNombre = trim($datos['cafeteriaNombre'] ?? '');
        $cafeteriaNombre = filter_var($cafeteriaNombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $cafeteriaNombre || empty($cafeteriaNombre) ) {
            $this->errores['cafeteriaNombre'] = 'El cafeteriaNombre de usuario no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {
            $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?producto=$nombreProducto&&cafeNombre=$cafeteriaNombre");
            header("Location:$urlRedireccion");
            }
    }
        

}





?>