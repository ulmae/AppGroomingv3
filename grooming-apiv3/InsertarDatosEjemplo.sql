-- Script de Inserción de Datos de Ejemplo
-- Sistema de Grooming - SQL Server
USE sistema_grooming;
GO

-- 1. Insertar Clientes
INSERT INTO customers (full_name, phone_number, email) VALUES
('María González', '7234-5678', 'maria.gonzalez@email.com'),
('Carlos Rodríguez', '7845-9123', 'carlos.rodriguez@email.com'),
('Ana Patricia López', '7567-4321', 'ana.lopez@email.com'),
('Roberto Martínez', '7888-7777', 'roberto.martinez@email.com'),
('Sofía Hernández', '7234-1111', NULL);

-- 2. Insertar Usuarios del Sistema
INSERT INTO users (full_name, role, email, password_hash) VALUES
('Laura Beatriz Vásquez', 'receptionist', 'laura.vasquez@grooming.com', 'hash_password_123'),
('Pedro Antonio Morales', 'groomer', 'pedro.morales@grooming.com', 'hash_password_456'),
('Carlos Eduardo Ramírez', 'admin', 'carlos.ramirez@grooming.com', 'hash_password_789'),
('Marta Isabel Flores', 'groomer', 'marta.flores@grooming.com', 'hash_password_101'),
('José Miguel Castillo', 'receptionist', 'jose.castillo@grooming.com', 'hash_password_202');

-- 3. Insertar Servicios de Grooming
INSERT INTO grooming_services (name, description, duration_min) VALUES
('Baño Completo', 'Baño con shampoo especial, secado y cepillado', 45),
('Corte de Pelo', 'Corte y arreglo de pelo según la raza', 60),
('Limpieza de Oídos', 'Limpieza profunda de oídos', 15),
('Corte de Uñas', 'Corte y limado de uñas', 20),
('Paquete Completo', 'Baño, corte, limpieza de oídos y uñas', 120);

-- 4. Insertar Mascotas (necesita los IDs de los clientes)
DECLARE @customer1 UNIQUEIDENTIFIER, @customer2 UNIQUEIDENTIFIER, @customer3 UNIQUEIDENTIFIER, @customer4 UNIQUEIDENTIFIER, @customer5 UNIQUEIDENTIFIER;

SELECT @customer1 = id FROM customers WHERE email = 'maria.gonzalez@email.com';
SELECT @customer2 = id FROM customers WHERE email = 'carlos.rodriguez@email.com';
SELECT @customer3 = id FROM customers WHERE email = 'ana.lopez@email.com';
SELECT @customer4 = id FROM customers WHERE email = 'roberto.martinez@email.com';
SELECT @customer5 = id FROM customers WHERE phone_number = '7234-1111';

INSERT INTO pets (customer_id, name, species, breed, birth_date, weight_kg, notes) VALUES
(@customer1, 'Max', 'Perro', 'Golden Retriever', '2022-03-15', 28.50, 'Muy tranquilo, le gusta el agua'),
(@customer1, 'Luna', 'Gato', 'Persa', '2021-08-22', 4.20, 'Tímida, cuidado con las uñas'),
(@customer2, 'Rocky', 'Perro', 'Bulldog Francés', '2020-12-10', 12.80, 'Respiración delicada'),
(@customer3, 'Bella', 'Perro', 'Poodle', '2023-01-05', 6.50, 'Muy activa y juguetona'),
(@customer4, 'Mimi', 'Gato', 'Siamés', '2022-07-18', 3.80, 'No le gusta el secador');

-- 5. Insertar Estilos de Corte por Raza
INSERT INTO breed_cut_styles (breed, name, description, image_url) VALUES
('Poodle', 'Corte Continental', 'Corte clásico con pompones en patas y cola', 'https://cdn.shopify.com/s/files/1/0528/3643/4106/files/jessie_480x480.jpg'),
('Golden Retriever', 'Corte Verano', 'Corte más corto para época de calor', 'https://i.pinimg.com/736x/20/ce/ba/20ceba141fc074e1b95990dbfbead085.jpg'),
('Schnauzer', 'Corte Tradicional', 'Mantenimiento del estilo característico de la raza', 'https://imgpetlife.s3.amazonaws.com/wp-content/uploads2/2025/05/13177.jpg'),
('Yorkshire', 'Corte Puppy', 'Corte juvenil y fácil de mantener', 'https://i.pinimg.com/736x/b3/45/8a/b3458a5af1e267f9664f13602e2c4e2a.jpg');

-- 6. Insertar Órdenes de Trabajo
DECLARE @pet1 UNIQUEIDENTIFIER, @pet2 UNIQUEIDENTIFIER, @pet3 UNIQUEIDENTIFIER;
DECLARE @receptionist1 UNIQUEIDENTIFIER, @groomer1 UNIQUEIDENTIFIER, @groomer2 UNIQUEIDENTIFIER;

SELECT @pet1 = id FROM pets WHERE name = 'Max';
SELECT @pet2 = id FROM pets WHERE name = 'Rocky';
SELECT @pet3 = id FROM pets WHERE name = 'Bella';

SELECT @receptionist1 = id FROM users WHERE email = 'laura.vasquez@grooming.com';
SELECT @groomer1 = id FROM users WHERE email = 'pedro.morales@grooming.com';
SELECT @groomer2 = id FROM users WHERE email = 'marta.flores@grooming.com';

INSERT INTO work_orders (pet_id, created_by_id, assigned_to_id, status, estimated_ready, comments) VALUES
(@pet1, @receptionist1, @groomer1, 'pending', DATEADD(hour, 3, GETDATE()), 'Cliente solicita corte no muy corto'),
(@pet2, @receptionist1, @groomer2, 'in_progress', DATEADD(hour, 2, GETDATE()), 'Cuidado con la respiración del perro'),
(@pet3, @receptionist1, @groomer1, 'completed', DATEADD(hour, -1, GETDATE()), 'Servicio completado satisfactoriamente');

-- 7. Insertar Servicios por Orden de Trabajo
DECLARE @order1 UNIQUEIDENTIFIER, @order2 UNIQUEIDENTIFIER, @order3 UNIQUEIDENTIFIER;

SELECT @order1 = id FROM work_orders WHERE pet_id = @pet1;
SELECT @order2 = id FROM work_orders WHERE pet_id = @pet2;
SELECT @order3 = id FROM work_orders WHERE pet_id = @pet3;

INSERT INTO work_order_services (work_order_id, service_id, order_index) VALUES
(@order1, 1, 1), -- Baño Completo
(@order1, 2, 2), -- Corte de Pelo
(@order2, 1, 1), -- Baño Completo
(@order2, 4, 2), -- Corte de Uñas
(@order3, 5, 1); -- Paquete Completo

-- 8. Insertar Notificaciones
INSERT INTO notifications (customer_id, type, message, sent_at, related_order) VALUES
(@customer1, 'WhatsApp', 'Su mascota Max está lista para recoger', DATEADD(minute, -30, GETDATE()), @order1),
(@customer2, 'sms', 'Rocky está siendo atendido, estará listo en 1 hora', DATEADD(minute, -15, GETDATE()), @order2),
(@customer3, 'email', 'Bella ha terminado su servicio de grooming', DATEADD(hour, -1, GETDATE()), @order3),
(@customer4, 'WhatsApp', 'Recordatorio: Mimi tiene cita mañana a las 10 AM', DATEADD(day, -1, GETDATE()), NULL);