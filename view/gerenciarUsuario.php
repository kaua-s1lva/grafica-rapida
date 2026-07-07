<?php
include_once "../model/Usuario.inc.php";
include_once "components/cabecalho.inc.php";

if (!isset($_SESSION['usuario']) || !$_SESSION['usuario']->isAdmin()) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$usuarios = $_SESSION['usuarios'] ?? [];
$usuarioLogadoId = $_SESSION['usuario']->getIdUsuario();
?>

<div class="row mb-4 mt-4 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-dark mb-0"><i class="bi bi-people text-primary me-2"></i>Gerenciar Usuários</h1>
        <p class="text-muted mt-1 mb-0">Visualize, edite ou remova clientes e administradores da plataforma.</p>
    </div>
    
    <div class="col-md-4 text-md-end mt-4 mt-md-0">
        <a href="../controller/usuarioController.php?opcao=novo" class="btn btn-primary fw-bold px-4 py-2 rounded-3 shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i> Novo Usuário
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            
            <?php if (empty($usuarios)): ?>
                <div class="p-5 text-center">
                    <i class="bi bi-person-x text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold text-dark">Nenhum usuário encontrado</h4>
                    <p class="text-muted">Não há registros de usuários no banco de dados.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th scope="col" class="ps-4 py-3">ID</th>
                                <th scope="col" class="py-3">Usuário</th>
                                <th scope="col" class="py-3">Contato</th>
                                <th scope="col" class="py-3 text-center">Cargo</th>
                                <th scope="col" class="pe-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user): ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">
                                        #<?= str_pad($user->getIdUsuario(), 4, '0', STR_PAD_LEFT) ?>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">
                                                    <?= $user->getNome() ?>
                                                    <?php if ($user->getIdUsuario() == $usuarioLogadoId): ?>
                                                        <span class="badge bg-success ms-1" style="font-size: 0.65em;">Você</span>
                                                    <?php endif; ?>
                                                </h6>
                                                <span class="text-muted small">CPF: <?= $user->getCpf() ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <span class="d-block small text-dark"><i class="bi bi-envelope me-1 text-muted"></i> <?= $user->getEmail() ?></span>
                                        <?php if (!empty($user->getTelefone())): ?>
                                            <span class="text-muted small"><i class="bi bi-telephone me-1"></i> <?= $user->getTelefone() ?></span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if (strtolower($user->getCargo()) === 'admin'): ?>
                                            <span class="badge bg-dark text-white border border-dark fw-bold px-3 py-2 rounded-pill">
                                                <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-secondary border border-secondary-subtle fw-medium px-3 py-2 rounded-pill">
                                                Cliente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="pe-4 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="../controller/usuarioController.php?opcao=editar&id=<?= $user->getIdUsuario() ?>" class="btn btn-sm btn-outline-primary" title="Editar Usuário">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluirUser<?= $user->getIdUsuario() ?>" title="Excluir Usuário">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalExcluirUser<?= $user->getIdUsuario() ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="modal-title fw-bold text-dark">Excluir Usuário?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-secondary pb-4">
                                                Você tem certeza que deseja excluir o usuário <strong class="text-dark"><?= $user->getNome() ?></strong>?
                                                
                                                <?php if ($user->getIdUsuario() == $usuarioLogadoId): ?>
                                                    <div class="alert alert-danger mt-3 mb-0 small border-0">
                                                        <i class="bi bi-exclamation-octagon-fill me-2"></i><strong>Atenção!</strong> Você está prestes a excluir a conta que está usando atualmente. Ao confirmar, você será desconectado imediatamente.
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0">
                                                <button type="button" class="btn btn-light fw-bold text-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <a href="../controller/usuarioController.php?opcao=excluirAdmin&id=<?= $user->getIdUsuario() ?>" class="btn btn-danger fw-bold px-4">
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
        
        <?php if (!empty($usuarios)): ?>
        <div class="text-end mt-3 text-muted small">
            Total de <strong><?= count($usuarios) ?></strong> usuário(s) na plataforma.
        </div>
        <?php endif; ?>

    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>