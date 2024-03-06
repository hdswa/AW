-- Inserts para Usuario
INSERT INTO Usuario (id, Nombre, Email, Password, Foto_de_perfil, Rol)
VALUES (1, 'usuario1', 'usuario1@example.com', 'contraseña123', '/img/foto1.jpg', 'cliente'),
       (2, 'usuario2', 'usuario2@example.com', 'contraseña456', '/img/foto2.jpg', 'cliente'),
       (3, 'usuario3', 'usuario3@example.com', 'contraseña789', '/img/foto3.jpg', 'cliente'),
       (4, 'usuario4', 'usuario4@example.com', 'contraseñaabc', '/img/foto4.jpg', 'cliente'),
       (5, 'usuario5', 'usuario5@example.com', 'contraseñadef', '/img/foto5.jpg', 'cliente');

-- Inserts para Cafeteria
INSERT INTO Cafeteria (id, Nombre, Descripcion, id_Dueño, Ubicacion, Cantidad_de_likes)
VALUES (1, 'cafeteria1', 'Cafetería acogedora con una amplia variedad de bebidas y aperitivos.', 1, 'Calle Principal 123', 100),
       (2, 'cafeteria2', 'Cafetería moderna especializada en café de especialidad.', 2, 'Avenida Central 456', 150),
       (3, 'cafeteria3', 'Cafetería con ambiente relajado y wifi gratuito.', 3, 'Plaza del Sol 789', 80),
       (4, 'cafeteria4', 'Cafetería familiar con opciones saludables y pasteles caseros.', 4, 'Avenida Norte 234', 120),
       (5, 'cafeteria5', 'Cafetería con terraza al aire libre y música en vivo los fines de semana.', 5, 'Calle Sur 567', 200);

-- Insertar un chat entre dos usuarios
INSERT INTO Chat (id_Usuario1, id_Usuario2, Mensaje)
VALUES (1, 2, 'Hola, ¿cómo estás?');

-- Inserts para Comentarios (3 comentarios para una cafeteria)
INSERT INTO Comentarios (id, id_Usuario, id_Cafeteria, Valoracion, Mensaje)
VALUES (1, 1, 1, 5, 'Excelente café y ambiente acogedor.'),
       (2, 2, 2, 4, 'Buena variedad de bebidas, pero el servicio puede mejorar.'),
       (3, 3, 3, 5, 'Me encanta este lugar, siempre vengo a estudiar aquí.');

-- Inserts para Productos (20 productos repartidos entre las diferentes cafeterias)
INSERT INTO Productos (id, Nombre, id_Cafeteria, Precio, Descripcion)
VALUES (1, 'Café Latte', 1, 2.50, 'Café espresso con leche caliente y espuma de leche.'),
       (2, 'Capuchino', 1, 3.00, 'Café espresso con leche vaporizada y espuma de leche.'),
       (3, 'Té Verde Matcha', 2, 3.50, 'Té verde japonés en polvo con leche caliente o fría.'),
       (4, 'Café Americano', 2, 2.00, 'Café espresso mezclado con agua caliente.'),
       (5, 'Muffin de Arándanos', 3, 2.50, 'Delicioso muffin con arándanos frescos.'),
       (6, 'Croissant de Chocolate', 3, 2.00, 'Croissant hojaldrado relleno de chocolate.'),
       (7, 'Bagel de Salmón', 4, 5.00, 'Bagel integral con salmón ahumado, queso crema y pepino.'),
       (8, 'Ensalada César', 4, 6.50, 'Ensalada fresca con pollo a la parrilla, crutones y aderezo César.'),
       (9, 'Tostada de Aguacate', 5, 4.50, 'Tostada de pan integral con aguacate, huevo pochado y tomate cherry.'),
       (10, 'Smoothie de Frutas Tropicales', 5, 4.00, 'Batido refrescante con mango, piña y plátano.');

-- Puedes continuar agregando más productos para las diferentes cafeterías de manera similar.
-- Insert para Carrito del Usuario1 con 5 productos
INSERT INTO Carrito (id_Dueño, Item_list, Pagado)
VALUES (1, 
        '[
            {"Nombre":"Café Latte","Cantidad":2,"Precio":2.50},
            {"Nombre":"Capuchino","Cantidad":1,"Precio":3.00},
            {"Nombre":"Muffin de Arándanos","Cantidad":3,"Precio":2.50},
            {"Nombre":"Bagel de Salmón","Cantidad":1,"Precio":5.00},
            {"Nombre":"Tostada de Aguacate","Cantidad":2,"Precio":4.50}
        ]', 
       0);

INSERT INTO RolesUsuario (usuario, rol) 
VALUES (1, 1),
       (1, 2),
       (2, 2);

INSERT INTO Roles (id, nombre) 
VALUES (1, 'admin'),
       (2, 'user');
