
<?php session_start(); ?>
<form action="/DevShelf/App/controllers/processa_cadastro.php" method="POST">
    <label for="email">E-mail:</label>
    <input type="email" name="email" required><br>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" required><br>
    <button type="submit">Cadastrar</button>
</form>

<?php
if (isset($_SESSION['mensagem'])) {
    echo "<p>" . htmlspecialchars($_SESSION['mensagem']) . "</p>";
    unset($_SESSION['mensagem']); // Limpa a mensagem após exibir
}