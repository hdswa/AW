
<?php
require_once RAIZ_APP.'/config.php';
require_once RAIZ_APP.'/utils.php';
require_once RAIZ_APP.'/Aplicacion.php';
class Usuario {
    private $username;
    private $email;
    private $contraseña;
    private $foto;
    private $rol;

    public function __construct($username, $email, $contraseña, $foto) {
        $this->username = $username;
        $this->email = $email;
        $this->contraseña = $contraseña;
        $this->foto = $foto;
        $this->rol = "";
        
    }

    public function register($username, $email, $contraseña, $foto) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $rol ="cliente";//defualt
        
        $query = sprintf("SELECT * FROM Usuario U WHERE U.Nombre = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        print($rs->num_rows);
        if ($rs) {
            if ($rs->num_rows > 0) {
                $erroresFormulario[] = 'El usuario ya existe';
                $rs->free();
                print("Ha entreado en if");
            } else {
                print("ha entredo en else");
                $query = sprintf("INSERT INTO Usuario(Nombre,Email, password,Foto_de_perfil,rol) VALUES('%s', '%s', '%s','%s','%s')"
                    , $conn->real_escape_string($username)
                    , $conn->real_escape_string($email)
                    , self::hashcontraseña($contraseña)
                    , $conn->real_escape_string($foto)
                    , $conn->real_escape_string($rol)
                );
                if ($conn->query($query)) {
                    return TRUE;
                } else {
                    echo "Error SQL ({$conn->errno}):  {$conn->error}";
                    exit();
                }
                
            }		
        } else {
            echo "Error SQL ({$conn->errno}):  {$conn->error}";
            exit();
        }
    }

    public static function hashcontraseña($contraseña)
    {
        return password_hash($contraseña, PASSWORD_BCRYPT); //he cambiado el algoritmo para que siempre sea una contraseña de 60 caracteres y no de error 
    }

    public static function login($nombre, $contraseña)
    {
        $usuario = self::buscaUsuario($nombre);
        if ($usuario && $usuario->compruebaContraseña($nombre, $contraseña)) {
            return $usuario;
        }
        return false;
    }
    
    public static function buscaUsuario($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['Nombre'], $fila['Email'], $fila['Password'], $fila['Foto_de_perfil']);
                $result = $user;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function compruebaContraseña($nombre, $contraseña)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if($fila){
                return password_verify($contraseña, $fila['Password']); 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }

    public function getNombre() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getpassword() {
        return $this->contraseña;
    }

    public function getFotoDePerfil() {
        return $this->foto;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setNombre($Nombre) {
        $this->username = $Nombre;
    }

    public function setEmail($Email) {
        $this->email = $Email;
    }

    public function setpassword($password) {
        $this->contraseña = $password;
    }

    public function setFotoDePerfil($Foto_de_perfil) {
        $this->foto = $Foto_de_perfil;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}

?>  