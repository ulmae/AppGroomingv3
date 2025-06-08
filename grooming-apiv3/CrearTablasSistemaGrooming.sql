CREATE DATABASE sistema_grooming;
GO
USE sistema_grooming;
GO

CREATE TABLE customers (
    id UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    full_name NVARCHAR(255) NOT NULL,
    phone_number NVARCHAR(20) NOT NULL,
    email NVARCHAR(255) NULL UNIQUE,
    created_at DATETIME2 DEFAULT GETDATE()
);

CREATE TABLE pets (
    id UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    customer_id UNIQUEIDENTIFIER NOT NULL,
    name NVARCHAR(100) NOT NULL,
    species NVARCHAR(50) NULL,
    breed NVARCHAR(100) NULL,
    birth_date DATE NULL,
    weight_kg DECIMAL(5,2) NULL,
    notes NTEXT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

CREATE TABLE grooming_services (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name NVARCHAR(100) UNIQUE NOT NULL,
    description NTEXT NULL,
    duration_min INT NULL
);

CREATE TABLE users (
    id UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    full_name NVARCHAR(255) NOT NULL,
    role NVARCHAR(20) NOT NULL CHECK (role IN ('receptionist', 'groomer', 'admin')),
    email NVARCHAR(255) UNIQUE NOT NULL,
    password_hash NVARCHAR(255) NOT NULL,
    active BIT DEFAULT 1
);

CREATE TABLE work_orders (
    id UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    pet_id UNIQUEIDENTIFIER NOT NULL,
    created_by_id UNIQUEIDENTIFIER NOT NULL,
    assigned_to_id UNIQUEIDENTIFIER NOT NULL,
    status NVARCHAR(20) NOT NULL CHECK (status IN ('pending', 'in_progress', 'completed', 'cancelled')),
    estimated_ready DATETIME2 NULL,
    ready_at DATETIME2 NULL,
    customer_notified BIT DEFAULT 0,
    comments NTEXT NULL,
    created_at DATETIME2 DEFAULT GETDATE(),
    FOREIGN KEY (pet_id) REFERENCES pets(id),
    FOREIGN KEY (created_by_id) REFERENCES users(id),
    FOREIGN KEY (assigned_to_id) REFERENCES users(id)
);

CREATE TABLE work_order_services (
    id INT IDENTITY(1,1) PRIMARY KEY,
    work_order_id UNIQUEIDENTIFIER NOT NULL,
    service_id INT NOT NULL,
    order_index INT NULL,
    FOREIGN KEY (work_order_id) REFERENCES work_orders(id),
    FOREIGN KEY (service_id) REFERENCES grooming_services(id)
);

CREATE TABLE breed_cut_styles (
    id INT IDENTITY(1,1) PRIMARY KEY,
    breed NVARCHAR(100) NOT NULL,
    name NVARCHAR(100) NULL,
    description NTEXT NULL,
    image_url NVARCHAR(500) NULL
);

CREATE TABLE notifications (
    id UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    customer_id UNIQUEIDENTIFIER NOT NULL,
    type NVARCHAR(20) NOT NULL CHECK (type IN ('sms', 'email', 'WhatsApp')),
    message NTEXT NULL,
    sent_at DATETIME2 NULL,
    related_order UNIQUEIDENTIFIER NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (related_order) REFERENCES work_orders(id)
);