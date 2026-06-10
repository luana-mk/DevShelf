<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Indicação</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 500px; margin: 40px auto; padding: 20px; }
        .campo { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .voltar { display: block; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <h1>Indicar Livro ou Ferramenta</h1>
    
    <form action="index.php?action=cadastrar" method="POST">
        <div class="campo">
            <label>Título:</label>
            <input type="text" name="title" required>
        </div>

        <div class="campo">
            <label>Tipo:</label>
            <select name="type" required>
                <option value="livro">Livro</option>
                <option value="curso">Curso</option>
                <option value="ferramenta">Ferramenta</option>
            </select>
        </div>

        <div class="campo">
            <label>URL / Link de Acesso:</label>
            <input type="url" name="url" placeholder="https://" required>
        </div>

        <div class="campo">
            <label>Descrição:</label>
            <textarea name="description" rows="5" required></textarea>
        </div>

        <button type="submit">Salvar Indicação</button>
        <a href="index.php" class="voltar">⬅ Voltar</a>
    </form>

</body>
</html>