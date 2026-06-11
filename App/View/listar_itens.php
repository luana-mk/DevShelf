<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Compartilha Ferramentas</title>

</head>
<body>

    <h1>Repositório de Ferramentas e Livros</h1>
    <a href="?p=criar-item" class="btn">➕ Indicar Novo Item</a>

    <?php if (empty($items)): ?>
        <p>Nenhum item cadastrado ainda.</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="card-item">
                <h3 class="card-titulo"><?php echo htmlspecialchars($item['titulo']); ?></h3>
                <span class="tag-categoria"><?php echo strtoupper(htmlspecialchars($item['categoria'])); ?></span>
                <p class="card-resumo"><?php echo nl2br(htmlspecialchars($item['descricao'])); ?></p>
    
                <div class="acoes">
                    <a href="?p=detalhes&id=<?php echo $item['id']; ?>" class="btn">
                        Ver Detalhes
                    </a>
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