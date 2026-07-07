<?php
// O include da classe DEVE vir antes de iniciar a sessão/cabeçalho
include_once "../model/ItemCarrinho.inc.php";
// Se houver uma classe Usuario, é bom incluí-la aqui também:
include_once "../model/Usuario.inc.php"; 

include_once "components/cabecalho.inc.php";

// Proteção: Verifica se o usuário está logado e se o carrinho não está vazio
if (!isset($_SESSION['usuario']) || empty($_SESSION['carrinho'])) {
    // Se tentar acessar sem itens ou sem login, devolve para os serviços
    echo "<script>window.location.href='listarTodosServico.php';</script>";
    exit;
}

$carrinho = $_SESSION['carrinho'];
$usuario = $_SESSION['usuario']; // Puxa os dados do usuário logado

$valorTotal = 0;
$quantidadeTotal = 0;
?>

<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="mostrarCarrinho.php" class="text-decoration-none">Carrinho</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Confirmação</li>
            </ol>
        </nav>
        <h1 class="fw-bold text-dark"><i class="bi bi-check2-circle text-primary me-2"></i>Revisão do Pedido</h1>
        <p class="text-muted">Confirme seus dados de entrega e os itens selecionados antes de gerar o boleto.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Dados de Entrega</h5>
                <a href="perfilUsuario.php" class="btn btn-sm btn-outline-secondary">Editar</a>
            </div>
            <div class="bg-light p-3 rounded-3 text-secondary">
                <p class="mb-1 text-dark fw-bold fs-5"><?= $usuario->getNome() ?></p>
                <p class="mb-1">
                    <i class="bi bi-envelope me-2"></i> <?= $usuario->getEmail() ?>
                </p>
                <p class="mb-1">
                    <i class="bi bi-telephone me-2"></i> <?= $usuario->getTelefone() ?>
                </p>
                <hr class="my-2">
                <p class="mb-0">
                    <i class="bi bi-house me-2"></i> 
                    <?= $usuario->getLogradouro() ?: 'Endereço não cadastrado' ?> 
                    <?= $usuario->getCidade() ? " - " . $usuario->getCidade() : '' ?> 
                    <?= $usuario->getEstado() ? "/" . $usuario->getEstado() : '' ?>
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="p-4 bg-white border-bottom">
                <h5 class="fw-bold mb-0"><i class="bi bi-box-seam-fill text-primary me-2"></i>Itens da Encomenda</h5>
            </div>
            
            <?php 
            foreach($carrinho as $item) { 
            ?>
            <div class="row g-0 p-3 border-bottom align-items-center bg-white">
                <div class="col-md-8 px-3">
                    <h6 class="fw-bold mb-1"><?= $item->getServico()->getNome() ?></h6>
                    <p class="text-muted small mb-1"><?= $item->getServico()->getCategoria() ?></p>
                    <span class="badge bg-light text-secondary border border-secondary-subtle fw-normal">
                        <?= $item->getServico()->getTamanho() ?> | <?= $item->getServico()->getMaterial() ?>
                    </span>
                </div>
                <div class="col-md-2 px-3 mt-2 mt-md-0 text-md-center">
                    <span class="small text-muted d-block">Qtd.</span>
                    <span class="fw-bold text-dark"><?= $item->getQuantidade() ?> <?= $item->getServico()->getUnidadeMedida() ?></span>
                </div>
                <div class="col-md-2 px-3 mt-2 mt-md-0 text-md-end">
                    <span class="small text-muted d-block">Subtotal</span>
                    <span class="fw-bold text-primary">R$ <?= number_format($item->getValorItem(), 2, ",", ".") ?></span>
                </div>
            </div>
            <?php 
                $valorTotal += $item->getValorItem();
                $quantidadeTotal += $item->getQuantidade();
            } 
            ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top z-1" style="top: 100px;">
            <h4 class="fw-bold mb-4">Pagamento</h4>

            <div class="d-flex justify-content-between mb-2 text-muted">
                <span>Produtos (<?= $quantidadeTotal ?>)</span>
                <span>R$ <?= number_format($valorTotal, 2, ",", ".") ?></span>
            </div>
            <div class="d-flex justify-content-between mb-3 text-muted">
                <span>Frete / Retirada</span>
                <span class="text-success fw-bold">Grátis</span>
            </div>

            <hr class="my-3 text-light-subtle">

            <div class="d-flex justify-content-between mb-4">
                <span class="fw-bold fs-5 text-dark">Total</span>
                <span class="fw-bold fs-4 text-primary">R$ <?= number_format($valorTotal, 2, ",", ".") ?></span>
            </div>

            <div class="p-3 bg-light rounded-3 mb-4 border border-secondary-subtle text-center">
                <i class="bi bi-upc text-dark mb-2 d-block" style="font-size: 2.5rem;"></i>
                <p class="small text-muted mb-0">O pagamento será realizado via <strong>Boleto Bancário</strong> à vista.</p>
            </div>

            <a href="../controller/vendaController.php?opcao=finalizarVenda" class="btn btn-success w-100 fw-bold py-3 mb-2 rounded-3 fs-5 shadow-sm">
                <i class="bi bi-file-earmark-text me-2"></i> Gerar Boleto
            </a>
            
            <a href="mostrarCarrinho.php" class="btn btn-link text-muted text-decoration-none w-100 py-2 small">
                <i class="bi bi-arrow-left"></i> Voltar ao carrinho
            </a>
        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>