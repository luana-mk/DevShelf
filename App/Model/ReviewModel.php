<?php
declare(strict_types=1);

class ReviewModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function salvar(int $item_id, int $usuario_id, int $nota, string $titulo, string $comentario): bool
    {
        $sql = "INSERT INTO reviews (item_id, usuario_id, nota, titulo, comentario, criado_em)
                VALUES (:item_id, :usuario_id, :nota, :titulo, :comentario, NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':nota', $nota, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindValue(':comentario', $comentario, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function buscarPorItem(int $item_id): array
    {
        $sql = "SELECT r.nota, r.titulo, r.comentario, r.criado_em, u.nome AS nome_usuario
                FROM reviews r
                INNER JOIN usuarios u ON u.id = r.usuario_id
                WHERE r.item_id = :item_id
                ORDER BY r.criado_em DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function usuarioJaAvaliou(int $item_id, int $usuario_id): bool
    {
        $sql = "SELECT COUNT(*) FROM reviews
                WHERE item_id = :item_id AND usuario_id = :usuario_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn() > 0;
    }
}
