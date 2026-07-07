<?php

require_once "../model/Venda.inc.php";
require_once "../repository/VendaRepository.inc.php";

require_once "controller.inc.php";

function finalizarVenda()
{
    requireLogin();

    if (empty($_SESSION['carrinho'])) {
        header("Location: ../view/mostrarCarrinho.php");
        exit;
    }

    $usuario = $_SESSION['usuario'];
    $total = (float) ($_SESSION['total'] ?? 0);
    $carrinho = $_SESSION['carrinho'];

    $venda = new Venda($usuario, $total);
    $venda->setData(time());

    $repository = new VendaRepository();
    $repository->inserirVenda($venda, $carrinho); 

    $_SESSION['venda_detalhe'] = $venda;

    unset($_SESSION['carrinho']);
    unset($_SESSION['total']);

    header("Location: ../view/mostrarBoleto.php");
    exit;
}

function listarTodas()
{
    requireAdmin();

    if (isset($_GET['limpar']) && $_GET['limpar'] == '1') {
        $dataInicio = '';
        $dataFim = '';
    } else {
        $dataInicio = trim($_REQUEST['dataInicio'] ?? '');
        $dataFim = trim($_REQUEST['dataFim'] ?? '');
    }

    $_SESSION['filtro_data_inicio'] = $dataInicio;
    $_SESSION['filtro_data_fim'] = $dataFim;

    $repository = new VendaRepository();
    $listaVendas = $repository->listarTodas($dataInicio, $dataFim);

    $_SESSION['vendas'] = $listaVendas;

    header("Location: ../view/listarTodasVenda.php");
    exit;
}

function detalhar()
{
    requireAdmin();

    $idVenda = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

    if ($idVenda > 0) {
        $repository = new VendaRepository();

        $venda = $repository->buscarVendaPorId($idVenda);

        if ($venda != null) {
            $itens = $repository->buscarItensDaVenda($idVenda, $venda);
            $_SESSION['venda_detalhe'] = $venda;
            $_SESSION['itens_venda'] = $itens;

            header("Location: ../view/detalhesVenda.php");
            exit;
        }
    }

    header("Location: vendaController.php?opcao=listarTodas");
    exit;
}

function listarMinhasVendas()
{
    requireLogin();

    $usuario = $_SESSION['usuario'];
    $repository = new VendaRepository();

    $_SESSION['minhas_encomendas'] = $repository->buscarVendasPorUsuario($usuario);

    header("Location: ../view/mostrarEncomendas.php");
    exit;
}

function detalharMinhaVenda()
{
    requireLogin();

    $idVenda = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

    if ($idVenda > 0) {
        $repository = new VendaRepository();

        $venda = $repository->buscarVendaPorId($idVenda);

        if ($venda != null && $venda->getUsuario()->getIdUsuario() === $_SESSION['usuario']->getIdUsuario()) {

            $itens = $repository->buscarItensDaVenda($idVenda, $venda);

            $_SESSION['venda_detalhe'] = $venda;
            $_SESSION['itens_venda'] = $itens;

            header("Location: ../view/detalhesEncomendas.php");
            exit;
        }
    }

    header("Location: vendaController.php?opcao=listarMinhasVendas");
    exit;
}
