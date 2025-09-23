-- Crear base de datos 
CREATE DATABASE IF NOT EXISTS mano_amiga CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER IF NOT EXISTS 'mano_admin'@'localhost' IDENTIFIED BY 'MiClave123*'; 
GRANT ALL PRIVILEGES ON mano_amiga.* TO 'mano_admin'@'localhost';
 
USE mano_amiga;

CREATE TABLE siniestros ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    location VARCHAR(255) NOT NULL, 
    level INT NOT NULL, 
    date_time TIMESTAMP NOT NULL, 
    resources VARCHAR(255) NOT NULL, 
    active BOOLEAN NOT NULL DEFAULT TRUE 
) ENGINE=InnoDB;

CREATE TABLE usuarios ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    full_name VARCHAR(255) NOT NULL, 
    username VARCHAR(255) NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    is_admin BOOLEAN NOT NULL DEFAULT FALSE, 
    siniestro_id INT DEFAULT NULL,
    FOREIGN KEY (siniestro_id) REFERENCES siniestros(id) 
) ENGINE=InnoDB;

CREATE TABLE recursos ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(255) NOT NULL, 
    description VARCHAR(255), 
    category VARCHAR(255) NOT NULL, 
    quantity INT NOT NULL, 
    usuario_id INT, 
    siniestro_id INT, 
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id), 
    FOREIGN KEY (siniestro_id) REFERENCES siniestros(id) 
) ENGINE=InnoDB;