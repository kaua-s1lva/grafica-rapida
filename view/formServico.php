<?php
include_once "../model/Usuario.inc.php";
include_once "../model/Servico.inc.php";
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']->isAdmin()) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$servico = $_SESSION['servico'] ?? null;
$isEdit = ($servico !== null);

$tituloPagina = $isEdit ? "Editar Serviço" : "Novo Serviço";
$iconePagina = $isEdit ? "bi-pencil-square" : "bi-plus-circle";
$textoBotao = $isEdit ? "Salvar Alterações" : "Cadastrar Serviço";
?>

<div class="row justify-content-center mb-5">
    <div class="col-lg-10 col-xl-9 mt-4">
        
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                
                <h1 class="fw-bold text-dark mb-0"><i class="bi <?= $iconePagina ?> text-primary me-2"></i><?= $tituloPagina ?></h1>
            </div>
            <a href="../controller/servicoController.php?opcao=listarTodos&acao=gerenciar" class="btn btn-outline-secondary fw-bold rounded-3 d-none d-sm-block">
                <i class="bi bi-arrow-left me-2"></i> Voltar
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-4">
            <form action="../controller/servicoController.php" method="POST">
                
                <input type="hidden" name="opcao" value="salvar">
                <input type="hidden" name="idServico" value="<?= $isEdit ? $servico->getIdServico() : '0' ?>">
                
                <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Informações Básicas</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label for="nome" class="form-label small text-muted">Nome do Serviço <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="nome" name="nome" 
                               value="<?= $isEdit ? $servico->getNome() : '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label small text-muted">Categoria <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="categoria" name="categoria" 
                               placeholder="Ex: Papelaria, Banners" 
                               value="<?= $isEdit ? $servico->getCategoria() : '' ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="descricao" class="form-label small text-muted">Descrição do Serviço</label>
                        <textarea class="form-control rounded-3" id="descricao" name="descricao" rows="3"><?= $isEdit ? $servico->getDescricao() : '' ?></textarea>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Preço e Comercialização</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="valor" class="form-label small text-muted">Valor Base <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary">R$</span>
                            <input type="text" class="form-control" id="valor" name="valor" placeholder="0,00"
                                value="<?= $isEdit ? number_format($servico->getValor(), 2, ',', '.') : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="unidadeMedida" class="form-label small text-muted">Unidade de Medida <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="unidadeMedida" name="unidadeMedida" 
                               placeholder="Ex: un, m², centos" 
                               value="<?= $isEdit ? $servico->getUnidadeMedida() : '' ?>" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Detalhes Técnicos (Opcionais)</h5>
                <div class="row g-3 mb-5">
                    <div class="col-md-6">
                        <label for="tamanho" class="form-label small text-muted">Tamanho</label>
                        <input type="text" class="form-control rounded-3" id="tamanho" name="tamanho" 
                               placeholder="Ex: 9x5 cm, 90x120 cm" 
                               value="<?= $isEdit ? $servico->getTamanho() : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="cor" class="form-label small text-muted">Padrão de Cor</label>
                        <input type="text" class="form-control rounded-3" id="cor" name="cor" 
                               placeholder="Ex: 4x4 (Colorido F/V)" 
                               value="<?= $isEdit ? $servico->getCor() : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="material" class="form-label small text-muted">Material</label>
                        <input type="text" class="form-control rounded-3" id="material" name="material" 
                               placeholder="Ex: Papel Couchê 300g, Lona 440g" 
                               value="<?= $isEdit ? $servico->getMaterial() : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="tipoMaterial" class="form-label small text-muted">Acabamento / Tipo</label>
                        <input type="text" class="form-control rounded-3" id="tipoMaterial" name="tipoMaterial" 
                               placeholder="Ex: Brilho, Fosco, Bastão" 
                               value="<?= $isEdit ? $servico->getTipoMaterial() : '' ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="../controller/servicoController.php?opcao=listarTodos&acao=gerenciar" class="btn btn-light fw-bold px-4 py-2 text-secondary rounded-3 border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold px-5 py-2 rounded-3 shadow-sm">
                        <i class="bi bi-floppy-fill me-2"></i> <?= $textoBotao ?>
                    </button>
                </div>
                
            </form>
        </div>

    </div>
</div>

<script>
document.getElementById('valor').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); 
    
    if (value === '') {
        e.target.value = '';
        return;
    }
    
    value = (parseInt(value) / 100).toFixed(2) + ''; 
    value = value.replace(".", ",");
    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    
    e.target.value = value;
});
</script>

<?php
include_once "components/rodape.inc.php";
?>