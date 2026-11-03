CREATE DATABASE usuario;

USE usuario;

CREATE TABLE usuarios(
    id int AUTO_INCREMENT PRIMARY KEY,
    nome varchar(100),
    email  varchar(100),
    senha VARCHAR(255)
    
);
