<?php
// controllers/ItemController.php

require_once 'conexao.php'; // Inclui a sua conexão existente
require_once 'models/Item.php';

class ItemController {
    private $model;

    public function __construct() {
        global $conexao; // Usa a variável de conexão criada no seu conexao.php
        $this->model = new Item($conexao);
    }

    // Listar todos
    public function index() {
        $items = $this->model->listarTodos();
        require_once 'views/listar.php';
    }

    // Criar novo
    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->criar($_POST['title'], $_POST['description'], $_POST['url'], $_POST['type']);
            header('Location: index.php');
            exit;
        }
        require_once 'views/criar.php';
    }

    // Editar existente
    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: index.php'); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->atualizar($id, $_POST['title'], $_POST['description'], $_POST['url'], $_POST['type']);
            header('Location: index.php');
            exit;
        }

        $item = $this->model->buscarPorId($id);
        require_once 'views/editar.php';
    }

    // Excluir
    public function excluir() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->deletar($id);
        }
        header('Location: index.php');
        exit;
    }
}
?>