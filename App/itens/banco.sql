CREATE database itens;

CREATE TABLE itens(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    url VARCHAR(200) NOT NULL, -- link de onde comprar
    tipo VARCHAR(100) NOT NULL,-- livro, curso, ferramenta...
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)