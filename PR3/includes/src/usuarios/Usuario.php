<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Usuario
{
    use MagicProperties;

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($nombreUsuario, $password, $email,$foto, $rol)
    {
        $user = new Usuario($nombreUsuario, $email,self::hashPassword($password), "",$rol);
        if($user->guarda()){
            return $user;
        }
        else{
            return false;
        }
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.Nombre='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['Nombre'], $fila['Email'], $fila['Password_hash'], $fila['Foto_de_perfil'], $fila['Rol']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios WHERE id=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['nombreUsuario'], $fila['password'], $fila['nombre'], $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function cargaRoles($usuario)
    {
        $roles=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->id
        );
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuario (Nombre, Email, Password_hash, Foto_de_perfil, Rol) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->foto)
            , $conn->real_escape_string($usuario->roles)
        );
        if ( $conn->query($query) ) {
            // $usuario->id = $conn->insert_id;
            // $result = self::insertaRoles($usuario);
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        foreach($usuario->roles as $rol) {
            $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"
                , $usuario->id
                , $rol
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuarios U SET nombreUsuario = '%s', nombre='%s', password='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            $result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuarios U WHERE U.id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $nombre;

    private $email;

    private $password;

    private $foto;

    private $roles;

    private function __construct($nombre, $email, $password, $foto = null, $roles = [])
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->foto = $foto;
        $this->roles = $roles;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function añadeRol($role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function tieneRol($role)
    {
        if ($this->roles == null) {
            self::cargaRoles($this);
        }
        return array_search($role, $this->roles) !== false;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        // if ($this->id !== null) {
        //     return self::actualiza($this);
        // }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }


    public function encontrarSeguidos() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $seguidos = [];
    
        $query = sprintf("SELECT U.Nombre, U.Email, U.Password_hash, U.Foto_de_perfil FROM Usuario U INNER JOIN Seguidores S ON U.Nombre = S.Seguido WHERE S.Seguidor='%s'", $conn->real_escape_string($this->nombre));
    
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $usuario = new Usuario($fila['Nombre'], $fila['Email'], $fila['Password_hash'], $fila['Foto_de_perfil']);
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
                         $conn->real_escape_string($this->nombre),
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
                         $conn->real_escape_string($this->nombre),
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
        $rutaFoto =".";
        // Comprobar si existe una foto de perfil, de lo contrario, usar una predeterminada
        $rutaFoto .= $this->foto ? $this->foto : './img/basic/user.png';
      
        $perfil .= "<img src='" . htmlspecialchars($rutaFoto) . "' alt='Foto de perfil' style='width: 200px; height: 200px;' class='imagen_perfil' />";

        //Formulario para modificar la foto de perfil del usuario
       
        // Mostrar el nombre de usuario
        $perfil .= "<p>Nombre de Usuario: " . htmlspecialchars($this->nombre) . "</p>";
        
        // Mostrar el email
        $perfil .= "<p>Email: " . htmlspecialchars($this->email) . "</p>";
        
       
        // Finalizar el HTML
        $perfil .= "</div>";

        return $perfil;
    }
    public function setFotoDePerfil($Foto_de_perfil) {
        $this->foto = $Foto_de_perfil;

            // Obtén la conexión a la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Prepara la consulta SQL para actualizar la ruta de la foto de perfil
        $query = sprintf("UPDATE Usuario U SET U.Foto_de_perfil='%s' WHERE U.Nombre='%s'",
                        $conn->real_escape_string($Foto_de_perfil),
                        $conn->real_escape_string($this->nombre));

        // Ejecuta la consulta
        if ($conn->query($query) === TRUE) {
            return true; // Actualización exitosa
        } else {
            error_log("Error al actualizar la foto de perfil: " . $conn->error);
            return false; // Error al actualizar
        }
    }
}
