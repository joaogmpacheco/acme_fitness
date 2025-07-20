-- Criação do banco de dados (opcional)
CREATE DATABASE acme_fitness;
USE acme_fitness;

-- Tabela de Categorias
CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- Tabela de Produtos
CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(50),
    imagem TEXT,
    preco_base DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    data_cadastro DATE NOT NULL,
    peso DECIMAL(10,2),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

-- Tabela de Variações de Produto (ex: tamanhos diferentes)
CREATE TABLE variacao_produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    estoque INT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produto(id)
);

-- Tabela de Clientes
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL
);

-- Tabela de Endereços
CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logradouro VARCHAR(150) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    cep CHAR(8) NOT NULL,
    complemento VARCHAR(100),
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);

-- Tabela de Vendas
CREATE TABLE venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    endereco_id INT NOT NULL,
    valor_frete DECIMAL(10,2) NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) DEFAULT 0.00,
    forma_pagamento ENUM('PIX', 'Boleto', 'Cartao') NOT NULL,
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
);

-- Tabela de Itens da Venda (variações vendidas)
CREATE TABLE item_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    variacao_id INT NOT NULL,
    preco_venda DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES venda(id),
    FOREIGN KEY (variacao_id) REFERENCES variacao_produto(id)
);

-- Tabela de Configuração do Sistema (frete fixo, por exemplo)
CREATE TABLE configuracao_sistema (
    id INT PRIMARY KEY,
    valor_frete_padrao DECIMAL(10,2) NOT NULL
);

-- Inserir valor de frete inicial
INSERT INTO configuracao_sistema (id, valor_frete_padrao) VALUES (1, 10.00);
