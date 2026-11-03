CREATE DATABASE loja_db;

USE loja_db;

CREATE TABLE produtos(
    id_produto int AUTO_INCREMENT PRIMARY KEY,
    nome_produto varchar(100),
    valor_produto decimal(5,2),
    descricao text
    );

CREATE TABLE imagens(
    id_imagens int AUTO_INCREMENT PRIMARY KEY,
    nome_imagem varchar(100),
    fk_id_produto int,
    FOREIGN KEY (fk_id_produto) references produto(id_produto)
);
