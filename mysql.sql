CREATE DATABASE IF NOT EXISTS biblioteca_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca_db;

-- 1. Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. Categorias (Relacionamento 1:N com Livros)
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- 3. Autores
CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- 4. Livros (Entidade Principal)
CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    isbn VARCHAR(20) NOT NULL,
    categoria_id INT NOT NULL,
    status ENUM('disponivel', 'emprestado', 'manutencao') DEFAULT 'disponivel',
    imagem VARCHAR(255) DEFAULT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- 5. Tabela Intermediária N:N (livro_autor)
CREATE TABLE IF NOT EXISTS livro_autor (
    livro_id INT NOT NULL,
    autor_id INT NOT NULL,
    PRIMARY KEY (livro_id, autor_id),
    FOREIGN KEY (livro_id) REFERENCES livros(id) ON DELETE CASCADE,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE
);

-- Inserir dados padrão de teste
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@biblioteca.com', '$2y$10$e84.8J/s9G4Xk78/v5J8sO2R2P6mQ4N1b1xJ3n8U5y9/Z4G5m6K2e'); -- Senha: admin123

INSERT INTO categorias (nome) VALUES ('Ficção Científica'), ('Romance'), ('Tecnologia'), ('História');
INSERT INTO autores (nome) VALUES ('Machado de Assis'), ('George Orwell'), ('Martin Fowler'), ('Robert C. Martin');