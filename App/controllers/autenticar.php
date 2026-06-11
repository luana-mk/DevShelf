<?php
require_once '../config/database.php';
session_start();

// Conecta no banco via PDO


// Pega os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta no banco
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
$stmt->execute([$email, $senha]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Se encontrou, inicia a sessão
    $_SESSION['user_id'] = $user['id'];
    header('Location: /area-protegida.php'); // ou outra rota que você queira
    exit();
} else {
    // Se não encontrou, volta com erro
    echo "E-mail ou senha inválidos!";
}