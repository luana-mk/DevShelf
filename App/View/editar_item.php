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
    
    <form action="?p=editar-item&id=<?php echo $item['id']; ?>" method="POST">

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="campo">
            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($item['titulo']); ?>" required>
        </div>

        <div class="campo">
            <label>Categoria:</label>
            <select name="categoria" required>
                <option value="Livro" <?php echo $item['categoria'] == 'Livro' ? 'selected' : ''; ?>>Livro</option>
                <option value="Curso" <?php echo $item['categoria'] == 'Curso' ? 'selected' : ''; ?>>Curso</option>
                <option value="Ferramenta" <?php echo $item['categoria'] == 'Ferramenta' ? 'selected' : ''; ?>>Ferramenta</option>
                <option value="Periférico" <?php echo $item['categoria'] == 'Periférico' ? 'selected' : ''; ?>>Periférico</option>
                <option value="Setup" <?php echo $item['categoria'] == 'Setup' ? 'selected' : ''; ?>>Setup</option>
            </select>
        </div>

        <div class="campo">
            <label>Imagem (URL):</label>
            <input type="text" name="imagem" value="<?php echo htmlspecialchars($item['imagem'] ?? ''); ?>">
        </div>

        <div class="campo">
            <label>Descrição:</label>
            <textarea name="descricao" rows="5" required><?php echo htmlspecialchars($item['descricao']); ?></textarea>
        </div>

        <button type="submit">Salvar Alterações</button>
        <a href="?p=listar-itens" class="voltar">Anular e Voltar</a>
    </form>

</body>
</html>