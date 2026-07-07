<?php

require_once "../model/Servico.inc.php";
require_once "../repository/ServicoRepository.inc.php";

require_once "controller.inc.php";

function salvar()
{
    requireAdmin();

    $idServico = isset($_POST['idServico']) ? (int)$_POST['idServico'] : 0;

    $valorString = $_POST['valor'] ?? '0';
    $valorTratado = str_replace(['.', ','], ['', '.'], $valorString);

    $servico = new Servico(
        $_POST['nome'] ?? '',
        (float) $valorTratado,
        $_POST['unidadeMedida'] ?? '',
        $_POST['categoria'] ?? '',
        $_POST['descricao'] ?? '',
        !empty($_POST['tamanho']) ? $_POST['tamanho'] : null,
        !empty($_POST['material']) ? $_POST['material'] : null,
        !empty($_POST['tipoMaterial']) ? $_POST['tipoMaterial'] : null,
        !empty($_POST['cor']) ? $_POST['cor'] : null,
        $idServico
    );

    $repository = new ServicoRepository();
    if ($idServico == 0) {
        $repository->inserir($servico);
    } else {
        $repository->atualizar($servico);
    }

    header("Location: servicoController.php?opcao=listarTodos&acao=gerenciar");
    exit;
}

function editar()
{
    requireAdmin();

    $idServico = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

    if ($idServico > 0) {
        $repository = new ServicoRepository();
        $servico = $repository->buscarPorId($idServico);

        if ($servico) {
            $_SESSION['servico'] = $servico;
            header("Location: ../view/formServico.php");
            exit;
        }
    }

    header("Location: servicoController.php?opcao=listarTodos&acao=gerenciar");
    exit;
}

function listarTodos()
{
    $repository = new ServicoRepository();

    $busca = $_REQUEST['busca'] ?? '';
    $categoria = $_REQUEST['categoria'] ?? '';

    if (str_contains($busca, "CK")) {
        $busca = str_replace("#", "", $busca);
        $busca = (int) str_replace("CK", "", $busca);
        $busca -= 100;
    }

    $_SESSION['filtro_busca'] = $busca;
    $_SESSION['filtro_categoria'] = $categoria;

    $servicos = $repository->listarTodos($busca, $categoria);
    $categorias = $repository->listarTodasCategorias();

    $_SESSION['servicos'] = $servicos;
    $_SESSION['categorias'] = $categorias;

    $acao = $_REQUEST['acao'] ?? '';

    if ($acao == "gerenciar" && isAdmin()) {
        header("Location: ../view/gerenciarServico.php");
        exit;
    } else {
        header("Location: ../view/listarTodosServico.php");
        exit;
    }
}

function excluir()
{
    requireAdmin();

    $idServico = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

    if ($idServico > 0) {
        $repository = new ServicoRepository();
        $repository->excluir($idServico);
    }

    header("Location: servicoController.php?opcao=listarTodos&acao=gerenciar");
    exit;
}
