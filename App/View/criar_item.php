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
    
    <form action="?p=criar-item" method="POST">

    <input type="hidden" name="csrf_token"
           value="<?= $_SESSION['csrf_token'] ?>">

    <div class="campo">
        <label>Título:</label>
        <input type="text" name="titulo" required>
    </div>

    <div class="campo">
        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="Livro">Livro</option>
            <option value="Curso">Curso</option>
            <option value="Ferramenta">Ferramenta</option>
            <option value="Periférico">Periférico</option>
            <option value="Setup">Setup</option>
        </select>
    </div>

    <div class="campo">
        <label>Imagem (URL):</label>
        <input type="text" name="imagem">
    </div>

    <div class="campo">
        <label>Descrição:</label>
        <textarea name="descricao" rows="5" required></textarea>
    </div>

    <button type="submit">Salvar Indicação</button>

    <a href="?p=listar-itens" class="voltar">
        ⬅ Voltar
    </a>

</form>

</body>
</html>