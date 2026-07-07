<?php
include_once "Repository.inc.php";
include_once "../model/Usuario.inc.php";

class UsuarioRepository extends Repository
{
    public function inserir(Usuario $usuario)
    {
        $sql = $this->con->prepare("
            INSERT INTO usuario(nome, email, senha, cargo, cpf, dataNascimento, logradouro, cidade, estado, cep, telefone) 
            VALUES (:nome, :email, :senha, :cargo, :cpf, :dataNascimento, :logradouro, :cidade, :estado, :cep, :telefone)
        ");

        $sql->bindValue(":nome", $usuario->getNome());
        $sql->bindValue(":email", $usuario->getEmail());
        $sql->bindValue(":senha", $usuario->getSenha());
        $sql->bindValue(":cargo", $usuario->getCargo());
        $sql->bindValue(":cpf", $usuario->getCpf());
        $sql->bindValue(":dataNascimento", $usuario->getDataNascimento());
        $sql->bindValue(":logradouro", $usuario->getLogradouro());
        $sql->bindValue(":cidade", $usuario->getCidade());
        $sql->bindValue(":estado", $usuario->getEstado());
        $sql->bindValue(":cep", $usuario->getCep());
        $sql->bindValue(":telefone", $usuario->getTelefone());

        $sql->execute();

        return $this->con->lastInsertId();
    }

    public function autenticar(string $email, string $senha)
    {
        $sql = $this->con->prepare("
            SELECT * FROM usuario WHERE email = :email AND senha = :senha
        ");

        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);

        $sql->execute();

        if ($sql->rowCount() == 1) {
            $registro = $sql->fetch(PDO::FETCH_OBJ);

            $usuario = new Usuario(
                $registro->nome,
                $registro->email,
                $registro->senha,
                $registro->cpf,
                $registro->dataNascimento,
                $registro->cargo,
                $registro->logradouro,
                $registro->cidade,
                $registro->estado,
                $registro->cep,
                $registro->telefone,
                $registro->idUsuario
            );

            return $usuario;
        }

        return null;
    }

    public function buscarPorId(int $idUsuario): ?Usuario
    {
        $sql = $this->con->prepare("
            SELECT * FROM usuario WHERE idUsuario = :idUsuario
        ");

        $sql->bindValue(":idUsuario", $idUsuario);
        $sql->execute();

        if ($sql->rowCount() == 1) {
            $registro = $sql->fetch(PDO::FETCH_OBJ);

            $usuario = new Usuario(
                $registro->nome,
                $registro->email,
                $registro->senha,
                $registro->cpf,
                $registro->dataNascimento,
                $registro->cargo,
                $registro->logradouro,
                $registro->cidade,
                $registro->estado,
                $registro->cep,
                $registro->telefone,
                $registro->idUsuario
            );

            return $usuario;
        }

        return null;
    }

    public function atualizar(Usuario $usuario)
    {
        $sql = $this->con->prepare("
            UPDATE usuario
            SET nome = :nome, email = :email, senha = :senha, dataNascimento = :dataNascimento, cargo = :cargo,
                logradouro = :logradouro, cidade = :cidade, estado = :estado, cep = :cep, telefone = :telefone
            WHERE idUsuario = :idUsuario
        ");

        $sql->bindValue(":nome", $usuario->getNome());
        $sql->bindValue(":email", $usuario->getEmail());
        $sql->bindValue(":senha", $usuario->getSenha());
        $sql->bindValue(":dataNascimento", $usuario->getDataNascimento());
        $sql->bindValue(":cargo", $usuario->getCargo());
        $sql->bindValue(":logradouro", $usuario->getLogradouro());
        $sql->bindValue(":cidade", $usuario->getCidade());
        $sql->bindValue(":estado", $usuario->getEstado());
        $sql->bindValue(":cep", $usuario->getCep());
        $sql->bindValue(":telefone", $usuario->getTelefone());
        $sql->bindValue(":idUsuario", $usuario->getIdUsuario());

        $sql->execute();

        return $this->buscarPorId($usuario->getIdUsuario());
    }

    public function excluir(int $idUsuario)
    {
        $sql = $this->con->prepare("
            DELETE FROM usuario
            WHERE idUsuario = :idUsuario
        ");

        $sql->bindValue(":idUsuario", $idUsuario);
        $sql->execute();
    }

    public function listarTodos(): array
    {
        $sql = $this->con->query("SELECT * FROM usuario");

        $usuarios = [];
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $usuarios[] = new Usuario(
                $row->nome,
                $row->email,
                $row->senha,
                $row->cpf,
                $row->dataNascimento,
                $row->cargo,
                $row->logradouro,
                $row->cidade,
                $row->estado,
                $row->cep,
                $row->telefone,
                $row->idUsuario
            );
        }
        return $usuarios;
    }
}
