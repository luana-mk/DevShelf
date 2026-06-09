<?php
declare(strict_types=1);

use App\Dal\UsuarioDao;
use App\Model\Usuario;

class UsuarioController {

    // ------------------------------------------------------------------ //
    //  CADASTRO
    // ------------------------------------------------------------------ //

    public static function cadastrar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (!self::csrfValido()) {
            self::redirecionar('cadastro-usuario', 'Token inválido. Tente novamente.');
            return;
        }

        $nome     = trim($_POST['nome']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $senha    = $_POST['senha']         ?? '';
        $confirm  = $_POST['confirmar']     ?? '';
        $cpf      = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
        $dataNasc = $_POST['data_nasc']     ?? '';

        if (!$nome || !$email || !$senha || !$cpf || !$dataNasc) {
            self::redirecionar('cadastro-usuario', 'Preencha todos os campos.');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::redirecionar('cadastro-usuario', 'E-mail inválido.');
            return;
        }

        if (strlen($cpf) !== 11) {
            self::redirecionar('cadastro-usuario', 'CPF inválido.');
            return;
        }

        if ($senha !== $confirm) {
            self::redirecionar('cadastro-usuario', 'As senhas não coincidem.');
            return;
        }

        if (strlen($senha) < 8) {
            self::redirecionar('cadastro-usuario', 'A senha deve ter pelo menos 8 caracteres.');
            return;
        }

        if (UsuarioDao::emailExiste($email)) {
            self::redirecionar('cadastro-usuario', 'Este e-mail já está cadastrado.');
            return;
        }

        if (UsuarioDao::cpfExiste($cpf)) {
            self::redirecionar('cadastro-usuario', 'Este CPF já está cadastrado.');
            return;
        }

        $hash    = password_hash($senha, PASSWORD_BCRYPT);
        $usuario = new Usuario($nome, $email, $hash, $cpf, $dataNasc);
        UsuarioDao::cadastrar($usuario);

        $salvo = UsuarioDao::buscarPorEmail($email);
        self::iniciarSessao($salvo);
        header('Location: ?p=home');
        exit;
    }

    // ------------------------------------------------------------------ //
    //  LOGIN
    // ------------------------------------------------------------------ //

    public static function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (!self::csrfValido()) {
            self::redirecionar('login', 'Token inválido. Tente novamente.');
            return;
        }

        $email   = trim($_POST['email'] ?? '');
        $senha   = $_POST['senha']      ?? '';
        $lembrar = isset($_POST['lembrar']);

        if (!$email || !$senha) {
            self::redirecionar('login', 'Preencha e-mail e senha.');
            return;
        }

        $usuario = UsuarioDao::buscarPorEmail($email);

        if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
            self::redirecionar('login', 'E-mail ou senha incorretos.');
            return;
        }

        self::iniciarSessao($usuario);

        if ($lembrar) {
            setcookie('lembrar_id', (string) $usuario->getId(), [
                'expires'  => time() + (30 * 24 * 60 * 60),
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }

        header('Location: ?p=home');
        exit;
    }

    // ------------------------------------------------------------------ //
    //  LOGOUT
    // ------------------------------------------------------------------ //

    public static function logout(): void {
        $_SESSION = [];
        session_destroy();
        setcookie('lembrar_id', '', time() - 3600, '/');
        header('Location: ?p=home');
        exit;
    }

    // ------------------------------------------------------------------ //
    //  RECUPERAR SENHA
    // ------------------------------------------------------------------ //

    public static function recuperarSenha(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (!self::csrfValido()) {
            self::redirecionar('recuperar', 'Token inválido. Tente novamente.');
            return;
        }

        $etapa = $_POST['etapa'] ?? 'validar';

        if ($etapa === 'validar') {
            $cpf      = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
            $dataNasc = $_POST['data_nasc'] ?? '';

            if (!$cpf || !$dataNasc) {
                self::redirecionar('recuperar', 'Preencha todos os campos.');
                return;
            }

            $usuario = UsuarioDao::validarRecuperacao($cpf, $dataNasc);

            if (!$usuario) {
                self::redirecionar('recuperar', 'CPF ou data de nascimento incorretos.');
                return;
            }

            $_SESSION['recuperar_id'] = $usuario->getId();
            header('Location: ?p=recuperar&etapa=nova-senha');
            exit;
        }

        if ($etapa === 'nova-senha') {
            if (empty($_SESSION['recuperar_id'])) {
                self::redirecionar('recuperar', 'Sessão expirada. Tente novamente.');
                return;
            }

            $nova    = $_POST['senha']     ?? '';
            $confirm = $_POST['confirmar'] ?? '';

            if (!$nova || !$confirm) {
                self::redirecionar('recuperar&etapa=nova-senha', 'Preencha todos os campos.');
                return;
            }

            if ($nova !== $confirm) {
                self::redirecionar('recuperar&etapa=nova-senha', 'As senhas não coincidem.');
                return;
            }

            if (strlen($nova) < 8) {
                self::redirecionar('recuperar&etapa=nova-senha', 'A senha deve ter pelo menos 8 caracteres.');
                return;
            }

            $hash = password_hash($nova, PASSWORD_BCRYPT);
            UsuarioDao::atualizarSenha((int) $_SESSION['recuperar_id'], $hash);
            unset($_SESSION['recuperar_id']);

            self::redirecionar('login', 'Senha atualizada com sucesso! Faça login.');
        }
    }

    // ------------------------------------------------------------------ //
    //  RESTAURAR SESSÃO via cookie "lembrar de mim"
    // ------------------------------------------------------------------ //

    public static function tentarLembrar(): void {
        if (!empty($_SESSION['usuario_id'])) return;

        if (!empty($_COOKIE['lembrar_id'])) {
            $usuario = UsuarioDao::buscarPorId((int) $_COOKIE['lembrar_id']);
            if ($usuario) {
                self::iniciarSessao($usuario);
            }
        }
    }

    // ------------------------------------------------------------------ //
    //  HELPERS PRIVADOS
    // ------------------------------------------------------------------ //

    private static function iniciarSessao(Usuario $usuario): void {
        session_regenerate_id(true);
        $_SESSION['usuario_id']    = $usuario->getId();
        $_SESSION['usuario_nome']  = $usuario->getNome();
        $_SESSION['usuario_email'] = $usuario->getEmail();
    }

    private static function csrfValido(): bool {
        return isset($_POST['csrf_token'])
            && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token']);
    }

    private static function redirecionar(string $pagina, string $msg): void {
        $_SESSION['flash'] = $msg;
        header("Location: ?p={$pagina}");
        exit;
    }
}

// Roteamento das ações
$acao = $_GET['acao'] ?? '';

match ($acao) {
    'cadastrar'       => UsuarioController::cadastrar(),
    'login'           => UsuarioController::login(),
    'logout'          => UsuarioController::logout(),
    'recuperar-senha' => UsuarioController::recuperarSenha(),
    default           => null,
};