<?php

class Usuario {
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;
    private string $cargo;
    private string $cpf;
    private string $dataNascimento;
    private ?string $logradouro;
    private ?string $cidade;
    private ?string $estado;
    private ?string $cep;
    private ?string $telefone;

    public function __construct(
        string $nome, 
        string $email, 
        string $senha, 
        string $cpf, 
        string $dataNascimento, 
        string $cargo,
        ?string $logradouro = null, 
        ?string $cidade = null, 
        ?string $estado = null, 
        ?string $cep = null, 
        ?string $telefone = null,
        int $idUsuario = 0
    ) {
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->cargo = $cargo;
        $this->logradouro = $logradouro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
        $this->telefone = $telefone;
    }

    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getSenha(): string { return $this->senha; }
    public function getCpf(): string { return $this->cpf; }
    public function getDataNascimento(): string { return $this->dataNascimento; }
    public function getLogradouro(): ?string { return $this->logradouro; }
    public function getCidade(): ?string { return $this->cidade; }
    public function getEstado(): ?string { return $this->estado; }
    public function getCep(): ?string { return $this->cep; }
    public function getTelefone(): ?string { return $this->telefone; }
    public function getIdUsuario(): int { return $this->idUsuario; }
    public function getCargo(): string { return $this->cargo; }

    public function setNome(string $nome): void { $this->nome = $nome; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setSenha(string $senha): void { $this->senha = $senha; }
    public function setCpf(string $cpf): void { $this->cpf = $cpf; }
    public function setDataNascimento(string $dataNascimento): void { $this->dataNascimento = $dataNascimento; }
    public function setLogradouro(string $logradouro): void { $this->logradouro = $logradouro; }
    public function setCidade(string $cidade): void { $this->cidade = $cidade; }
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function setCep(string $cep): void { $this->cep = $cep; }
    public function setTelefone(string $telefone): void { $this->telefone = $telefone; }
    public function setIdUsuario(int $idUsuario): void { $this->idUsuario = $idUsuario; }
    public function setCargo(string $cargo): void { $this->cargo = $cargo; }

    public function isAdmin() {
        return ($this->cargo == "admin" ? true : false);
    }
}
?>