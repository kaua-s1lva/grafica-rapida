<?php

include_once "../repository/UsuarioRepository.inc.php";
require_once "controller.inc.php";

function cadastrar()
{
    $cargo = "cliente";

    if (isAdmin() && isset($_REQUEST['cargo'])) {
        $cargo = $_REQUEST['cargo'];
    }

    $usuario = new Usuario(
        $_REQUEST['nome'] ?? '',
        $_REQUEST['email'] ?? '',
        $_REQUEST['senha'] ?? '',
        $_REQUEST['cpf'] ?? '',
        $_REQUEST['dataNascimento'] ?? '',
        $cargo,
        $_REQUEST['logradouro'] ?? '',
        $_REQUEST['cidade'] ?? '',
        $_REQUEST['estado'] ?? '',
        $_REQUEST['cep'] ?? '',
        $_REQUEST['telefone'] ?? ''
    );

    $repository = new UsuarioRepository();
    $idUsuario = $repository->inserir($usuario);

    if (isAdmin()) {
        header("Location: usuarioController.php?opcao=listarTodos");
        exit;
    } else {
        $usuario->setIdUsuario($idUsuario);
        $_SESSION['usuario'] = $usuario;

        if (isset($_SESSION['carrinho'])) {
            header("Location: ../view/mostrarCarrinho.php");
            exit;
        } else {
            header("Location: ../controller/servicoController.php?opcao=listarTodos");
            exit;
        }
    }
}

function novo()
{
    requireAdmin();

    unset($_SESSION['usuario_editar_admin']);
    header("Location: ../view/cadastrarUsuario.php");
}

function editar()
{
    requireAdmin();

    $idUsuario = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

    if ($idUsuario > 0) {
        $repository = new UsuarioRepository();
        $usuario = $repository->buscarPorId($idUsuario);

        if ($usuario) {
            $_SESSION['usuario_editar_admin'] = $usuario;
            header("Location: ../view/cadastrarUsuario.php");
            exit;
        }
    }

    header("Location: usuarioController.php?opcao=listarTodos");
    exit;
}

function atualizar()
{
    if (!isLogado()) {
        header("Location: ../view/loginUsuario.php");
        exit;
    }

    $cargo = "cliente";
    $idUsuario = $_SESSION['usuario']->getIdUsuario();

    if (isAdmin()) {
        if (isset($_REQUEST['cargo'])) {
            $cargo = $_REQUEST['cargo'];
        }
        if (isset($_REQUEST['idUsuario'])) {
            $idUsuario = (int) $_REQUEST['idUsuario'];
        }
    } else {
        $cargo = $_SESSION['usuario']->getCargo();
    }

    $usuario = new Usuario(
        $_REQUEST['nome'] ?? '',
        $_REQUEST['email'] ?? '',
        $_REQUEST['senha'] ?? '',
        $_REQUEST['cpf'] ?? '',
        $_REQUEST['dataNascimento'] ?? '',
        $cargo,
        $_REQUEST['logradouro'] ?? '',
        $_REQUEST['cidade'] ?? '',
        $_REQUEST['estado'] ?? '',
        $_REQUEST['cep'] ?? '',
        $_REQUEST['telefone'] ?? '',
        $idUsuario
    );

    $repository = new UsuarioRepository();
    $repository->atualizar($usuario);

    if (isAdmin()) {
        header("Location: usuarioController.php?opcao=listarTodos");
        exit;
    } else {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../view/perfilUsuario.php");
        exit;
    }
}

function excluir()
{
    if (!isLogado()) {
        header("Location: ../view/loginUsuario.php");
        exit;
    }

    $idUsuario = $_SESSION['usuario']->getIdUsuario();

    $repository = new UsuarioRepository();
    $repository->excluir($idUsuario);

    sair();
}

function excluirAdmin()
{
    requireAdmin();

    $idUsuario = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

    if ($idUsuario > 0) {
        $repository = new UsuarioRepository();
        $repository->excluir($idUsuario);

        if ($_SESSION['usuario']->getIdUsuario() == $idUsuario) {
            sair();
        }
    }

    header("Location: usuarioController.php?opcao=listarTodos");
    exit;
}

function autenticar()
{
    $email = $_REQUEST['email'] ?? '';
    $senha = $_REQUEST['senha'] ?? '';

    $repository = new UsuarioRepository();
    $usuario = $repository->autenticar($email, $senha);

    if ($usuario != NULL) {
        $_SESSION['usuario'] = $usuario;

        if (isset($_SESSION['carrinho'])) {
            header("Location: ../view/mostrarCarrinho.php");
            exit;
        } else {
            header("Location: ../controller/servicoController.php?opcao=listarTodos");
            exit;
        }
    } else {
        header("Location: ../view/loginUsuario.php?erro=1");
        exit;
    }
}

function sair()
{
    session_unset();
    session_destroy();
    header("Location: ../view/index.php");
    exit;
}

function listarTodos()
{
    requireAdmin();

    $repository = new UsuarioRepository();
    $usuarios = $repository->listarTodos();

    $_SESSION['usuarios'] = $usuarios;

    header("Location: ../view/gerenciarUsuario.php");
    exit;
}
