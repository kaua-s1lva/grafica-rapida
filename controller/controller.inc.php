<?php

include_once "../model/Usuario.inc.php";

session_start();

$opcao = $_REQUEST['opcao'] ?? '';
$rotasPermitidas = [
    'cadastrar', 
    'editar', 
    'atualizar', 
    'excluir', 
    'excluirAdmin', 
    'autenticar', 
    'sair', 
    'listarTodos', 
    'salvar', 
    'finalizarVenda',
    'listarTodas',
    'detalhar',
    'listarMinhasVendas',
    'detalharMinhaVenda',
    'inserir',
    'remover',
    'mostrarCarrinho', 
    'diminuir', 
    'aumentar', 
    'comprar',
    'novo'
];

if (in_array($opcao, $rotasPermitidas) && function_exists($opcao)) {
    $opcao();
} else {
    header("Location: ../view/index.php");
    exit;
}

function isLogado() {
    return isset($_SESSION['usuario']);
}

function isAdmin() {
    return isLogado() && $_SESSION['usuario']->isAdmin();
}

function requireLogin() {
    if (!isLogado()) {
        header("Location: ../view/loginUsuario.php");
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: ../view/index.php");
        exit;
    }
}

?>