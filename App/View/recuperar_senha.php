<?php
declare(strict_types=1);

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$etapa = $_GET['etapa'] ?? 'validar';
if ($etapa === 'nova-senha' && empty($_SESSION['recuperar_id'])) {
    $etapa = 'validar';
}
?>

<div class="container-principal">
    <div class="form-review-container">

        <div class="cabecalho-secao">
            <h2> <?= $etapa === 'nova-senha' ? 'Nova senha' : 'Recuperar senha' ?></h2>
        </div>

        <?php if ($flash): ?>
            <p class="flash-msg"><?= htmlspecialchars($flash) ?></p>
        <?php endif; ?>

        <div class="card-item">

            <?php if ($etapa === 'validar'): ?>

                <p>Informe seu CPF e data de nascimento cadastrados para redefinir sua senha.</p>

                <form method="POST" action="?p=recuperar&acao=recuperar-senha">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="etapa" value="validar">

                    <div class="campo-form">
                        <label for="cpf" class="label-form">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="input-dark" placeholder="00000000000" maxlength="11" required>
                    </div>

                    <div class="campo-form">
                        <label for="data_nasc" class="label-form">Data de nascimento</label>
                        <input type="date" id="data_nasc" name="data_nasc" class="input-dark" required>
                    </div>

                    <button type="submit" class="btn-primario">Verificar</button>
                </form>

            <?php else: ?>

                <p>Identidade confirmada! Agora defina sua nova senha.</p>

                <form method="POST" action="?p=recuperar&acao=recuperar-senha">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="etapa" value="nova-senha">

                    <div class="campo-form">
                        <label for="senha" class="label-form">Nova senha</label>
                        <input type="password" id="senha" name="senha" class="input-dark" placeholder="Mínimo 8 caracteres" required>
                    </div>

                    <div class="campo-form">
                        <label for="confirmar" class="label-form">Confirmar nova senha</label>
                        <input type="password" id="confirmar" name="confirmar" class="input-dark" placeholder="Repita a senha" required>
                    </div>

                    <button type="submit" class="btn-primario">Salvar nova senha</button>
                </form>

            <?php endif; ?>

            <p>
                Lembrou a senha?
                <a href="?p=login" class="link-detalhes">Entrar</a>
            </p>
        </div>

    </div>
</div>