<?php
require_once '../config/database.php';
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Se não passar o ID, redireciona de volta
    header("Location: listar_usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="processa_edicao.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required><br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required><br>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>