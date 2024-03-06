<?php
require_once __DIR__.'/config.php';

class Usuario {
    private $id;
    private $nombreUsuario;
    private $nombre;
    private $password;
    private $rol;

    public function __construct($id, $nombreUsuario, $nombre, $password, $rol) {
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->rol = $rol;
    }

    public static function buscaUsuario($nombreUsuario) {
        // Suponiendo que $conn es la conexión a la base de datos
        global $conn;
        $query = "SELECT * FROM Usuarios WHERE nombreUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($fila = $resultado->fetch_assoc()) {
            return new Usuario($fila['id'], $fila['nombreUsuario'], $fila['nombre'], $fila['password'], $fila['rol']);
        } else {
            return false;
        }
    }

    public function compruebaPassword($password) {
        return password_verify($password, $this->password);
    }

    public static function login($nombreUsuario, $password) {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        } else {
            return false;
        }

    }

    public static function crea($nombreUsuario, $nombre, $password, $rol) {
        // Verificar si la conexión a la base de datos se realizó correctamente
        global $conn;
        if (!$conn) {
            echo "Error: No se pudo conectar a la base de datos";
            return false;
        }

        // Hash del password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar en la tabla Usuarios
        $query = "INSERT INTO Usuarios (nombreUsuario, nombre, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $conn->error;
            return false;
        }

        // Bind de parámetros para la inserción en la tabla Usuarios
        $stmt->bind_param("sss", $nombreUsuario, $nombre, $passwordHash);
        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }

        // Obtener el ID del usuario insertado
        $insertId = $stmt->insert_id;

        // Cerrar la declaración preparada para la inserción en la tabla Usuarios
        $stmt->close();

        // Ahora, insertar el registro en la tabla RolesUsuarios
        // Definir el ID del rol correspondiente
        $idRolUsuario = 2; // Por ejemplo, el rol de usuario

    // Preparar la consulta SQL para insertar en la tabla RolesUsuarios
        $query_roles_usuarios = "INSERT INTO RolesUsuario (usuario, rol) VALUES (?, ?)";
        $stmt_roles_usuarios = $conn->prepare($query_roles_usuarios);
        if (!$stmt_roles_usuarios) {
            echo "Error al preparar la consulta para RolesUsuario: " . $conn->error;
            return false;
        }

        // Bind de parámetros para la inserción en la tabla RolesUsuarios
        $stmt_roles_usuarios->bind_param("ii", $insertId, $idRolUsuario);
        if (!$stmt_roles_usuarios->execute()) {
            echo "Error al ejecutar la consulta para RolesUsuarios: " . $stmt_roles_usuarios->error;
            return false;
        }

        // Cerrar la declaración preparada para la inserción en la tabla RolesUsuarios
        $stmt_roles_usuarios->close();

        // Si todo ha ido bien, mostrar un mensaje de éxito
        echo "El usuario fue registrado correctamente.";


            
        // Crear y devolver el objeto Usuario
        return new Usuario($insertId, $nombreUsuario, $nombre, $passwordHash, $rol);
    }
    
/*
    public static function crea($nombreUsuario, $nombre, $password, $rol) {
        global $conn;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO Usuarios (nombreUsuario, nombre, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nombreUsuario, $nombre, $passwordHash, $rol);
        if ($stmt->execute()) {
            return new Usuario($conn->insert_id, $nombreUsuario, $nombre, $passwordHash, $rol);
        } else {
            return false;
        }
    }
    

    public static function crea($nombreUsuario, $nombre, $password, $rol) {
        // Suponiendo que $conn es la conexión a la base de datos
        global $conn;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO Usuarios (nombreUsuario, nombre, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nombreUsuario, $nombre, $passwordHash, $rol);
        if ($stmt->execute()) {
            return new Usuario($conn->insert_id, $nombreUsuario, $nombre, $passwordHash, $rol);
        } else {
            return false;
        }
    }
*/
     // Getters
     public function getId() {
        return $this->id;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    // Setters
    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }



    // Getters y setters para las propiedades si son necesarios
}

