
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
                $query = sprintf("INSERT INTO Usuario(Nombre, Email, Password_hash, Foto_de_perfil,rol) VALUES('%s', '%s', '%s','%s', '%s')"
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
        $query = sprintf("SELECT * FROM Usuario U WHERE U.Nombre='%s'", $conn->real_escape_string($nombre));
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
            $result = false;    
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function compruebaContraseña($nombre, $contraseña)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.Nombre='%s'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if($fila){
                return password_verify($contraseña, $fila['Password_hash']); 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }

    public function encontrarSeguidos() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $seguidos = [];
    
        $query = sprintf("SELECT U.Nombre, U.Email, U.Password, U.Foto_de_perfil FROM Usuario U INNER JOIN Seguidores S ON U.Nombre = S.Seguido WHERE S.Seguidor='%s'", $conn->real_escape_string($this->username));
    
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $usuario = new Usuario($fila['Nombre'], $fila['Email'], $fila['Password'], $fila['Foto_de_perfil']);
                array_push($seguidos, $usuario);
            }
            $rs->free();
        } else {
            error_log("Error SQL ({$conn->errno}): {$conn->error}");
        }
    
        return $seguidos;
    }

    public function seguirUsuario($nombreUsuarioASeguir) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Seguidores (Seguidor, Seguido) VALUES ('%s', '%s')",
                         $conn->real_escape_string($this->username),
                         $conn->real_escape_string($nombreUsuarioASeguir));
    
        if ($conn->query($query)) {
            return true; // Seguimiento exitoso
        } else {
            error_log("Error al intentar seguir al usuario ({$conn->errno}): {$conn->error}");
            return false; // Error al seguir al usuario
        }
    }
    
    public function dejarDeSeguirUsuario($nombreUsuarioADejarDeSeguir) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Seguidores WHERE Seguidor='%s' AND Seguido='%s'",
                         $conn->real_escape_string($this->username),
                         $conn->real_escape_string($nombreUsuarioADejarDeSeguir));
    
        if ($conn->query($query)) {
            return true; // Dejó de seguir exitosamente
        } else {
            error_log("Error al intentar dejar de seguir al usuario ({$conn->errno}): {$conn->error}");
            return false; // Error al dejar de seguir al usuario
        }
    }
    

    public function perfilUsuario() {
        // Iniciar la construcción del HTML
        $perfil = "<div class='perfil-usuario'>";

        // Comprobar si existe una foto de perfil, de lo contrario, usar una predeterminada
        $rutaFoto = $this->foto ? $this->foto : './img/basic/user.png';
        $perfil .= "<img src='" . htmlspecialchars($rutaFoto) . "' alt='Foto de perfil' style='width: 200px; height: 200px;' class='imagen_perfil' />";

        //Formulario para modificar la foto de perfil del usuario
        $perfil .= <<<HTML
        <form action="procesarImagenUser.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="username" value="{$this->username}">
            <input type="file" name="fotoPerfil" required>
            <button type="submit">Añadir Foto</button>
        </form>
        HTML;

        // Mostrar el nombre de usuario
        $perfil .= "<p>Nombre de Usuario: " . htmlspecialchars($this->username) . "</p>";
        
        // Mostrar el email
        $perfil .= "<p>Email: " . htmlspecialchars($this->email) . "</p>";
        
       
        // Finalizar el HTML
        $perfil .= "</div>";

        return $perfil;
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

            // Obtén la conexión a la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Prepara la consulta SQL para actualizar la ruta de la foto de perfil
        $query = sprintf("UPDATE Usuario U SET U.Foto_de_perfil='%s' WHERE U.Nombre='%s'",
                        $conn->real_escape_string($Foto_de_perfil),
                        $conn->real_escape_string($this->username));

        // Ejecuta la consulta
        if ($conn->query($query) === TRUE) {
            return true; // Actualización exitosa
        } else {
            error_log("Error al actualizar la foto de perfil: " . $conn->error);
            return false; // Error al actualizar
        }
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}

?>  