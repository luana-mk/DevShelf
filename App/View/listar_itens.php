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
    <a href="index.php?action=cadastrar" class="btn">➕ Indicar Novo Item</a>

    <?php if (empty($items)): ?>
        <p>Nenhum item cadastrado ainda.</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                <span class="badge"><?php echo strtoupper(htmlspecialchars($item['type'])); ?></span>
                <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                
                <div class="acoes">
                    <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank" style="background:#28a745;">Acessar Link</a>
                    <a href="index.php?action=editar&id=<?php echo $item['id']; ?>" class="btn-edit">Editar</a>
                    <a href="index.php?action=excluir&id=<?php echo $item['id']; ?>" class="btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>sss