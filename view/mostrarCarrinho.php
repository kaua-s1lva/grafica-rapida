<?php
include_once "../model/ItemCarrinho.inc.php";
include_once "components/cabecalho.inc.php";

// Verifica se o carrinho está vazio pela sessão ou pelo status da URL
$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$carrinhoVazio = (isset($_GET['status']) && $_GET['status'] == 1) || empty($carrinho);

$valorTotal = 0;
$quantidadeTotal = 0;
$index = 0;
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="fw-bold text-dark"><i class="bi bi-cart3 text-primary me-2"></i>Meu Carrinho</h1>
        <p class="text-muted">Revise os itens da sua encomenda antes de prosseguir com o pagamento.</p>
    </div>
</div>

<?php if ($carrinhoVazio): ?>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                <i class="bi bi-cart-x text-muted mb-3" style="font-size: 4rem;"></i>
                <h3 class="fw-bold text-dark">Seu carrinho está vazio!</h3>
                <p class="text-muted mb-4">Você ainda não adicionou nenhum serviço à sua encomenda.</p>
                <div>
                    <a href="listarTodosServico.php" class="btn btn-primary fw-bold py-2 px-4 rounded-3">
                        Ver nossos serviços
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <?php 
                foreach($carrinho as $item) { 
                ?>
                <div class="row g-0 p-4 border-bottom align-items-center bg-white">
                    <div class="col-md-7 px-3">
                        <h5 class="fw-bold mb-1"><?= $item->getServico()->getNome() ?></h5>
                        <p class="text-muted small mb-2"><?= $item->getServico()->getCategoria() ?></p>
                        <ul class="list-unstyled small text-secondary mb-0 bg-light p-2 rounded">
                            <li><strong>Tamanho:</strong> <?= $item->getServico()->getTamanho() ?></li>
                            <li><strong>Material:</strong> <?= $item->getServico()->getMaterial() ?></li>
                            <li><strong>Cor:</strong> <?= $item->getServico()->getCor() ?></li>
                        </ul>
                    </div>
                    <div class="col-md-3 px-3 mt-3 mt-md-0">
                        <label class="small text-muted mb-1">Quantidade <?= "(" . $item->getServico()->getUnidadeMedida() . ")" ?></label>
                        <div class="input-group input-group-sm">
                            <a href="../controller/carrinhoController.php?opcao=diminuir&index=<?= $index ?>" class="btn btn-outline-secondary px-3" type="button">-</a>
                            <input type="text" class="form-control text-center fw-bold" value="<?= $item->getQuantidade() ?>" readonly>
                            <a href="../controller/carrinhoController.php?opcao=aumentar&index=<?= $index ?>" class="btn btn-outline-secondary px-3" type="button">+</a>
                        </div>
                    </div>
                    <div class="col-md-2 text-md-end mt-3 mt-md-0">
                        <span class="d-block fw-bold text-primary fs-5">R$ <?= number_format($item->getValorItem(), 2, ",", ".") ?></span>
                        <span class="small text-muted d-block mb-1">R$ <?= number_format($item->getServico()->getValor(), 2, ",", ".") . " / " . $item->getServico()->getUnidadeMedida() ?></span>
                        <a href="../controller/carrinhoController.php?opcao=remover&index=<?= $index ?>" class="btn btn-link text-danger p-0 small text-decoration-none">
                            <i class="bi bi-trash3"></i> Remover
                        </a>
                    </div>
                </div>
                <?php 
                    $valorTotal += $item->getValorItem();
                    $quantidadeTotal += $item->getQuantidade();
                    $index++;
                } 
                ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h4 class="fw-bold mb-4">Resumo do Pedido</h4>

                <div class="d-flex justify-content-between mb-2 text-muted">
                    <span>Subtotal (<?= $quantidadeTotal . ' ' . ($quantidadeTotal > 1 ? "itens" : "item"); ?>)</span>
                    <span>R$ <?= number_format($valorTotal, 2, ",", ".") ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Taxa de Sistema</span>
                    <span class="text-success fw-bold">Grátis</span>
                </div>

                <hr class="my-3 text-light-subtle">

                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total a Pagar</span>
                    <span class="fw-bold fs-4 text-primary">R$ <?= number_format($valorTotal, 2, ",", ".") ?></span>
                </div>

                <div class="alert alert-info small border-0 bg-info bg-opacity-10 mb-4 rounded-3 text-dark">
                    <i class="bi bi-info-circle-fill me-2 text-info"></i>
                    Após confirmar a encomenda, será emitido um <strong>Boleto Bancário</strong> com vencimento para <strong>3 dias úteis</strong>.
                </div>

                <a href="../controller/carrinhoController.php?opcao=comprar&total=<?= $valorTotal ?>" class="btn btn-primary w-100 fw-bold py-3 mb-2 rounded-3">
                    <i class="bi bi-upc-scan me-2"></i> Finalizar Encomenda
                </a>

                <a href="listarTodosServico.php" class="btn btn-outline-secondary w-100 fw-bold py-2 rounded-3">
                    Adicionar mais serviços
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
include_once "components/rodape.inc.php";
?>