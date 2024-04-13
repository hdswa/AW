<?php
namespace es\ucm\fdi\aw\comentarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioComentario extends Formulario {
    private $cafeteriaNombre;
    private $usuarioNombre;

    public function __construct($cafeteriaNombre) {
        $this->cafeteriaNombre = $cafeteriaNombre;
        $this->usuarioNombre = $_SESSION['nombre'];  // Asegúrate de que el usuario está logueado.
        $urlRedireccion = Aplicacion::getInstance()->resuelve("/cafeteriaDetail.php?name=" . urlencode($cafeteriaNombre));
        parent::__construct('formComentario', [
            'urlRedireccion' => $urlRedireccion
        ]);
    }

    protected function generaCamposFormulario(&$datos) {
        $valoracion = $datos['valoracion'] ?? 5;  // Valor predeterminado de 5
        $html = <<<EOF
        <textarea name="mensaje" placeholder="Escribe tu comentario aquí..." required></textarea>
        <input type="hidden" name="cafeteria" value="{$this->cafeteriaNombre}" required>
        <select name="valoracion">
            <option value="1" {$this->selected(1, $valoracion)}>1 estrella</option>
            <option value="2" {$this->selected(2, $valoracion)}>2 estrellas</option>
            <option value="3" {$this->selected(3, $valoracion)}>3 estrellas</option>
            <option value="4" {$this->selected(4, $valoracion)}>4 estrellas</option>
            <option value="5" {$this->selected(5, $valoracion)}>5 estrellas</option>
        </select>
        <input type="submit" name="submitComment" value="Enviar Comentario"></input>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $cafeteria = $datos['cafeteria'] ?? null;
        $mensaje = $datos['mensaje'] ?? '';
        $valoracion = $datos['valoracion'] ?? 5;

        if (!$cafeteria || empty($mensaje)) {
            $this->errores[] = "Error: Todos los campos deben ser completados.";
            return;
        }

        // Asume que existe una función estática para guardar comentarios
        if (!\es\ucm\fdi\aw\comentarios\Comentarios::guardarComentario($this->usuarioNombre, $cafeteria, $mensaje, $valoracion)) {
            $this->errores[] = "Error al guardar el comentario.";
        }
    }

    private function selected($optionValue, $value) {
        return ($optionValue == $value) ? 'selected' : '';
    }
}
