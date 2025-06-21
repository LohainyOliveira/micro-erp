-- database/estrutura.sql

DROP DATABASE micro_erp;
CREATE DATABASE IF NOT EXISTS  micro_erp ;

USE micro_erp;

CREATE TABLE Produtos (
    id_prod INT AUTO_INCREMENT PRIMARY KEY,
    nome_prod VARCHAR(150) NOT NULL,
    descricao_prod TEXT,
    preco_prod double NOT NULL,
    qtd_prod INT NOT NULL DEFAULT 0,
    data_cadastro_prod TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Clientes (
    id_cli INT AUTO_INCREMENT PRIMARY KEY,
    nome_cli VARCHAR(150) NOT NULL,
    cpf_cnpj_cli VARCHAR(20),
    endereco_cli VARCHAR(255),
    email_cli VARCHAR(150),
    telefone_cli VARCHAR(30),
    data_cadastro_cli TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notas_fiscais (
    id_nfe INT AUTO_INCREMENT PRIMARY KEY,
    id_cli_fk INT NOT NULL,
    numero_nfe VARCHAR(20) NOT NULL,
    serie_nfe VARCHAR(10) NOT NULL,
    data_emissao_nfe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    chave_acesso_nfe VARCHAR(44),
    protocolo_autorizacao_nfe VARCHAR(100),
    status_nfe VARCHAR(20), -- ex: 'Emissão', 'Autorizada', 'Rejeitada'
    total_nfe DECIMAL(12,2) NOT NULL,
    forma_pagamento_nfe VARCHAR(50),
    observacoes_nfe TEXT,
    FOREIGN KEY (id_cli_fk) REFERENCES clientes(id_cli)
);

CREATE TABLE itens_nota (
    id_iten INT AUTO_INCREMENT PRIMARY KEY,
    id_nfe_fk INT NOT NULL,
    id_prod_fk INT NOT NULL,
    qtd_iten INT NOT NULL,
    preco_unitario_iten DECIMAL(10,2) NOT NULL,
    subtotal_iten DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_nfe_fk) REFERENCES notas_fiscais(id_nfe) ON DELETE CASCADE,
    FOREIGN KEY (id_prod_fk) REFERENCES produtos(id_prod)
);

CREATE TABLE usuarios (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nome_user VARCHAR(150) NOT NULL,
    email_user VARCHAR(150) UNIQUE NOT NULL,
    senha_user VARCHAR(255) NOT NULL,
    tipo_user ENUM('Cliente','Administrados') NOT NULL,
    data_cadastro_user TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome_user, email_user, senha_user, tipo_user)
VALUES ('Lohainy Oliveira', 'lohainyOliveira@gmail.com', MD5('admin123'), 'Cliente');

INSERT INTO clientes (nome_cli, cpf_cnpj_cli, endereco_cli, email_cli, telefone_cli)
VALUES 
('Amanda Souza', '123.456.789-00', 'Rua das Flores, 100', 'amanda@gmail.com', '(69) 99999-1111'),
('Felipe Rocha', '987.654.321-00', 'Av. Brasil, 456', 'felipe.rocha@email.com', '(69) 98888-2222'),
('Matheus Siebert', '321.654.987-00', 'Rua Dom Bosco, 789', 'matheus.siebert@outlook.com', '(69) 97777-3333'),
('Emilly Meneses', '456.789.123-00', 'Rua Primavera, 321', 'emilly.meneses@gmail.com', '(69) 96666-4444'),
('Carlos Silva', '159.753.486-00', 'Rua Amazonas, 654', 'carlos.silva@hotmail.com', '(69) 95555-5555');

INSERT INTO produtos (nome_prod, descricao_prod, preco_prod, qtd_prod)
VALUES 
('Camiseta Infantil', 'Camiseta 100% algodão com estampa divertida', 39.90, 20),
('Conjunto Body e Shorts', 'Ideal para recém-nascidos. Tecido macio e confortável.', 59.90, 15),
('Macacão Prematuro', 'Roupinha especial para bebês prematuros.', 45.00, 10),
('Vestido Floral', 'Vestido de algodão com estampa floral delicada.', 79.90, 12),
('Calça Jeans Baby', 'Calça jeans com elástico na cintura.', 49.90, 8),
('Touca de Lã', 'Touca de lã com pompom colorido.', 25.00, 30),
('Meias Antiderrapantes', 'Pacote com 3 pares de meias para bebê.', 15.00, 40),
('Jaqueta Inverno', 'Jaqueta infantil para dias frios, forrada por dentro.', 89.90, 5);
SELECT * FROM notas_fiscais;
ALTER TABLE notas_fiscais ADD COLUMN xml TEXT;
SHOW COLUMNS FROM notas_fiscais LIKE 'xml';
