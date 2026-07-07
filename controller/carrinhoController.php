<?php

require_once "../model/Servico.inc.php";
require_once "../model/ItemCarrinho.inc.php";
require_once "../repository/ServicoRepository.inc.php";

require_once "controller.inc.php";

function array_search2($chave, $vetor)
{
    if (empty($vetor)) return -1;

    $index = -1;
    for ($i = 0; $i < count($vetor); $i++) {
        if ($chave == $vetor[$i]->getServico()->getIdServico()) {
            $index = $i;
            break;
        }
    }
    return $index;
}

function inserir()
{
    $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

    if ($id > 0) {
        $servicoRepository = new ServicoRepository();
        $servico = $servicoRepository->buscarPorId($id);

        if ($servico != null) {
            $item = new ItemCarrinho($servico);

            $carrinho = $_SESSION['carrinho'] ?? array();

            $key = array_search2($item->getServico()->getIdServico(), $carrinho);

            if ($key != -1) {
                $carrinho[$key]->setQuantidade();
                $carrinho[$key]->setValorItem();
            } else {
                $carrinho[] = $item;
            }

            $_SESSION['carrinho'] = $carrinho;
        }
    }

    header("Location: ../view/mostrarCarrinho.php");
    exit;
}

function remover()
{
    $index = isset($_REQUEST['index']) ? (int) $_REQUEST['index'] : -1;

    $carrinho = $_SESSION['carrinho'] ?? [];

    if ($index >= 0 && isset($carrinho[$index])) {
        unset($carrinho[$index]);
        $carrinho = array_values($carrinho);
        $_SESSION['carrinho'] = $carrinho;
    }

    header("Location: carrinhoController.php?opcao=mostrarCarrinho");
    exit;
}

function mostrarCarrinho()
{
    if (!isset($_SESSION['carrinho']) || sizeof($_SESSION['carrinho']) == 0) {
        header("Location: ../view/mostrarCarrinho.php?status=1");
        exit;
    } else {
        header("Location: ../view/mostrarCarrinho.php");
        exit;
    }
}

function diminuir()
{
    $index = isset($_REQUEST['index']) ? (int) $_REQUEST['index'] : -1;

    $carrinho = $_SESSION['carrinho'] ?? [];

    if ($index >= 0 && isset($carrinho[$index])) {
        $carrinho[$index]->diminuir();
        $carrinho[$index]->setValorItem();

        if ($carrinho[$index]->getQuantidade() == 0) {
            unset($carrinho[$index]);
            $carrinho = array_values($carrinho);
        }

        $_SESSION['carrinho'] = $carrinho;
    }

    header("Location: carrinhoController.php?opcao=mostrarCarrinho");
    exit;
}

function aumentar()
{
    $index = isset($_REQUEST['index']) ? (int) $_REQUEST['index'] : -1;

    $carrinho = $_SESSION['carrinho'] ?? [];

    if ($index >= 0 && isset($carrinho[$index])) {
        $carrinho[$index]->setQuantidade();
        $carrinho[$index]->setValorItem();
        $_SESSION['carrinho'] = $carrinho;
    }

    header("Location: carrinhoController.php?opcao=mostrarCarrinho");
    exit;
}

function comprar()
{
    $total = isset($_REQUEST['total']) ? (float) $_REQUEST['total'] : 0.0;

    if ($total > 0 && !empty($_SESSION['carrinho'])) {
        $_SESSION['total'] = $total;

        if (isset($_SESSION['usuario'])) {
            header("Location: ../view/confirmarEncomenda.php");
            exit;
        } else {
            header("Location: ../view/loginUsuario.php");
            exit;
        }
    } else {
        header("Location: ../view/mostrarCarrinho.php");
        exit;
    }
}
