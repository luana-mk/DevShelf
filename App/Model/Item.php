<?php
// models/Item.php

class Item {
    private $db;

    // Recebe a conexão PDO existente pelo construtor
    public function __construct($conexao) {
        $this->db = $conexao;
    }

    // [C]REATE - Inserir item
    public function criar($titulo, $descricao, $url, $tipo) {
        $sql = "INSERT INTO items (title, description, url, type) VALUES (:titulo, :descricao, :url, :tipo)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':titulo'    => htmlspecialchars(strip_tags($titulo)),
            ':descricao' => htmlspecialchars(strip_tags($descricao)),
            ':url'       => htmlspecialchars(strip_tags($url)),
            ':tipo'      => htmlspecialchars(strip_tags($tipo))
        ]);
    }

    // [R]EAD - Listar todos os itens
    public function listarTodos() {
        $sql = "SELECT * FROM items ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [R]EAD - Buscar um único item (para edição)
    public function buscarPorId($id) {
        $sql = "SELECT * FROM items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [U]PDATE - Atualizar item existente
    public function atualizar($id, $titulo, $descricao, $url, $tipo) {
        $sql = "UPDATE items SET title = :titulo, description = :descricao, url = :url, type = :tipo WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id'        => $id,
            ':titulo'    => htmlspecialchars(strip_tags($titulo)),
            ':descricao' => htmlspecialchars(strip_tags($descricao)),
            ':url'       => htmlspecialchars(strip_tags($url)),
            ':tipo'      => htmlspecialchars(strip_tags($tipo))
        ]);
    }

    // [D]ELETE - Excluir um item
    public function deletar($id) {
        $sql = "DELETE FROM items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>