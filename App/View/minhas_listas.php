<?php
$mensagem = $_GET['sucesso'] ?? '';
$erro = $_GET['erro'] ?? '';
$listas = $colecoes ?? [];
$itensDisponiveis = $itensDisponiveis ?? [];
?>

<main class="container-principal">
    <section class="cabecalho-secao">
        <h2>📚 Minhas Listas de Estudo</h2>
        <p class="texto-secundario">Organize seus itens favoritos em coleções personalizadas.</p>
    </section>

    <?php if ($mensagem === '1'): ?>
        <p class="mensagem-sucesso">Ação realizada com sucesso.</p>
    <?php elseif ($mensagem === 'removido'): ?>
        <p class="mensagem-sucesso">Item removido da coleção.</p>
    <?php elseif ($mensagem === 'removida'): ?>
        <p class="mensagem-sucesso">Coleção removida com sucesso.</p>
    <?php endif; ?>

    <?php if ($erro === 'nome'): ?>
        <p class="mensagem-erro">Informe um nome para a coleção.</p>
    <?php endif; ?>

    <div class="grid-duplo">
        <section class="card-item">
            <h3>Criar nova coleção</h3>

            <form action="?p=criar-colecao" method="POST" class="form-colecao">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <label>
                    <span>Nome da coleção</span>
                    <input class="input-dark" type="text" name="nome" required>
                </label>

                <label>
                    <span>Descrição</span>
                    <textarea class="input-dark" name="descricao" rows="3"></textarea>
                </label>

                <button type="submit" class="btn-neon">Criar coleção</button>
            </form>
        </section>

        <section class="card-item">
            <h3>Itens disponíveis</h3>

            <div class="lista-simples">
                <?php foreach ($itensDisponiveis as $item): ?>
                    <article class="item-mini">
                        <div>
                            <strong><?= htmlspecialchars($item['titulo']) ?></strong>
                            <small><?= htmlspecialchars($item['categoria']) ?></small>
                        </div>

                        <form action="?p=adicionar-item-colecao" method="POST" class="inline-form">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="item_id" value="<?= (int) $item['id'] ?>">

                            <select name="colecao_id" class="input-dark select-pequeno" required>
                                <option value="">Escolha a coleção</option>
                                <?php foreach ($listas as $lista): ?>
                                    <option value="<?= (int) $lista['id'] ?>">
                                        <?= htmlspecialchars($lista['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn-neon pequeno">Adicionar</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <section class="cabecalho-secao" style="margin-top: 32px;">
        <h3>Suas coleções</h3>
    </section>

    <?php if (empty($listas)): ?>
        <p class="texto-secundario">Você ainda não criou nenhuma coleção.</p>
    <?php else: ?>
        <div class="grid-catalogo">
            <?php foreach ($listas as $lista): ?>

                <article class="card-item colecao-card">
                    <span class="tag-categoria cat-book">Coleção</span>

                    <h3 class="card-titulo"><?= htmlspecialchars($lista['nome']) ?></h3>

                    <p class="card-resumo">
                        <?= htmlspecialchars($lista['descricao'] !== '' ? $lista['descricao'] : 'Lista personalizada.') ?>
                    </p>

                    <p class="texto-secundario">
                        Itens salvos: <?= (int) $lista['total_itens'] ?>
                    </p>

                    <?php if (!empty($lista['itens'])): ?>
                        <ul class="lista-itens-colecao">
                            <?php foreach ($lista['itens'] as $item): ?>
                                <li>
                                    <strong><?= htmlspecialchars($item['titulo']) ?></strong>
                                    <small><?= htmlspecialchars($item['categoria']) ?></small>

                                    <a href="?p=detalhes&id=<?= (int) $item['id'] ?>">
                                        Ver item
                                    </a>

                                    <form action="?p=remover-item-colecao" method="POST" class="inline-form">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                        <input type="hidden" name="colecao_id" value="<?= (int) $lista['id'] ?>">
                                        <input type="hidden" name="item_id" value="<?= (int) $item['id'] ?>">

                                        <button type="submit" class="btn-link">Remover</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <form action="?p=remover-colecao" method="POST" class="inline-form form-remover-colecao">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <input type="hidden" name="colecao_id" value="<?= (int) $lista['id'] ?>">

                        <button type="submit" class="btn-neon pequeno btn-danger"
                                onclick="return confirm('Deseja excluir esta lista?')">
                            Excluir coleção
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>