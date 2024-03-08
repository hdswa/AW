<?php

class Comentarios {
    private $ID;
    private $Usuario;
    private $Cafeteria_Comentada;
    private $Valoracion;
    private $Mensaje;

    public function __construct($ID, $Usuario, $Cafeteria_Comentada, $Valoracion, $Mensaje) {
        $this->ID = $ID;
        $this->Usuario = $Usuario;
        $this->Cafeteria_Comentada = $Cafeteria_Comentada;
        $this->Valoracion = $Valoracion;
        $this->Mensaje = $Mensaje;
    }

    public static function getComentariosDeSeguidos($usuariosSeguidos) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $usuariosSeguidos = array_map([$conn, 'real_escape_string'], $usuariosSeguidos);
        $inQuery = "'" . join("','", $usuariosSeguidos) . "'";
        
        $query = "SELECT * FROM Comentarios WHERE Usuario IN ($inQuery) ORDER BY ID DESC";
    
        $result = $conn->query($query);
        $comentarios = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $comentarios[] = new Comentarios($row['ID'], $row['Usuario'], $row['Cafeteria_Comentada'], $row['Valoracion'], $row['Mensaje']);
            }
            $result->free();
        }
        return $comentarios;
    }
    


    // Getters and Setters
    public function getID() {
        return $this->ID;
    }

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function getUsuario() {
        return $this->Usuario;
    }

    public function setUsuario($Usuario) {
        $this->Usuario = $Usuario;
    }

    public function getCafeteriaComentada() {
        return $this->Cafeteria_Comentada;
    }

    public function setCafeteriaComentada($Cafeteria_Comentada) {
        $this->Cafeteria_Comentada = $Cafeteria_Comentada;
    }

    public function getValoracion() {
        return $this->Valoracion;
    }

    public function setValoracion($Valoracion) {
        $this->Valoracion = $Valoracion;
    }

    public function getMensaje() {
        return $this->Mensaje;
    }

    public function setMensaje($Mensaje) {
        $this->Mensaje = $Mensaje;
    }
}


?>
