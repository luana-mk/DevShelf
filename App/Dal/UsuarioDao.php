<?php
namespace App\Dal;

use App\Dal\Conn;
use App\Model\Usuario;
use Exception;
use PDO;
use PDOException;

abstract class UsuarioDao {

    public static function cadastrar(Usuario $usuario): int {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare(
                "INSERT INTO usuarios (nome, email, senha, cpf, data_nasc)
                 VALUES (:nome, :email, :senha, :cpf, :data_nasc)"
            );
            $sql->bindValue(":nome", $usuario->getNome(),     PDO::PARAM_STR);
            $sql->bindValue(":email", $usuario->getEmail(),    PDO::PARAM_STR);
            $sql->bindValue(":senha", $usuario->getSenha(),    PDO::PARAM_STR);
            $sql->bindValue(":cpf", $usuario->getCpf(),      PDO::PARAM_STR);
            $sql->bindValue(":data_nasc", $usuario->getDataNasc(), PDO::PARAM_STR);
            $sql->execute();

            return (int) $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function buscarPorEmail(string $email): ?Usuario {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
            $sql->execute([$email]);
            $dados = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$dados) return null;

            return Usuario::criar(
                (int) $dados['id'],
                $dados['nome'],
                $dados['email'],
                $dados['senha'],
                $dados['cpf'],
                $dados['data_nasc']
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function buscarPorId(int $id): ?Usuario {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
            $sql->execute([$id]);
            $dados = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$dados) return null;

            return Usuario::criar(
                (int) $dados['id'],
                $dados['nome'],
                $dados['email'],
                $dados['senha'],
                $dados['cpf'],
                $dados['data_nasc']
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function emailExiste(string $email): bool {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
            $sql->execute([$email]);
            return (bool) $sql->fetch();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function cpfExiste(string $cpf): bool {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare("SELECT id FROM usuarios WHERE cpf = ? LIMIT 1");
            $sql->execute([$cpf]);
            return (bool) $sql->fetch();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function validarRecuperacao(string $cpf, string $dataNasc): ?Usuario {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare(
                "SELECT * FROM usuarios WHERE cpf = ? AND data_nasc = ? LIMIT 1"
            );
            $sql->execute([$cpf, $dataNasc]);
            $dados = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$dados) return null;

            return Usuario::criar(
                (int) $dados['id'],
                $dados['nome'],
                $dados['email'],
                $dados['senha'],
                $dados['cpf'],
                $dados['data_nasc']
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function atualizarSenha(int $id, string $novaSenha): void {
        try {
            $pdo = Conn::getConn();
            $sql = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
            $sql->execute([$novaSenha, $id]);

            if ($sql->rowCount() !== 1) {
                throw new Exception("Nenhum registro foi alterado");
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }
}