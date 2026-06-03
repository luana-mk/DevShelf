<?php
require_once '../config/database.php';
session_start();

try {
    

    // Pega dados do form
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Hash para segurança

    // Insere no banco
    $stmt = $pdo->prepare("INSERT INTO usuario (email, senha, data_criacao) VALUES (?, ?, NOW())");
    $stmt->execute([$email, $senha]);

    // Mensagem de sucesso
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    header("Location: /DevShelf/index.php?p=cadastro-usuario");
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['mensagem'] = "Erro no cadastro: " . $e->getMessage();
    header("Location: /DevShelf/index.php?p=cadastro-usuario");
    exit();
}
?>
