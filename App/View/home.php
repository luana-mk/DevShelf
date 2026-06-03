<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
</head>
<body>
    <h1>Bem-vindo ao DevForge Reviews</h1>
    <?php if (isset($user)): ?>
        <p>Olá, <?= $user['nome']; ?>!</p>
        <p>Seu e-mail: <?= $user['email']; ?></p>
    <?php else: ?>
        <p>Nenhum usuário encontrado.</p>
    <?php endif; ?>
</body>
</html>