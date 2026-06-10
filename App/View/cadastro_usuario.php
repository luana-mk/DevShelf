<?php
declare(strict_types=1);

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>

<div class="container-principal">
    <div class="form-review-container">

        <div class="cabecalho-secao">
            <h2>Criar uma conta</h2>
        </div>

        <?php if ($flash): ?>
            <p class="flash-msg"><?= htmlspecialchars($flash) ?></p>
        <?php endif; ?>

        <div class="card-item">
            <form method="POST" action="?p=cadastro-usuario&acao=cadastrar">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="campo-form">
                    <label for="nome" class="label-form">Nome completo</label>
                    <input type="text" id="nome" name="nome" class="input-dark" placeholder="Seu nome" required>
                </div>

                <div class="campo-form">
                    <label for="email" class="label-form">E-mail</label>
                    <input type="email" id="email" name="email" class="input-dark" placeholder="seu@email.com" required>
                </div>

                <div class="campo-form">
                    <label for="cpf" class="label-form">CPF</label>
                    <input type="text" id="cpf" name="cpf" class="input-dark" placeholder="00000000000" maxlength="11" required>
                </div>

                <div class="campo-form">
                    <label for="data_nasc" class="label-form">Data de nascimento</label>
                    <input type="date" id="data_nasc" name="data_nasc" class="input-dark" required>
                </div>

                <div class="campo-form">
                    <label for="senha" class="label-form">Senha</label>
                    <input type="password" id="senha" name="senha" class="input-dark" placeholder="Mínimo 8 caracteres" required>
                </div>

                <div class="campo-form">
                    <label for="confirmar" class="label-form">Confirmar senha</label>
                    <input type="password" id="confirmar" name="confirmar" class="input-dark" placeholder="Repita a senha" required>
                </div>

                <button type="submit" class="btn-primario">Criar conta</button>
            </form>

            <p>
                Já tem uma conta?
                <a href="?p=login" class="link-detalhes">Entrar</a>
            </p>
        </div>

    </div>
</div>