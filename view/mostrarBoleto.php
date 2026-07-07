<?php
// 1. Inclusão das Models
include_once "../model/Usuario.inc.php";
include_once "../model/Venda.inc.php";
include_once "components/cabecalho.inc.php";

// 2. Proteção e Resgate de Dados
if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
    exit;
}

// Assumindo que o controller de vendas salvou a última venda nesta variável 
// (ou você pode passar o ID via GET e buscar no banco)
$venda = $_SESSION['venda_detalhe'] ?? null;
$cliente = $_SESSION['usuario'];

// Se por acaso acessar sem uma venda definida, volta para as encomendas
if (!$venda) {
    echo "<script>window.location.href='../controller/vendaController.php?opcao=listarMinhasVendas';</script>";
    exit;
}

// 3. Dados Simulados (Mock) para o Boleto Visual
$banco = "033-7"; // Código fictício (ex: Santander)
$linhaDigitavel = "03399.00000 00000.000000 00000.000000 0 00000000000000";
$vencimento = date('d/m/Y', strtotime('+3 days')); // Vence em 3 dias
$nossoNumero = "0000" . str_pad($venda->getIdVenda(), 6, '0', STR_PAD_LEFT);
$documento = str_pad($venda->getIdVenda(), 8, '0', STR_PAD_LEFT);
?>

<style>
    /* Estilização específica para manter o layout clássico do Boleto */
    .boleto-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        color: #000;
        font-family: Arial, sans-serif;
    }
    .boleto-linha {
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
    }
    .boleto-celula {
        border-left: 1px solid #000;
        padding: 2px 5px;
    }
    .boleto-celula-titulo {
        font-size: 0.65rem;
        color: #333;
        margin-bottom: 2px;
        display: block;
    }
    .boleto-celula-valor {
        font-size: 0.9rem;
        font-weight: bold;
    }
    .banco-logo {
        font-size: 1.5rem;
        font-weight: 900;
        border-right: 2px solid #000;
        padding-right: 15px;
    }
    .banco-codigo {
        font-size: 1.5rem;
        font-weight: bold;
        border-right: 2px solid #000;
        padding: 0 15px;
    }
    .linha-digitavel {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
    }
    /* Simulação visual de Código de Barras */
    .codigo-barras-mock {
        height: 60px;
        width: 100%;
        background-image: repeating-linear-gradient(
            90deg,
            #000,
            #000 2px,
            transparent 2px,
            transparent 4px,
            #000 4px,
            #000 5px,
            transparent 5px,
            transparent 8px
        );
    }
    
    @media print {
        header, footer, nav, .d-print-none { display: none !important; }
        body { background: #fff !important; }
        .boleto-container { border: none; box-shadow: none !important; margin-top: 0; }
    }
</style>

<div class="container py-5">
    
    <div class="text-center mb-4 d-print-none">
        <h2 class="fw-bold text-success"><i class="bi bi-check-circle-fill me-2"></i>Pedido Finalizado!</h2>
        <p class="text-muted">Imprima ou salve o boleto abaixo (apenas demonstrativo).</p>
        <button onclick="window.print()" class="btn btn-outline-dark fw-bold px-4 py-2 mt-2 rounded-3">
            <i class="bi bi-printer me-2"></i> Imprimir Boleto
        </button>
        <a href="../controller/vendaController.php?opcao=listarMinhasVendas" class="btn btn-primary fw-bold px-4 py-2 mt-2 ms-2 rounded-3">
            Minhas Encomendas
        </a>
    </div>

    <div class="boleto-container border border-dark p-4 shadow-sm">
        
        <div class="row align-items-end mb-2 pb-2" style="border-bottom: 2px solid #000;">
            <div class="col-auto">
                <span class="banco-logo">BANCO MOCKUP</span>
            </div>
            <div class="col-auto">
                <span class="banco-codigo"><?= $banco ?></span>
            </div>
            <div class="col">
                <div class="linha-digitavel"><?= $linhaDigitavel ?></div>
            </div>
        </div>

        <div class="row g-0 boleto-linha" style="border-top: 1px solid #000;">
            <div class="col-9 boleto-celula">
                <span class="boleto-celula-titulo">Local de Pagamento</span>
                <span class="boleto-celula-valor">Pagável em qualquer agência bancária até o vencimento (Mockup)</span>
            </div>
            <div class="col-3 boleto-celula" style="background-color: #f4f4f4;">
                <span class="boleto-celula-titulo">Vencimento</span>
                <span class="boleto-celula-valor float-end"><?= $vencimento ?></span>
            </div>
        </div>

        <div class="row g-0 boleto-linha">
            <div class="col-9 boleto-celula">
                <span class="boleto-celula-titulo">Cedente</span>
                <span class="boleto-celula-valor">Gráfica Rápida LTDA - CNPJ: 00.000.000/0001-00</span>
            </div>
            <div class="col-3 boleto-celula">
                <span class="boleto-celula-titulo">Agência / Código do Cedente</span>
                <span class="boleto-celula-valor float-end">1234 / 56789-0</span>
            </div>
        </div>

        <div class="row g-0 boleto-linha">
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Data Documento</span>
                <span class="boleto-celula-valor"><?= date('d/m/Y', $venda->getData()) ?></span>
            </div>
            <div class="col-3 boleto-celula">
                <span class="boleto-celula-titulo">Nº Documento</span>
                <span class="boleto-celula-valor"><?= $documento ?></span>
            </div>
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Espécie Doc.</span>
                <span class="boleto-celula-valor">DM</span>
            </div>
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Aceite</span>
                <span class="boleto-celula-valor">N</span>
            </div>
            <div class="col-3 boleto-celula">
                <span class="boleto-celula-titulo">Nosso Número</span>
                <span class="boleto-celula-valor float-end"><?= $nossoNumero ?></span>
            </div>
        </div>

        <div class="row g-0 boleto-linha">
            <div class="col-3 boleto-celula">
                <span class="boleto-celula-titulo">Uso do Banco</span>
                <span class="boleto-celula-valor">&nbsp;</span>
            </div>
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Carteira</span>
                <span class="boleto-celula-valor">109</span>
            </div>
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Espécie</span>
                <span class="boleto-celula-valor">R$</span>
            </div>
            <div class="col-2 boleto-celula">
                <span class="boleto-celula-titulo">Quantidade</span>
                <span class="boleto-celula-valor">&nbsp;</span>
            </div>
            <div class="col-3 boleto-celula" style="background-color: #f4f4f4;">
                <span class="boleto-celula-titulo">Valor do Documento</span>
                <span class="boleto-celula-valor float-end">R$ <?= number_format($venda->getValorTotal(), 2, ",", ".") ?></span>
            </div>
        </div>

        <div class="row g-0 boleto-linha" style="min-height: 120px;">
            <div class="col-9 boleto-celula">
                <span class="boleto-celula-titulo">Instruções (Texto de responsabilidade do cedente)</span>
                <div class="mt-2 small">
                    - Este é um boleto demonstrativo para o sistema Gráfica Rápida.<br>
                    - Não efetue nenhum pagamento utilizando este documento.<br>
                    - O pedido #<?= str_pad($venda->getIdVenda(), 4, '0', STR_PAD_LEFT) ?> ficará aguardando aprovação no painel.
                </div>
            </div>
            <div class="col-3">
                <div class="boleto-celula" style="border-bottom: 1px solid #000; height: 30px;">
                    <span class="boleto-celula-titulo">(-) Desconto / Abatimento</span>
                </div>
                <div class="boleto-celula" style="border-bottom: 1px solid #000; height: 30px;">
                    <span class="boleto-celula-titulo">(+) Mora / Multa</span>
                </div>
                <div class="boleto-celula" style="background-color: #f4f4f4; height: 60px;">
                    <span class="boleto-celula-titulo">(=) Valor Cobrado</span>
                </div>
            </div>
        </div>

        <div class="row g-0 boleto-linha">
            <div class="col-12 boleto-celula p-2">
                <span class="boleto-celula-titulo">Sacado</span>
                <span class="boleto-celula-valor d-block">
                    <?= $cliente->getNome() ?> - CPF: <?= $cliente->getCpf() ?>
                </span>
                <span class="small d-block mt-1">
                    <?= $cliente->getLogradouro() ?><br>
                    <?= $cliente->getCidade() ?> - <?= strtoupper($cliente->getEstado()) ?> - CEP: <?= $cliente->getCep() ?>
                </span>
            </div>
        </div>

        <div class="row g-0 mt-3 mb-2">
            <div class="col-7">
                <div class="codigo-barras-mock"></div>
            </div>
        </div>

    </div>
    </div>

<?php
include_once "components/rodape.inc.php";
?>