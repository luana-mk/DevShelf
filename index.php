<?php
declare(strict_types=1);

session_start();

require_once('./autoload.php');
require_once('./App/Controller/UsuarioController.php');
UsuarioController::tentarLembrar();

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
    <link rel="stylesheet" href="./Assets/style.css">
</head>
<body>

    <?php require_once("./App/View/Components/header.php"); ?>

    <?php
        
        match($page) {
            
            'home' => require_once("./App/View/home.php"),
            'explorar' => require_once("./App/View/explorar.php"),
            'sobre' => require_once("./App/View/sobre.php"),
            'detalhes' => require_once("./App/View/detalhes.php"),
            
            
            'login' => require_once("./App/View/login.php"),
            'cadastro-usuario' => require_once("./App/View/cadastro_usuario.php"),
            'recuperar' => require_once("./App/View/recuperar_senha.php"),
            
            
            'escrever-review' => require_once("./App/View/escrever_review.php"),

            'logout' => UsuarioController::logout(),
            
            default => require_once("./App/View/home.php")
        };
    ?>

    <?php require_once("./App/View/Components/footer.php"); ?>

</body>
</html>