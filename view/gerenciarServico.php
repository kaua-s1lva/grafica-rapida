<?php
include_once "../model/Usuario.inc.php";
include_once "../model/Servico.inc.php";
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']->isAdmin()) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$servicos = $_SESSION['servicos'] ?? [];
?>

<div class="row mb-4 mt-4 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-dark mb-0"><i class="bi bi-tools text-primary me-2"></i>Gerenciar Serviços</h1>
        <p class="text-muted mt-1 mb-0">Adicione, edite ou remova os serviços oferecidos no catálogo.</p>
    </div>
    
    <div class="col-md-4 text-md-end mt-4 mt-md-0">
        <a href="formServico.php" class="btn btn-primary fw-bold px-4 py-2 rounded-3 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Novo Serviço
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            
            <?php if (empty($servicos)): ?>
                <div class="p-5 text-center">
                    <i class="bi bi-box-seam text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold text-dark">Nenhum serviço cadastrado</h4>
                    <p class="text-muted">Você ainda não possui serviços disponíveis para venda.</p>
                    <a href="../controller/servicoController.php?opcao=novo" class="btn btn-outline-primary fw-bold mt-2">
                        Cadastrar Primeiro Serviço
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th scope="col" class="ps-4 py-3">ID</th>
                                <th scope="col" class="py-3">Serviço</th>
                                <th scope="col" class="py-3">Categoria</th>
                                <th scope="col" class="py-3 text-end">Valor Base</th>
                                <th scope="col" class="pe-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($servicos as $servico): ?>
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        #<?= $servico->getCodigo() ?>
                                    </td>
                                    
                                    <td>
                                        <h6 class="fw-bold mb-0 text-dark"><?= $servico->getNome() ?></h6>
                                        <span class="text-muted small">
                                            <?= $servico->getTamanho() ? $servico->getTamanho() . ' | ' : '' ?>
                                            <?= $servico->getMaterial() ?? 'Material Padrão' ?>
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-secondary border border-secondary-subtle fw-normal">
                                            <?= $servico->getCategoria() ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-end">
                                        <span class="fw-bold text-success d-block">
                                            R$ <?= number_format($servico->getValor(), 2, ",", ".") ?>
                                        </span>
                                        <span class="text-muted small">
                                            por <?= $servico->getUnidadeMedida() ?>
                                        </span>
                                    </td>
                                    
                                    <td class="pe-4 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="../controller/servicoController.php?opcao=editar&id=<?= $servico->getIdServico() ?>" class="btn btn-sm btn-outline-primary" title="Editar Serviço">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluirServico<?= $servico->getIdServico() ?>" title="Excluir Serviço">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalExcluirServico<?= $servico->getIdServico() ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="modal-title fw-bold text-dark">Excluir Serviço?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-secondary pb-4">
                                                Você tem certeza que deseja excluir o serviço <strong class="text-dark"><?= $servico->getNome() ?></strong>?<br>
                                                <span class="small text-danger">Atenção: Se este serviço estiver vinculado a pedidos antigos, a exclusão afetará o histórico de vendas desses pedidos.</span>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0">
                                                <button type="button" class="btn btn-light fw-bold text-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <a href="../controller/servicoController.php?opcao=excluir&id=<?= $servico->getIdServico() ?>" class="btn btn-danger fw-bold px-4">
                                                    Sim, excluir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
        
        <?php if (!empty($servicos)): ?>
        <div class="text-end mt-3 text-muted small">
            Total de <strong><?= count($servicos) ?></strong> serviço(s) no catálogo.
        </div>
        <?php endif; ?>

    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>