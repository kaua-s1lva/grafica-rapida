<?php
include_once "../model/Usuario.inc.php";
include_once "../model/Venda.inc.php";
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
    exit;
}

$encomendas = $_SESSION['minhas_encomendas'] ?? [];
?>

<div class="row mb-4 mt-4">
    <div class="col">
        <h1 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Minhas Encomendas</h1>
        <p class="text-muted mt-1 mb-0">Consulte o histórico de todos os pedidos e serviços contratados por você.</p>
    </div>
</div>

<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            
            <?php if (empty($encomendas)): ?>
                <div class="p-5 text-center">
                    <i class="bi bi-bag-x text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold text-dark">Você ainda não fez nenhuma encomenda</h4>
                    <p class="text-muted mb-4">Explore o nosso catálogo e descubra os serviços de gráfica rápida disponíveis para si.</p>
                    <div>
                        <a href="../controller/servicoController.php?opcao=listarTodos" class="btn btn-primary fw-bold py-2 px-4 rounded-3 shadow-sm">
                            <i class="bi bi-search me-2"></i> Ver Serviços Disponíveis
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th scope="col" class="ps-4 py-3">Nº da Encomenda</th>
                                <th scope="col" class="py-3">Data do Pedido</th>
                                <th scope="col" class="py-3">Forma de Pagamento</th>
                                <th scope="col" class="py-3 text-end">Valor Total</th>
                                <th scope="col" class="pe-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($encomendas as $encomenda): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        #<?= str_pad($encomenda->getIdVenda(), 4, '0', STR_PAD_LEFT) ?>
                                    </td>
                                    
                                    <td class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i> 
                                        <?= date('d/m/Y', $encomenda->getData()) ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-dark border fw-normal">
                                            <i class="bi bi-upc-scan text-primary me-1"></i> Boleto Bancário
                                        </span>
                                    </td>
                                    
                                    <td class="text-end fw-bold text-dark">
                                        R$ <?= number_format($encomenda->getValorTotal(), 2, ",", ".") ?>
                                    </td>
                                    
                                    <td class="pe-4 text-center">
                                        <a href="../controller/vendaController.php?opcao=detalharMinhaVenda&id=<?= $encomenda->getIdVenda() ?>" class="btn btn-sm btn-light border text-primary fw-bold rounded-3 px-3">
                                            <i class="bi bi-search small me-1"></i> Detalhes
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>