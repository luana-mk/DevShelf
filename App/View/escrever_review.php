<main class="container-principal">
    
    <section class="card-item form-review-container">
        
        <div class="cabecalho-secao">
            <h2>Deixe sua <span>Avaliação</span></h2>
            <p>Sua opinião ajuda outros desenvolvedores a tomarem decisões melhores.</p>
        </div>

        <form action="?p=salvar-review" method="POST" class="form-autenticacao form-review">
            
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>"> <div class="grupo-campo">
                <label for="nota">Nota</label>
                <select id="nota" name="nota" required class="input-dark">
                    <option value="" disabled selected>Escolha uma nota...</option>
                    <option value="5">★★★★★ - Excelente (Recomendo muito)</option>
                    <option value="4">★★★★☆ - Muito Bom (Recomendo)</option>
                    <option value="3">★★★☆☆ - Bom (Pode melhorar)</option>
                    <option value="2">★★☆☆☆ - Regular (Não atendeu as expectativas)</option>
                    <option value="1">★☆☆☆☆ - Ruim (Não recomendo)</option>
                </select>
            </div>

            <div class="grupo-campo">
                <label for="titulo_review">Título da Avaliação</label>
                <input type="text" id="titulo_review" name="titulo_review" required placeholder="Ex: Curva de aprendizado alta, mas vale a pena" class="input-dark">
            </div>

            <div class="grupo-campo">
                <label for="comentario">Comentário Completo</label>
                <textarea id="comentario" name="comentario" rows="6" required placeholder="Conte sua experiência prática. Quais os pontos fortes e fracos?" class="input-dark"></textarea>
            </div>

            <button type="submit" name="btn-avaliar" class="btn-neon">Publicar Avaliação</button>
        </form>

    </section>
</main>