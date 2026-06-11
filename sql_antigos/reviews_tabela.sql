CREATE TABLE reviews (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    item_id     INT          NOT NULL,
    usuario_id  INT          NOT NULL,
    nota        TINYINT      NOT NULL CHECK (nota BETWEEN 1 AND 5),
    titulo      VARCHAR(150) NOT NULL,
    comentario  TEXT         NOT NULL,
    criado_em   DATETIME     NOT NULL DEFAULT NOW()
);
