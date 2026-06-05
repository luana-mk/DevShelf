<?php
declare(strict_types=1);

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$page = $_GET['p'] ?? 'home';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevForge Reviews - A Comunidade de TI</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <?php require_once("./App/config/database.php"); ?>

    <?php
        
        match($page) {
            
            'home' => require_once("./App/View/home.php"),
            'explorar' => require_once("./App/View/explorar.php"),
            'detalhes' => require_once("./App/View/detalhes.php"),
            
            
            'login' => require_once("./App/View/login.php"),
            'cadastro-usuario' => require_once("./App/View/cadastro_usuario.php"),
            'recuperar' => require_once("./App/View/recuperar_senha.php"),
            
            'escrever-review' => require_once("./App/View/escrever_review.php"),
            
            default => require_once("./App/View/home.php")
        };
    ?>

    <?php require_once("./App/View/components/footer.php"); ?>

</body>
</html>