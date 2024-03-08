-- Inserts para Usuario
-- Inserts para Usuario
INSERT INTO Usuario (Nombre, Email, Password_hash, Foto_de_perfil, Rol)
VALUES ('lucia', 'lucia@example.com', '$2y$10$Lwgd1aHNKQeSR0APjDugtOqoLSSmb4zflF8lzz2VW0bThO7vhUnsW', '/img/perfiles/lucia_fotopersonal.jpg', 'cliente'),
       ('maria', 'maria@example.com', '$2y$10$uLQGjf5eWq4YTvsOHtUMFe8gOU0IFvtsh5dmgjR68ukkekzzMO7FS', '/img/perfiles/maria_fotopersonal.jpg', 'cliente'),
       ('usuario1', 'usuario1@example.com', '$2y$10$8CiAtMxhTmVAwVG8NPPN8uzQkZofRB4qz3y2EvzromhllHBAobJWW', '/img/foto1.jpg', 'cliente'),
       ('usuario2', 'usuario2@example.com', '$2y$10$xaI9VQHt9aIFYnsRPSuWcuszGYOz6N8WJbRSNhxNhU2UMJjx8eUB.', '/img/foto2.jpg', 'cliente'),
       ('usuario3', 'usuario3@example.com', '$2y$10$RO4EbCSxOF5YV8Qn1rbJYOf.xg7XJCLwYhjzmJCxZz32Wvg0n/C/a', '/img/foto3.jpg', 'cliente'),
       ('usuario4', 'usuario4@example.com', '$2y$10$PLrvUUvAiURYb0IJriCWK.sESSHgSKsoIaV6MqMxMPsCHa7N/.O.e', '/img/foto4.jpg', 'cliente'),
       ('usuario5', 'usuario5@example.com', '$2y$10$U6szMhYxKJqJKUR9NbXxm.59ppl0Qgoc/tPOmynIKhEQ8F8oVgoPm', '/img/foto5.jpg', 'cliente');


-- Inserts para Cafeteria
INSERT INTO Cafeteria (Nombre, Descripcion, Owner, Categoria, Ubicacion,Foto, Cantidad_de_likes)
VALUES ('cafeteria1', 'Cafetería acogedora con una amplia variedad de bebidas y aperitivos.', 'usuario1', 'Café', 'Calle Principal 123','/img/basic/logo.png', 100),
       ('cafeteria2', 'Cafetería moderna especializada en café de especialidad.', 'usuario2', 'Café', 'Avenida Central 456','/img/basic/logo.png', 150),
       ('cafeteria3', 'Cafetería con ambiente relajado y wifi gratuito.', 'usuario3', 'Café', 'Plaza del Sol 789','/img/basic/logo.png', 80),
       ('cafeteria4', 'Cafetería familiar con opciones saludables y pasteles caseros.', 'usuario4', 'Café', 'Avenida Norte 234','/img/basic/logo.png', 120),
       ('cafeteria5', 'Cafetería con terraza al aire libre y música en vivo los fines de semana.', 'usuario5', 'Café', 'Calle Sur 567','/img/basic/logo.png', 200);

-- Insertar un chat entre dos usuarios
INSERT INTO Chat (Usuario1, Usuario2, Mensaje)
VALUES ('usuario1', 'usuario2', 'Hola, ¿cómo estás?');

-- Inserts para Comentarios (3 comentarios para una cafeteria)
INSERT INTO Comentarios (Usuario, Cafeteria_Comentada, Valoracion, Mensaje)
VALUES ('usuario1', 'cafeteria1', 5, 'Excelente café y ambiente acogedor.'),
       ('usuario2', 'cafeteria1', 4, 'Buena variedad de bebidas, pero el servicio puede mejorar.'),
       ('usuario3', 'cafeteria1', 5, 'Me encanta este lugar, siempre vengo a estudiar aquí.');

-- Inserts para Productos (20 productos repartidos entre las diferentes cafeterias)
INSERT INTO Productos (Nombre, Cafeteria_Owner, Precio, Foto, Descripcion)
VALUES ('Café Latte', 'cafeteria1', 2.50,'/img/basic/logo.png', 'Café espresso con leche caliente y espuma de leche.'),
       ('Capuchino', 'cafeteria1', 3.00,'/img/basic/logo.png', 'Café espresso con leche vaporizada y espuma de leche.'),
       ('Té Verde Matcha', 'cafeteria2', 3.50,'/img/basic/logo.png', 'Té verde japonés en polvo con leche caliente o fría.'),
       ('Café Americano', 'cafeteria2', 2.00,'/img/basic/logo.png', 'Café espresso mezclado con agua caliente.'),
       ('Muffin de Arándanos', 'cafeteria3', 2.50,'/img/basic/logo.png', 'Delicioso muffin con arándanos frescos.'),
       ('Croissant de Chocolate', 'cafeteria3', 2.00,'/img/basic/logo.png', 'Croissant hojaldrado relleno de chocolate.'),
       ('Bagel de Salmón', 'cafeteria4', 5.00,'/img/basic/logo.png', 'Bagel integral con salmón ahumado, queso crema y pepino.'),
       ('Ensalada César', 'cafeteria4', 6.50,'/img/basic/logo.png', 'Ensalada fresca con pollo a la parrilla, crutones y aderezo César.'),
       ('Tostada de Aguacate', 'cafeteria5', 4.50,'/img/basic/logo.png', 'Tostada de pan integral con aguacate, huevo pochado y tomate cherry.'),
       ('Smoothie de Frutas Tropicales', 'cafeteria5', 4.00,'/img/basic/logo.png', 'Batido refrescante con mango, piña y plátano.');

-- Puedes continuar agregando más productos para las diferentes cafeterías de manera similar.
-- Insert para Carrito del Usuario1 con 5 productos
INSERT INTO Carrito (Owner, Item_list, Pagado)
VALUES ('usuario1', 
        '[
            {"Nombre":"Café Latte","Cantidad":2,"Precio":2.50},
            {"Nombre":"Capuchino","Cantidad":1,"Precio":3.00},
            {"Nombre":"Muffin de Arándanos","Cantidad":3,"Precio":2.50},
            {"Nombre":"Bagel de Salmón","Cantidad":1,"Precio":5.00},
            {"Nombre":"Tostada de Aguacate","Cantidad":2,"Precio":4.50}
        ]'
        , FALSE
       );


INSERT INTO Seguidores (Seguidor, Seguido)
VALUES ('usuario1', 'usuario2'),
       ('usuario2', 'usuario1'),
       ('usuario3', 'usuario2'),
       ('lucia', 'usuario1'),
       ('lucia', 'usuario2'),
       ('lucia', 'usuario3');


