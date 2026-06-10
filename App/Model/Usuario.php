<?php
namespace App\Model;

class Usuario {
    private ?int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private string $cpf;
    private string $dataNasc;

    public function __construct(
        string $nome,
        string $email,
        string $senha,
        string $cpf,
        string $dataNasc,
        ?int $id = null
    ) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->cpf = $cpf;
        $this->dataNasc = $dataNasc;
        $this->id = $id;
    }

    // Factory — para recriar objeto a partir dos dados do banco
    public static function criar(
        int $id,
        string $nome,
        string $email,
        string $senha,
        string $cpf,
        string $dataNasc
    ): self {
        return new self($nome, $email, $senha, $cpf, $dataNasc, $id);
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getSenha(): string { return $this->senha; }
    public function getCpf(): string { return $this->cpf; }
    public function getDataNasc(): string { return $this->dataNasc; }
}