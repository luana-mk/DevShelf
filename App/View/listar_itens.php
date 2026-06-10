<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Compartilha Ferramentas</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; background: #f9f9f9; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .btn-danger { background: #dc3545; }
        .btn-edit { background: #ffc107; color: black; }
        .card { background: white; border: 1px solid #ddd; padding: 20px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .badge { background: #e0e0e0; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .acoes { margin-top: 15px; display: flex; gap: 10px; }
        .acoes a { padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; color: white; }
    </style>
</head>
<body>

    <h1>Repositório de Ferramentas e Livros</h1>
    <a href="?p=criar-item" class="btn">➕ Indicar Novo Item</a>

    <?php if (empty($items)): ?>
        <p>Nenhum item cadastrado ainda.</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($item['titulo']); ?></h2>
                <span class="badge"><?php echo strtoupper(htmlspecialchars($item['categoria'])); ?></span>
                <p><?php echo nl2br(htmlspecialchars($item['descricao'])); ?></p>
    
                <div class="acoes">
                    <a href="?p=editar-item&id=<?php echo $item['id']; ?>" class="btn-edit">Editar</a>

                    <form action="?p=excluir-item" method="POST" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>