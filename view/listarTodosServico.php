<?php 

include_once "../model/Servico.inc.php";
include_once "components/cabecalho.inc.php"; 

$servicos = $_SESSION['servicos'] ?? '';
$categorias = $_SESSION['categorias'] ?? '';

$buscaAtual = $_SESSION['filtro_busca'] ?? '';
$categoriaAtual = $_SESSION['filtro_categoria'] ?? '';

?>

    <section class="bg-white py-4 border-bottom shadow-sm mb-5">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h1 class="fw-bold text-dark mb-0">Nossos Serviços</h1>
                    <p class="text-muted mb-0">Encontre o serviço ideal para sua necessidade.</p>
                </div>
            </div>

            <!-- Barra de Busca (Requisito do Trabalho) -->
            <form action="../controller/servicoController.php" method="GET" class="row g-3 mb-4">
                <input type="hidden" name="opcao" value="listarTodos">
                <input type="hidden" name="acao" value="<?= isset($_GET['acao']) ? htmlspecialchars($_GET['acao']) : '' ?>">

                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="busca" class="form-control" placeholder="Buscar por nome ou ID..." value="<?= htmlspecialchars($buscaAtual) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="categoria" class="form-select">
                        <option value="" <?= empty($categoriaAtual) ? 'selected' : '' ?>>Todas as Categorias</option>
                        <?php foreach($categorias as $categoria) { ?>
                        <option value="<?= $categoria ?>" <?= $categoriaAtual == $categoria ? 'selected' : '' ?>><?= $categoria ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- -->
    <main class="container mb-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

            <?php 
            foreach($servicos as $servico) { 
                $categoria = $servico->getCategoria();
                $badgeClass = 'bg-primary text-white';

                switch ($categoria) {
                    case 'Papelaria Corporativa':
                        $badgeClass = 'bg-info text-dark';
                        break;
                    case 'Banners e Lonas':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'Brindes':
                        $badgeClass = 'bg-success text-white';
                        break;
                    case 'Reproduções':
                        $badgeClass = 'bg-secondary text-white';
                        break;
                    case 'Impressões Especiais':
                        $badgeClass = 'bg-danger text-white';
                        break;
                    case 'Acabamentos':
                        $badgeClass = 'bg-dark text-white';
                        break;
                }
            ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge <?= $badgeClass ?> text-dark rounded-pill mb-2"><?= $servico->getCategoria() ?></span>
                            <span class="text-muted small">#<?= $servico->getCodigo() ?></span>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-3"><?= $servico->getNome() ?></h5>
                        <p class="card-text text-secondary small mb-4"><?= $servico->getDescricao() ?></p>
                        
                        <h3 class="text-primary fw-bold mb-3">R$ <?= number_format($servico->getValor(), 2, ',', '.') ?> <span class="fs-6 text-muted fw-normal">/ <?= $servico->getUnidadeMedida() ?></span></h3>
                        
                        <!-- Lista de especificações baseada no banco -->
                        <ul class="list-unstyled small text-muted bg-light p-3 rounded-3 mb-0">
                            <li class="mb-2"><i class="bi bi-arrows-fullscreen me-2 text-primary"></i> <strong>Tamanho:</strong> <?= $servico->getTamanho() ?></li>
                            <li class="mb-2"><i class="bi bi-layers-fill me-2 text-primary"></i> <strong>Material:</strong> <?= $servico->getMaterial() ?></li>
                            <li class="mb-2"><i class="bi bi-box-seam me-2 text-primary"></i> <strong>Tipo:</strong> <?= $servico->getTipoMaterial() ?></li>
                            <li><i class="bi bi-palette-fill me-2 text-primary"></i> <strong>Cor:</strong> <?= $servico->getCor() ?></li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-4 px-4">
                        <a href="../controller/carrinhoController.php?opcao=inserir&id=<?= $servico->getIdServico() ?>" class="btn btn-outline-primary w-100 fw-bold rounded-3 py-2">
                            Fazer Encomenda
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </main>

<?php include_once "components/rodape.inc.php"; ?>