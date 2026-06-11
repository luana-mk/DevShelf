<?php

declare(strict_types=1);

class ColecaoModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(string $nome, string $descricao, int $usuario_id): int
    {
        $sql = 'INSERT INTO colecoes (usuario_id, nome, descricao, criado_em) VALUES (:usuario_id, :nome, :descricao, NOW())';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function listarPorUsuario(int $usuario_id): array
    {
        $sql = 'SELECT c.id, c.nome, c.descricao, c.criado_em,
                       COUNT(ci.item_id) AS total_itens
                FROM colecoes c
                LEFT JOIN colecao_itens ci ON ci.colecao_id = c.id
                WHERE c.usuario_id = :usuario_id
                GROUP BY c.id
                ORDER BY c.criado_em DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarItensDaColecao(int $colecao_id): array
    {
        $sql = 'SELECT 
                i.id,
                i.titulo,
                i.categoria,
                i.descricao,
                ci.adicionado_em
            FROM colecao_itens ci
            INNER JOIN itens i ON i.id = ci.item_id
            WHERE ci.colecao_id = :colecao_id
            ORDER BY ci.adicionado_em DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':colecao_id', $colecao_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionarItem(int $colecao_id, int $item_id): bool
    {
        $sql = 'INSERT INTO colecao_itens (colecao_id, item_id, adicionado_em)
                VALUES (:colecao_id, :item_id, NOW())
                ON DUPLICATE KEY UPDATE item_id = item_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':colecao_id', $colecao_id, PDO::PARAM_INT);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function removerItem(int $colecao_id, int $item_id): bool
    {
        $sql = 'DELETE FROM colecao_itens WHERE colecao_id = :colecao_id AND item_id = :item_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':colecao_id', $colecao_id, PDO::PARAM_INT);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function removerColecao(int $colecao_id, int $usuario_id): bool
    {
        $sql = 'DELETE FROM colecao_itens WHERE colecao_id = :colecao_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':colecao_id', $colecao_id, PDO::PARAM_INT);
        $stmt->execute();

        $sql = 'DELETE FROM colecoes WHERE id = :colecao_id AND usuario_id = :usuario_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':colecao_id', $colecao_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
