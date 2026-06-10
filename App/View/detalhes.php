<?php
require_once __DIR__ . '/../Controller/ReviewController.php';

$reviewController = new ReviewController($pdo);

$item_id = (int) ($_GET['id'] ?? 0);
$reviews = $reviewController->listarPorItem($item_id);

$sucesso = isset($_GET['sucesso']);
$erro = $_GET['erro'] ?? '';
?>

<main class="container-principal">
    
    <section class="item-hero card-item">
        <div class="item-header-info">
            <span class="tag-categoria cat-hard">Setup & Periféricos</span>
            <h2>Teclado Mecânico Keychron K2</h2>
            <p class="marca">Keychron</p>
        </div>
        
        <div class="item-estatisticas">
            <div class="nota-geral">
                <span class="nota-numero">4.8</span>
                <div class="estrelas">★★★★★</div>
                <span class="total-reviews">(<?= count($reviews) ?> avaliações)</span>
            </div>

            <?php if (isset($_SESSION['usuario_logado'])): ?>
                <a href="?p=escrever-review&id=<?= $item_id ?>" class="btn-neon">Deixar minha Avaliação</a>
            <?php else: ?>
                <a href="?p=login" class="btn-neon">Faça login para avaliar</a>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($sucesso): ?>
        <p class="mensagem-sucesso" style="color: #7af1a0; padding: 1rem;">✔ Avaliação publicada com sucesso!</p>
    <?php endif; ?>

    <?php if ($erro === 'duplicada'): ?>
        <p class="mensagem-erro" style="color: #f16769; padding: 1rem;">Você já avaliou este item.</p>
    <?php endif; ?>

    <section class="feed-reviews">
        <div class="cabecalho-secao">
            <h2>Comentários da <span>Comunidade</span></h2>
        </div>

        <div class="lista-comentarios">
                      
            <?php if (empty($reviews)): ?>
                <p style="color: var(--cor-texto-secundario);">Nenhuma avaliação ainda. Seja o primeiro!</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <article class="review-card">
                        <div class="review-header">
                            <div class="usuario-info">
                                <div class="avatar-placeholder">
                                    <?= htmlspecialchars(mb_strtoupper(mb_substr($review['nome_usuario'], 0, 1))) ?>
                                </div>
                                <div>
                                    <p class="nome-usuario"><?= htmlspecialchars($review['nome_usuario']) ?></p>
                                    <p class="data-postagem">
                                        Postado em <?= date('d/m/Y', strtotime($review['criado_em'])) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="estrelas">
                                <?= str_repeat('★', (int) $review['nota']) . str_repeat('☆', 5 - (int) $review['nota']) ?>
                            </div>
                        </div>
                        
                        <h4 class="review-titulo"><?= htmlspecialchars($review['titulo']) ?></h4>
                        <p class="review-texto"><?= htmlspecialchars($review['comentario']) ?></p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </section>

</main>