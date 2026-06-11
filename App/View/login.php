
<form action="autenticar.php" method="post">
    <label for="email">E-mail:</label>
    <input type="email" name="email" required>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>
    <button type="submit">Entrar</button>
</form>

<?php
declare(strict_types=1);

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>

<div class="container-principal">
    <div class="form-review-container">

        <div class="cabecalho-secao">
            <h2>Entrar na sua conta</h2>
        </div>

        <?php if ($flash): ?>
            <p class="flash-msg"><?= htmlspecialchars($flash) ?></p>
        <?php endif; ?>

        <div class="card-item">
            <form method="POST" action="?p=login&acao=login">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="campo-form">
                    <label for="email" class="label-form">E-mail</label>
                    <input type="email" id="email" name="email" class="input-dark" placeholder="seu@email.com" required>
                </div>

                <div class="campo-form">
                    <label for="senha" class="label-form">Senha</label>
                    <input type="password" id="senha" name="senha" class="input-dark" placeholder="••••••••" required>
                </div>

                <div class="campo-form">
                    <label>
                        <input type="checkbox" name="lembrar" value="1">
                        Lembrar de mim
                    </label>
                </div>

                <button type="submit" class="btn-primario">Entrar</button>
            </form>

            <p>
                <a href="?p=recuperar" class="link-detalhes">Esqueci minha senha</a>
            </p>
            <p>
                Ainda não tem conta?
                <a href="?p=cadastro-usuario" class="link-detalhes">Cadastre-se</a>
            </p>
        </div>

    </div>
</div>

