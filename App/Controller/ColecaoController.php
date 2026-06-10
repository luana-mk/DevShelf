<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/ColecaoModel.php';

class ColecaoController
{
    private ColecaoModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new ColecaoModel($pdo);
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
            header('Location: ?p=minhas-listas&erro=nome');
            exit;
        }

        $this->model->criar($nome, $descricao, $usuario_id);

        header('Location: ?p=minhas-listas&sucesso=1');
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
            header('Location: ?p=minhas-listas&erro=item');
            exit;
        }

        $this->model->adicionarItem($colecao_id, $item_id);

        header('Location: ?p=minhas-listas&sucesso=1');
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

        header('Location: ?p=minhas-listas&sucesso=removido');
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

        header('Location: ?p=minhas-listas&sucesso=removida');
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
        return isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token']);
    }
}
