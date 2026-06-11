<main class="container-principal">
    
    <section class="item-hero card-item">
        <div class="item-header-info">
            <span class="tag-categoria cat-hard">
                <?php echo htmlspecialchars($item['categoria']); ?>
            </span>

            <h2><?php echo htmlspecialchars($item['titulo']); ?></h2>

            <p class="marca">
                <?php echo htmlspecialchars($item['descricao']); ?>
            </p>
        </div>
        
        <div class="item-estatisticas">
            <div class="nota-geral">
                <span class="nota-numero">4.8</span>
                <div class="estrelas">★★★★★</div>
                <span class="total-reviews">(128 avaliações)</span>
            </div>

            <a href="?p=escrever-review&id=<?php echo (int) $item['id']; ?>" class="btn-neon">
                Deixar minha Avaliação
            </a>
        </div>
    </section>

    <section class="feed-reviews">
        <div class="cabecalho-secao">
            <h2>Comentários da <span>Comunidade</span></h2>
        </div>

        <div class="lista-comentarios">
            <?php if (empty($reviews)): ?>
                <p>Ainda não há avaliações para este item.</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <article class="review-card">
                        <div class="review-header">
                            <div class="usuario-info">
                                <div class="avatar-placeholder">
                                    <?php echo strtoupper(substr($review['nome_usuario'], 0, 1)); ?>
                                </div>

                                <div>
                                    <p class="nome-usuario">
                                        <?php echo htmlspecialchars($review['nome_usuario']); ?>
                                    </p>

                                    <p class="data-postagem">
                                        Postado em <?php echo date('d/m/Y', strtotime($review['criado_em'])); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="estrelas">
                                <?php echo str_repeat('★', (int) $review['nota']); ?>
                                <?php echo str_repeat('☆', 5 - (int) $review['nota']); ?>
                            </div>
                        </div>

                        <h4 class="review-titulo">
                            <?php echo htmlspecialchars($review['titulo']); ?>
                        </h4>

                        <p class="review-texto">
                            <?php echo nl2br(htmlspecialchars($review['comentario'])); ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>