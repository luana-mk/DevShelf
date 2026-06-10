<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Indicação</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 500px; margin: 40px auto; padding: 20px; }
        .campo { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #ffc107; color: black; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .voltar { display: block; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <h1>Editar Indicação</h1>
    
    <form action="index.php?action=editar&id=<?php echo $item['id']; ?>" method="POST">
        <div class="campo">
            <label>Título:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>
        </div>

        <div class="campo">
            <label>Tipo:</label>
            <select name="type" required>
                <option value="livro" <?php echo $item['type'] == 'livro' ? 'selected' : ''; ?>>Livro</option>
                <option value="curso" <?php echo $item['type'] == 'curso' ? 'selected' : ''; ?>>Curso</option>
                <option value="ferramenta" <?php echo $item['type'] == 'ferramenta' ? 'selected' : ''; ?>>Ferramenta</option>
            </select>
        </div>

        <div class="campo">
            <label>URL / Link de Acesso:</label>
            <input type="url" name="url" value="<?php echo htmlspecialchars($item['url']); ?>" required>
        </div>

        <div class="campo">
            <label>Descrição:</label>
            <textarea name="description" rows="5" required><?php echo htmlspecialchars($item['description']); ?></textarea>
        </div>

        <button type="submit">Salvar Alterações</button>
        <a href="index.php" class="voltar">Anular e Voltar</a>
    </form>

</body>
</html>