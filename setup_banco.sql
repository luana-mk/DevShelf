-- Script completo para criar o banco e as tabelas necessárias do DevShelf
-- Execute este arquivo no MySQL/MariaDB para preparar o ambiente.

CREATE DATABASE IF NOT EXISTS devshelf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE devshelf;

-- Tabela de usuários (necessária para login, reviews e coleções)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NULL,
    data_nascimento DATE NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de itens/catálogo (livros, ferramentas, cursos, setups etc.)
CREATE TABLE IF NOT EXISTS itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    descricao TEXT NULL,
    imagem VARCHAR(255) NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela principal das coleções/favoritos do usuário
CREATE TABLE IF NOT EXISTS colecoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_colecoes_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Relação entre coleções e itens adicionados a elas
CREATE TABLE IF NOT EXISTS colecao_itens (
    colecao_id INT NOT NULL,
    item_id INT NOT NULL,
    adicionado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (colecao_id, item_id),
    CONSTRAINT fk_colecao_itens_colecao
        FOREIGN KEY (colecao_id) REFERENCES colecoes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_colecao_itens_item
        FOREIGN KEY (item_id) REFERENCES itens(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de avaliações/reviews dos itens
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    usuario_id INT NOT NULL,
    nota TINYINT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    comentario TEXT NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_reviews_nota CHECK (nota BETWEEN 1 AND 5),
    CONSTRAINT fk_reviews_item
        FOREIGN KEY (item_id) REFERENCES itens(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_reviews_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Índices auxiliares para consultas mais rápidas
CREATE INDEX idx_colecoes_usuario ON colecoes(usuario_id);
CREATE INDEX idx_colecao_itens_item ON colecao_itens(item_id);
CREATE INDEX idx_reviews_item ON reviews(item_id);
CREATE INDEX idx_reviews_usuario ON reviews(usuario_id);
