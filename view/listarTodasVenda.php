<?php
include_once "../model/Usuario.inc.php";
include_once "../model/Venda.inc.php"; 
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']->isAdmin()) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$vendas = $_SESSION['vendas'] ?? [];

$dataInicioAtual = $_SESSION['filtro_data_inicio'] ?? '';
$dataFimAtual = $_SESSION['filtro_data_fim'] ?? '';
?>

<div class="row mb-4 mt-4">
    <div class="col-md-8">
        <h1 class="fw-bold text-dark"><i class="bi bi-receipt text-primary me-2"></i>Gerenciar Vendas</h1>
        <p class="text-muted">Acompanhe todas as encomendas realizadas pelos clientes na plataforma.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex align-items-center justify-content-md-end">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-bold rounded-3 shadow-sm">
            <i class="bi bi-printer me-2"></i> Imprimir Relatório
        </button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <form action="../controller/vendaController.php" method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="opcao" value="listarTodas">
                
                <div class="col-md-4 col-lg-3">
                    <label for="dataInicio" class="form-label small fw-bold text-muted mb-1">Data Inicial</label>
                    <input type="date" class="form-control rounded-3" id="dataInicio" name="dataInicio" value="<?= htmlspecialchars($dataInicioAtual) ?>">
                </div>
                
                <div class="col-md-4 col-lg-3">
                    <label for="dataFim" class="form-label small fw-bold text-muted mb-1">Data Final</label>
                    <input type="date" class="form-control rounded-3" id="dataFim" name="dataFim" value="<?= htmlspecialchars($dataFimAtual) ?>">
                </div>
                
                <div class="col-md-4 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold rounded-3 flex-grow-1">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    <?php if (!empty($dataInicioAtual) || !empty($dataFimAtual)): ?>
                        <a href="../controller/vendaController.php?opcao=listarTodas&limpar=1" class="btn btn-light border text-secondary rounded-3" title="Limpar Filtro">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            
            <?php if (empty($vendas)): ?>
                <div class="p-5 text-center">
                    <i class="bi bi-inbox text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold text-dark">Nenhuma venda encontrada</h4>
                    <p class="text-muted">Não há registros para o período selecionado ou o sistema está vazio.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th scope="col" class="ps-4 py-3">Nº Pedido</th>
                                <th scope="col" class="py-3">Data</th>
                                <th scope="col" class="py-3">Cliente</th>
                                <th scope="col" class="py-3">Valor Total</th>
                                <th scope="col" class="pe-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendas as $venda): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        #<?= str_pad($venda->getIdVenda(), 4, '0', STR_PAD_LEFT) ?>
                                    </td>
                                    
                                    <td class="text-muted">
                                        <?= date('d/m/Y', $venda->getData()) ?>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-medium text-dark">
                                            <?= $venda->getUsuario()->getNome() ?>
                                        </span>
                                    </td>
                                    
                                    <td class="fw-bold text-success">
                                        R$ <?= number_format($venda->getValorTotal(), 2, ",", ".") ?>
                                    </td>
                                    
                                    <td class="pe-4 text-center">
                                        <a href="../controller/vendaController.php?opcao=detalhar&id=<?= $venda->getIdVenda() ?>" class="btn btn-sm btn-light border text-primary fw-bold rounded-3">
                                            <i class="bi bi-eye"></i> Detalhes
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
        
        <?php if (!empty($vendas)): ?>
        <div class="text-end mt-3 text-muted small">
            Mostrando <strong><?= count($vendas) ?></strong> registro(s) encontrado(s).
        </div>
        <?php endif; ?>

    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>