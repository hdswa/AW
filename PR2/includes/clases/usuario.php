
<?php
require_once RAIZ_APP.'/config.php';
require_once RAIZ_APP.'/utils.php';
require_once RAIZ_APP.'/Aplicacion.php';
class Usuario {
    private $username;
    private $email;
    private $password;
    private $foto;
    private $rol;

    public function __construct($username, $email, $password, $foto) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->foto = $foto;
        $this->rol = "";
        
    }

    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['password'], $fila['rol']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . $conn->error;
            exit();
        }
        return $result;
    }

    public function register($username, $email, $password, $foto) {
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
                $query = sprintf("INSERT INTO Usuario(Nombre,Email, Contraseña,Foto_de_perfil,rol) VALUES('%s', '%s', '%s','%s','%s')"
                    , $conn->real_escape_string($username)
                    , $conn->real_escape_string($email)
                    , password_hash($password, PASSWORD_DEFAULT)
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
    
    public function getNombre() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getContraseña() {
        return $this->password;
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

    public function setContraseña($Contraseña) {
        $this->password = $Contraseña;
    }

    public function setFotoDePerfil($Foto_de_perfil) {
        $this->foto = $Foto_de_perfil;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}

?>  