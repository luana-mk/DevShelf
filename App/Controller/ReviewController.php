<?php
declare(strict_types=1);

require_once __DIR__ . '/../Model/ReviewModel.php';

class ReviewController
{
    private ReviewModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new ReviewModel($pdo);
    }

    public function salvar(): void
    {
        // bloqueia se não estiver logado
        if (empty($_SESSION['usuario_id'])) {
            header('Location: ?p=login');
            exit;
        }

        // valida CSRF
        if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
            die('Token inválido.');
        }

        $item_id = (int) ($_POST['item_id'] ?? 0);
        $nota = (int) ($_POST['nota'] ?? 0);
        $titulo = trim($_POST['titulo_review'] ?? '');
        $comentario = trim($_POST['comentario'] ?? '');
        $usuario_id = (int) $_SESSION['usuario_id'];

        // validações básicas
        if ($item_id <= 0 || $nota < 1 || $nota > 5 || $titulo === '' || $comentario === '') {
            header('Location: ?p=escrever-review&id=' . $item_id . '&erro=campos');
            exit;
        }

        // impede review duplicada
        if ($this->model->usuarioJaAvaliou($item_id, $usuario_id)) {
            header('Location: ?p=detalhes&id=' . $item_id . '&erro=duplicada');
            exit;
        }

        $this->model->salvar($item_id, $usuario_id, $nota, $titulo, $comentario);

        header('Location: ?p=detalhes&id=' . $item_id . '&sucesso=1');
        exit;
    }

    public function listarPorItem(int $item_id): array
    {
        return $this->model->buscarPorItem($item_id);
    }
}