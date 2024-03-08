
-- Drop tables if they exist
DROP TABLE IF EXISTS Chat;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Cafeteria;
DROP TABLE IF EXISTS Usuario;
DROP TABLE IF EXISTS Seguidores;


-- Tabla Usuario
CREATE TABLE Usuario (
    Nombre VARCHAR(50) PRIMARY KEY,
    Email VARCHAR(100),
    Password VARCHAR(100),
    Foto_de_perfil VARCHAR(255),
    Rol VARCHAR(50)
);

-- Tabla Cafetería
CREATE TABLE Cafeteria (
    Nombre VARCHAR(50) PRIMARY KEY,
    Descripcion TEXT,
    Owner VARCHAR(50),
    FOREIGN KEY (Owner) REFERENCES Usuario(Nombre),
    Categoria VARCHAR(50),
    Ubicacion VARCHAR(255),
    Foto VARCHAR(255),
    Cantidad_de_likes INT
);

-- Tabla Productos
CREATE TABLE Productos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Cafeteria_Owner VARCHAR(50),
    FOREIGN KEY (Cafeteria_Owner) REFERENCES Cafeteria(Nombre),
    Precio DECIMAL(10,2),
    Foto VARCHAR(255),
    Descripcion TEXT
);

-- Tabla Carrito
CREATE TABLE Carrito (
  Owner VARCHAR(50),
  Item_list JSON,
  Pagado BOOLEAN,
  FOREIGN KEY (Owner) REFERENCES Usuario(Nombre)
);



-- Tabla Comentarios
CREATE TABLE Comentarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Usuario VARCHAR(50),
    Cafeteria_Comentada VARCHAR(50),
    Valoracion INT,
    Mensaje TEXT,
    FOREIGN KEY (Usuario) REFERENCES Usuario(Nombre),
    FOREIGN KEY (Cafeteria_Comentada) REFERENCES Cafeteria(Nombre)
);

-- Tabla Chat
CREATE TABLE Chat (
    Usuario1 VARCHAR(50),
    Usuario2 VARCHAR(50),
    Mensaje TEXT,
    Tiempo_de_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Usuario1) REFERENCES Usuario(Nombre),
    FOREIGN KEY (Usuario2) REFERENCES Usuario(Nombre)
);

-- Tabla Seguidores
CREATE TABLE Seguidores (
    Seguidor VARCHAR(50),
    Seguido VARCHAR(50),
    FOREIGN KEY (Seguidor) REFERENCES Usuario(Nombre),
    FOREIGN KEY (Seguido) REFERENCES Usuario(Nombre),
    PRIMARY KEY (Seguidor, Seguido)
);

