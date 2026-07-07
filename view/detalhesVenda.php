<?php
// 1. Inclusão das Models
include_once "../model/Usuario.inc.php";
include_once "../model/Venda.inc.php";
include_once "../model/Servico.inc.php";
include_once "../model/ItemVenda.inc.php";
include_once "components/cabecalho.inc.php";

// 2. Proteção de Rota (Apenas Admin)
if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']->isAdmin()) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

// 3. Resgate dos dados da sessão
$venda = $_SESSION['venda_detalhe'] ?? null;
$itens = $_SESSION['itens_venda'] ?? [];

// Se por algum motivo tentar acessar sem os dados carregados, volta pra lista
if (!$venda) {
    echo "<script>window.location.href='../controller/vendaController.php?opcao=listarTodas';</script>";
    exit;
}

$cliente = $venda->getUsuario();
?>

<div class="row mb-4 mt-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="../controller/vendaController.php?opcao=listarTodas" class="text-decoration-none">Vendas</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Detalhes do Pedido</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold text-dark mb-0">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i>
                    Pedido #<?= str_pad($venda->getIdVenda(), 4, '0', STR_PAD_LEFT) ?>
                </h1>
                <p class="text-muted mt-1 mb-0">Realizado em <?= date('d/m/Y', $venda->getData()) ?></p>
            </div>
            <a href="../controller/vendaController.php?opcao=listarTodas" class="btn btn-outline-secondary fw-bold rounded-3 d-none d-sm-block">
                <i class="bi bi-arrow-left me-2"></i> Voltar à Lista
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-4">
        
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge text-primary me-2"></i>Dados do Cliente</h5>
            <div class="bg-light p-3 rounded-3 text-secondary">
                <p class="mb-1 text-dark fw-bold fs-5"><?= $cliente->getNome() ?></p>
                <p class="mb-1 small"><i class="bi bi-person-vcard me-2"></i> CPF: <?= $cliente->getCpf() ?></p>
                <p class="mb-1 small"><i class="bi bi-envelope me-2"></i> <?= $cliente->getEmail() ?></p>
                <p class="mb-0 small"><i class="bi bi-telephone me-2"></i> <?= $cliente->getTelefone() ?? 'Não informado' ?></p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Endereço de Entrega</h5>
            <div class="bg-light p-3 rounded-3 text-secondary">
                <?php if (!empty($cliente->getLogradouro())): ?>
                    <p class="mb-1 text-dark fw-medium"><?= $cliente->getLogradouro() ?></p>
                    <p class="mb-1 small"><?= $cliente->getCidade() ?> - <?= strtoupper($cliente->getEstado()) ?></p>
                    <p class="mb-0 small">CEP: <?= $cliente->getCep() ?></p>
                <?php else: ?>
                    <p class="mb-0 small text-muted fst-italic">Endereço não cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="p-4 border-bottom bg-light bg-opacity-50">
                <h5 class="fw-bold mb-0"><i class="bi bi-box-seam-fill text-primary me-2"></i>Serviços Contratados</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th scope="col" class="ps-4 py-3">Serviço</th>
                            <th scope="col" class="py-3 text-center">Quantidade</th>
                            <th scope="col" class="py-3 text-end">Valor Unit.</th>
                            <th scope="col" class="pe-4 py-3 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($itens)): 
                        ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Nenhum item encontrado para esta venda.</td>
                            </tr>
                        <?php 
                        else:
                            foreach ($itens as $item): 
                        ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <h6 class="fw-bold mb-1 text-dark"><?= $item->getServico()->getNome() ?></h6>
                                    <span class="badge bg-light text-secondary border border-secondary-subtle fw-normal">
                                        <?= $item->getServico()->getCategoria() ?>
                                    </span>
                                </td>
                                <td class="text-center fw-medium text-dark">
                                    <?= $item->getQuantidade() ?> <?= $item->getServico()->getUnidadeMedida() ?>
                                </td>
                                <td class="text-end text-muted small">
                                    R$ <?= number_format($item->getValorItem() / $item->getQuantidade(), 2, ",", ".") ?>
                                </td>
                                <td class="pe-4 text-end fw-bold text-primary">
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
                    <span class="text-muted me-4">Valor Total do Pedido:</span>
                    <span class="fs-4 fw-bold text-success">R$ <?= number_format($venda->getValorTotal(), 2, ",", ".") ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>