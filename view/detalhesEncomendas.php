<?php
include_once "../model/Usuario.inc.php";
include_once "../model/Venda.inc.php";
include_once "../model/Servico.inc.php";
include_once "../model/ItemVenda.inc.php";
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
    exit;
}

$venda = $_SESSION['venda_detalhe'] ?? null;
$itens = $_SESSION['itens_venda'] ?? [];
$usuarioLogado = $_SESSION['usuario'];

if (!$venda || $venda->getUsuario()->getIdUsuario() !== $usuarioLogado->getIdUsuario()) {
    echo "<script>window.location.href='../controller/vendaController.php?opcao=listarMinhas';</script>";
    exit;
}
?>

<div class="row mb-4 mt-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="../controller/vendaController.php?opcao=listarMinhasVendas" class="text-decoration-none">Minhas Encomendas</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Detalhes da Encomenda</li>
            </ol>
        </nav>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h1 class="fw-bold text-dark mb-0">
                    <i class="bi bi-receipt-cutoff text-primary me-2"></i>
                    Encomenda #<?= str_pad($venda->getIdVenda(), 4, '0', STR_PAD_LEFT) ?>
                </h1>
                <p class="text-muted mt-1 mb-0">Realizada em <?= date('d/m/Y \à\s H:i', $venda->getData()) ?></p>
            </div>
            <button onclick="window.print()" class="btn btn-outline-secondary fw-bold rounded-3 mt-3 mt-md-0 d-print-none">
                <i class="bi bi-printer me-2"></i> Imprimir Recibo
            </button>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-wallet2 text-success me-2"></i>Pagamento</h5>
            <div class="bg-light p-3 rounded-3 text-secondary">
                <p class="mb-2 small d-flex justify-content-between">
                    <span>Método:</span> 
                    <strong class="text-dark"><i class="bi bi-upc-scan text-primary me-1"></i> Boleto Bancário</strong>
                </p>
                <p class="mb-0 small d-flex justify-content-between">
                    <span>Status:</span> 
                    <span class="badge bg-warning text-dark border border-warning-subtle">Aguardando Pagamento</span>
                </p>
                
                <a href="mostrarBoleto.php" class="btn btn-outline-primary btn-sm fw-bold w-100 mt-3 d-print-none">
                    <i class="bi bi-upc-scan me-1"></i> Visualizar Boleto
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Endereço de Entrega</h5>
            <div class="bg-light p-3 rounded-3 text-secondary">
                <?php if (!empty($usuarioLogado->getLogradouro())): ?>
                    <p class="mb-1 text-dark fw-medium"><?= $usuarioLogado->getLogradouro() ?></p>
                    <p class="mb-1 small"><?= $usuarioLogado->getCidade() ?> - <?= strtoupper($usuarioLogado->getEstado()) ?></p>
                    <p class="mb-0 small">CEP: <?= $usuarioLogado->getCep() ?></p>
                <?php else: ?>
                    <p class="mb-0 small text-muted fst-italic">Endereço não cadastrado ou retirada no local.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="p-4 border-bottom bg-light bg-opacity-50">
                <h5 class="fw-bold mb-0"><i class="bi bi-box-seam-fill text-primary me-2"></i>Itens da Encomenda</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th scope="col" class="ps-4 py-3">Serviço</th>
                            <th scope="col" class="py-3 text-center">Qtd.</th>
                            <th scope="col" class="py-3 text-end">Valor Unit.</th>
                            <th scope="col" class="pe-4 py-3 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($itens)): 
                        ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Houve um erro ao carregar os itens.</td>
                            </tr>
                        <?php 
                        else:
                            foreach ($itens as $item): 
                        ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <h6 class="fw-bold mb-1 text-dark"><?= $item->getServico()->getNome() ?></h6>
                                    <span class="text-muted small">
                                        <?= $item->getServico()->getTamanho() ? $item->getServico()->getTamanho() . ' | ' : '' ?>
                                        <?= $item->getServico()->getMaterial() ?? $item->getServico()->getCategoria() ?>
                                    </span>
                                </td>
                                
                                <td class="text-center fw-medium text-dark">
                                    <?= $item->getQuantidade() ?> <?= $item->getServico()->getUnidadeMedida() ?>
                                </td>
                                
                                <td class="text-end text-muted small">
                                    R$ <?= number_format($item->getValorUnit(), 2, ",", ".") ?>
                                </td>
                                
                                <td class="pe-4 text-end fw-bold text-dark">
                                    R$ <?= number_format($item->getValorItem(), 2, ",", ".") ?>
                                </td>
                            </tr>
                        <?php 
                            endforeach; 
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-light border-top">
                <div class="d-flex justify-content-end align-items-center">
                    <span class="text-muted me-4 text-uppercase fw-bold small">Total Final:</span>
                    <span class="fs-3 fw-bold text-success">R$ <?= number_format($venda->getValorTotal(), 2, ",", ".") ?></span>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center d-print-none">
            <a href="../controller/vendaController.php?opcao=listarMinhasVendas" class="btn btn-light border fw-bold text-secondary px-4 py-2 rounded-3">
                <i class="bi bi-arrow-left me-2"></i> Voltar para minhas encomendas
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    body { background-color: white !important; }
    .shadow-sm { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
    header, footer, nav, .bg-primary.bg-opacity-10 { display: none !important; }
    .card { border: 1px solid #ddd !important; }
}
</style>

<?php
include_once "components/rodape.inc.php";
?>