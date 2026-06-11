<?php
require_once '../config/database.php';
session_start();

// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        

        // Prepara e executa o DELETE
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

        // Redireciona após o sucesso
        header("Location: listar_usuarios.php");
        exit();
    } catch (Exception $e) {
        // Em caso de erro, exibe uma mensagem
        echo "Erro ao deletar: " . $e->getMessage();
    }
} else {
    // Se não passar o ID, volta para a listagem ou página inicial
    header("Location: listar_usuarios.php");
    exit();
}
?>