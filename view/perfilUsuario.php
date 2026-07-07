<?php
// Inclui a model ANTES de qualquer verificação de sessão
include_once "../model/Usuario.inc.php";
include_once "components/cabecalho.inc.php";

// Proteção: Se não estiver logado, manda para o login
if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<div class="row justify-content-center mb-5">
    <div class="col-lg-8 col-xl-7 mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold text-dark mb-0"><i class="bi bi-person-circle text-primary me-2"></i>Meu Perfil</h1>
                <p class="text-muted mt-1 mb-0">Gerencie suas informações pessoais e endereços.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-4">
            <form action="../controller/usuarioController.php" method="POST">
                <input type="hidden" name="opcao" value="atualizar">
                <input type="hidden" name="idUsuario" value="<?= $usuario->getIdUsuario() ?>">
                
                <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Dados Pessoais</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="nome" class="form-label small text-muted">Nome Completo</label>
                        <input type="text" class="form-control rounded-3" id="nome" name="nome" value="<?= $usuario->getNome() ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cpf" class="form-label small text-muted">CPF <i class="bi bi-lock-fill text-secondary ms-1" title="O CPF não pode ser alterado"></i></label>
                        <input type="text" class="form-control rounded-3 bg-light text-secondary" id="cpf" name="cpf" value="<?= $usuario->getCpf() ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="dataNascimento" class="form-label small text-muted">Data de Nascimento</label>
                        <input type="date" class="form-control rounded-3" id="dataNascimento" name="dataNascimento" value="<?= $usuario->getDataNascimento() ?>" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Contato</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-7">
                        <label for="email" class="form-label small text-muted">E-mail</label>
                        <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= $usuario->getEmail() ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label for="telefone" class="form-label small text-muted">Telefone / Celular</label>
                        <input type="text" class="form-control rounded-3" id="telefone" name="telefone" maxlength="12" value="<?= $usuario->getTelefone() ?? '' ?>" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Endereço de Entrega</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="cep" class="form-label small text-muted">CEP</label>
                        <input type="text" class="form-control rounded-3" id="cep" name="cep" maxlength="8" value="<?= $usuario->getCep() ?? '' ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label for="logradouro" class="form-label small text-muted">Logradouro (Rua, Av, Número, Bairro)</label>
                        <input type="text" class="form-control rounded-3" id="logradouro" name="logradouro" value="<?= $usuario->getLogradouro() ?? '' ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label for="cidade" class="form-label small text-muted">Cidade</label>
                        <input type="text" class="form-control rounded-3" id="cidade" name="cidade" value="<?= $usuario->getCidade() ?? '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label small text-muted">Estado (UF)</label>
                        <input type="text" class="form-control rounded-3 text-uppercase" id="estado" name="estado" maxlength="2" value="<?= $usuario->getEstado() ?? '' ?>" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Segurança</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="senha" class="form-label small text-muted">Senha</label>
                        <input type="password" class="form-control rounded-3" id="senha" name="senha" value="<?= $usuario->getSenha() ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmarSenha" class="form-label small text-muted">Confirmar Senha</label>
                        <input type="password" class="form-control rounded-3" id="confirmarSenha" name="confirmarSenha" value="<?= $usuario->getSenha() ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-3 shadow-sm">
                        <i class="bi bi-floppy-fill me-2"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>

        <div class="card border-danger border-opacity-25 shadow-sm rounded-4 p-4 bg-white mt-4">
            <h5 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Zona de Perigo</h5>
            <p class="text-muted small mb-4">
                Ao excluir sua conta, todos os seus dados pessoais, histórico de encomendas e informações de endereço serão permanentemente apagados do nosso sistema. Esta ação não pode ser desfeita.
            </p>
            <div>
                <button type="button" class="btn btn-outline-danger fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#modalExcluirConta">
                    Excluir Minha Conta
                </button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalExcluirConta" tabindex="-1" aria-labelledby="modalExcluirContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="modalExcluirContaLabel">Você tem certeza?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary pb-4">
                Esta ação é irreversível. Todas as suas informações serão perdidas e você não poderá mais acessar seu histórico de encomendas.
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light fw-bold text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="../controller/usuarioController.php?opcao=excluir" class="btn btn-danger fw-bold px-4">
                    Sim, excluir conta
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>