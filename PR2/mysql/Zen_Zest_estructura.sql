-- Drop tables if they exist
DROP TABLE IF EXISTS Chat;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Cafeteria;
DROP TABLE IF EXISTS Usuario;
-- Tabla Usuario
CREATE TABLE IF NOT EXISTS Usuario (
    id int(11) NOT NULL AUTO_INCREMENT,
    Nombre varchar(50),
    Email varchar(100),
    Password varchar(100),
    Foto_de_perfil varchar(255),
    Rol varchar(50),
    PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Cafetería
CREATE TABLE IF NOT EXISTS Cafeteria (
    id int(11) NOT NULL AUTO_INCREMENT,
    Nombre varchar(50),
    Descripcion TEXT,
    id_Dueño int(11),
    FOREIGN KEY (id_Dueño) REFERENCES Usuario(id),
    Ubicacion varchar(255),
    Cantidad_de_likes int(11),
    PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Productos
CREATE TABLE IF NOT EXISTS Productos (
    id int(11) NOT NULL AUTO_INCREMENT,
    Nombre varchar(100),
    id_Cafeteria int(11),
    FOREIGN KEY (id_Cafeteria) REFERENCES Cafeteria(id),
    Precio DECIMAL(10,2),
    Descripcion TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Carrito
CREATE TABLE IF NOT EXISTS Carrito (
    id_Dueño int(11),
    Item_list JSON,
    Pagado BOOLEAN,
    FOREIGN KEY (id_Dueño) REFERENCES Usuario(id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Comentarios
CREATE TABLE IF NOT EXISTS Comentarios (
    id int(11) NOT NULL AUTO_INCREMENT,
    id_Usuario int(11),
    id_Cafeteria int(11),
    Valoracion INT,
    Mensaje TEXT,
    FOREIGN KEY (id_Usuario) REFERENCES Usuario(id),
    FOREIGN KEY (id_Cafeteria) REFERENCES Cafeteria(id),
    PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Chat
CREATE TABLE IF NOT EXISTS Chat (
    id_Usuario1 int(11),
    id_Usuario2 int(11),
    Mensaje TEXT,
    Tiempo_de_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_Usuario1) REFERENCES Usuario(id),
    FOREIGN KEY (id_Usuario2) REFERENCES Usuario(id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Roles (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS RolesUsuario (
  usuario int(11) NOT NULL,
  rol int(11) NOT NULL,
  PRIMARY KEY (usuario,rol),
  KEY rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
