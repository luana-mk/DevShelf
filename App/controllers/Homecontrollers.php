<?php
class HomeController
{
    public function index()
    {
        // Instancia o model
        $userModel = new UserModel();
        
        // Exemplo: buscar um usuário pelo ID (você pode mudar o ID ou buscar de uma requisição)
        $user = $userModel->getUserById(1);

        // Passa o usuário para a view via variável global
        global $user;
        

        // Inclui a view
        require_once __DIR__ . '/../views/pages/home.php';
    }
}S