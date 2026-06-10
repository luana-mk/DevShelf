<?php

$usuarioLogado = isset($_SESSION['usuario_logado']);
?>

<header class="cabecalho-principal">
    <div class="container-nav">
        
        <a href="?p=home" class="logo">Dev<span>Forge</span></a>
        
        <nav class="menu-navegacao">
            <a href="?p=home">Home</a>
            <a href="?p=explorar">Explorar</a>
            <a href="?p=minhas-listas">Minhas Listas</a>
            <a href="?p=sobre">Comunidade</a>
        </nav>
        
        <div class="menu-usuario">
            <?php if ($usuarioLogado): ?>
                <a href="?p=meu-perfil" class="link-perfil">Meu Perfil</a>
                <a href="?p=logout" class="btn-neon pequeno btn-sair">Sair</a>
            <?php else: ?>
                <a href="?p=login" class="link-login">Entrar</a>
                <a href="?p=cadastro-usuario" class="btn-neon pequeno">Cadastrar</a>
            <?php endif; ?>
        </div>

    </div>
</header>