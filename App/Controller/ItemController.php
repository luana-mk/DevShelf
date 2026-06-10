<?php

declare(strict_types=1);

require_once __DIR__ . '/../Config/conexao.php';
require_once __DIR__ . '/../Model/Item.php';

class ItemController
{
    private Item $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new Item($pdo);
    }

    public function index(): void
    {
        $items = $this->model->listarTodos();
        require_once __DIR__ . '/../View/listar_itens.php';
    }

    public function cadastrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once __DIR__ . '/../View/criar_item.php';
            return;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $imagem = trim($_POST['imagem'] ?? '');

        if ($titulo === '' || $categoria === '' || $descricao === '') {
            header('Location: ?p=criar-item&erro=campos');
            exit;
        }

        $this->model->criar($titulo, $categoria, $descricao, $imagem);

        header('Location: ?p=listar-itens&sucesso=1');
        exit;
    }

    public function editar(): void
{
    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        header('Location: ?p=listar-itens&erro=item');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $imagem = trim($_POST['imagem'] ?? '');

        if ($titulo === '' || $categoria === '' || $descricao === '') {
            header('Location: ?p=editar-item&id=' . $id . '&erro=campos');
            exit;
        }

        $this->model->atualizar($id, $titulo, $categoria, $descricao, $imagem);

        header('Location: ?p=listar-itens&sucesso=editado');
        exit;
    }

    $item = $this->model->buscarPorId($id);

    if (!$item) {
        header('Location: ?p=listar-itens&erro=item-nao-encontrado');
        exit;
    }

    require_once __DIR__ . '/../View/editar_item.php';
}

    public function excluir(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?p=listar-itens');
            exit;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model->deletar($id);
        }

        header('Location: ?p=listar-itens&sucesso=excluido');
        exit;
    }

    private function validarCsrf(): bool
    {
        return isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token']);
    }
}