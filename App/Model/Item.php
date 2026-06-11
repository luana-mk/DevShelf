<?php

class Item {
    private PDO $db;

    public function __construct(PDO $conexao) {
        $this->db = $conexao;
    }

    public function criar($titulo, $categoria, $descricao, $imagem): bool {
        $sql = "INSERT INTO itens (titulo, categoria, descricao, imagem)
                VALUES (:titulo, :categoria, :descricao, :imagem)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':titulo' => htmlspecialchars(strip_tags($titulo)),
            ':categoria' => htmlspecialchars(strip_tags($categoria)),
            ':descricao' => htmlspecialchars(strip_tags($descricao)),
            ':imagem' => htmlspecialchars(strip_tags($imagem))
        ]);
    }

    public function listarTodos(): array {
        $sql = "SELECT * FROM itens ORDER BY criado_em DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id): array|false {
        $sql = "SELECT * FROM itens WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $titulo, $categoria, $descricao, $imagem): bool {
        $sql = "UPDATE itens
                SET titulo = :titulo,
                    categoria = :categoria,
                    descricao = :descricao,
                    imagem = :imagem
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':titulo' => htmlspecialchars(strip_tags($titulo)),
            ':categoria' => htmlspecialchars(strip_tags($categoria)),
            ':descricao' => htmlspecialchars(strip_tags($descricao)),
            ':imagem' => htmlspecialchars(strip_tags($imagem))
        ]);
    }

    public function deletar($id): bool {
        $sql = "DELETE FROM itens WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}