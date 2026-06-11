<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/ColecaoModel.php';
require_once __DIR__ . '/../Model/Item.php';

class ColecaoController
{
    private ColecaoModel $model;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->model = new ColecaoModel($pdo);
    }

    public function minhasListas(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        $usuario_id = (int) $_SESSION['usuario_id'];

        $colecoes = $this->model->listarPorUsuario($usuario_id);

        foreach ($colecoes as &$colecao) {
            $colecao['itens'] = $this->model->buscarItensDaColecao(
            (int)$colecao['id']
        );
        }

        $itemModel = new Item($this->pdo);
        $itensDisponiveis = $itemModel->listarTodos();

        require_once __DIR__ . '/../View/minhas_listas.php';
    }

    public function criar(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $nome = trim((string) ($_POST['nome'] ?? ''));
        $descricao = trim((string) ($_POST['descricao'] ?? ''));
        $usuario_id = (int) $_SESSION['usuario_id'];

        if ($nome === '') {
            echo "<script>window.location.href='?p=minhas-listas&erro=nome';</script>";
            exit;
        }

        $this->model->criar($nome, $descricao, $usuario_id);

        echo "<script>window.location.href='?p=minhas-listas&sucesso=1';</script>";
        exit;
    }

    public function adicionarItem(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $colecao_id = (int) ($_POST['colecao_id'] ?? 0);
        $item_id = (int) ($_POST['item_id'] ?? 0);

        if ($colecao_id <= 0 || $item_id <= 0) {
            echo "<script>window.location.href='?p=minhas-listas&erro=item';</script>";
            exit;
        }

        $this->model->adicionarItem($colecao_id, $item_id);

        echo "<script>window.location.href='?p=minhas-listas&sucesso=1';</script>";
        exit;
    }

    public function removerItem(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $colecao_id = (int) ($_POST['colecao_id'] ?? 0);
        $item_id = (int) ($_POST['item_id'] ?? 0);

        $this->model->removerItem($colecao_id, $item_id);

        echo "<script>window.location.href='?p=minhas-listas&sucesso=removido';</script>";
        exit;
    }

    public function removerColecao(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        if (!$this->validarCsrf()) {
            die('Token inválido.');
        }

        $colecao_id = (int) ($_POST['colecao_id'] ?? 0);
        $usuario_id = (int) $_SESSION['usuario_id'];

        $this->model->removerColecao($colecao_id, $usuario_id);

        echo "<script>window.location.href='?p=minhas-listas&sucesso=removida';</script>";
        exit;
    }

    public function listarMinhasListas(int $usuario_id): array
    {
        return $this->model->listarPorUsuario($usuario_id);
    }

    public function itensPorColecao(int $colecao_id): array
    {
        return $this->model->buscarItensDaColecao($colecao_id);
    }

    private function validarCsrf(): bool
    {
        return isset($_POST['csrf_token'])
            && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token']);
    }
}