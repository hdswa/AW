<?php
namespace es\ucm\fdi\aw\cafeterias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;


class FormularioLikeCafeteria extends Formulario {
    private $cafeteriaNombre;
    private $usuarioNombre;
    public function __construct($cafeteriaNombre) {
        $this->cafeteriaNombre = $cafeteriaNombre;
        $this->usuarioNombre = $_SESSION['nombre'];
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?name=" . urlencode($cafeteriaNombre));
        parent::__construct('formDarLike', [
            'urlRedireccion' => $urlRedireccion
        ]);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Comprueba si el usuario ya dio like
        $yaDioLike = Cafeteria::yaDioLike($this->usuarioNombre, $this->cafeteriaNombre);
        
        $botonTexto = $yaDioLike ? '💙' : '👍';
        $accion = $yaDioLike ? 'dislike' : 'like';

        $html = <<<EOF
        <input type="hidden" name="cafeteria" value="{$this->cafeteriaNombre}" required>
        <input type="hidden" name="action" value="{$accion}">
        <button type="submit" name="like">{$botonTexto}</button>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $cafeteria = $datos['cafeteria'] ?? null;
        $accion = $datos['action'] ?? 'like';
        
        if (!$cafeteria) {
            $this->errores[] = "Error: Cafetería no especificada.";
            return;
        }

        if ($accion === 'like') {
            if (!Cafeteria::incrementarLikes($cafeteria, $this->usuarioNombre)) {
                $this->errores[] = "Error al procesar el like.";
            }
        } else {
            if (!Cafeteria::disminuirLikes($cafeteria, $this->usuarioNombre)) { // Asume que esta función existe
                $this->errores[] = "Error al procesar el dislike.";
            }
        }
    }
    
}
