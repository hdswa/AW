<?php

class Chat {
    private $Usuario1;
    private $Usuario2;
    private $Mensaje;
    private $Tiempo_de_envio;

    public function __construct($Usuario1, $Usuario2, $Mensaje, $Tiempo_de_envio) {
        $this->Usuario1 = $Usuario1;
        $this->Usuario2 = $Usuario2;
        $this->Mensaje = $Mensaje;
        $this->Tiempo_de_envio = $Tiempo_de_envio;
    }

    public function getUsuario1() {
        return $this->Usuario1;
    }

    public function setUsuario1($Usuario1) {
        $this->Usuario1 = $Usuario1;
    }

    public function getUsuario2() {
        return $this->Usuario2;
    }

    public function setUsuario2($Usuario2) {
        $this->Usuario2 = $Usuario2;
    }

    public function getMensaje() {
        return $this->Mensaje;
    }

    public function setMensaje($Mensaje) {
        $this->Mensaje = $Mensaje;
    }

    public function getTiempoDeEnvio() {
        return $this->Tiempo_de_envio;
    }

    public function setTiempoDeEnvio($Tiempo_de_envio) {
        $this->Tiempo_de_envio = $Tiempo_de_envio;
    }

}

?>