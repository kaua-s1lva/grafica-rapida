<?php
include_once "../model/Usuario.inc.php";
include_once "components/cabecalho.inc.php";

$isAdmin = false;
if (isset($_SESSION['usuario']) && $_SESSION['usuario']->isAdmin()) {
    $isAdmin = true;
}

$usuarioEdit = $_SESSION['usuario_editar_admin'] ?? null;
$isEdit = ($usuarioEdit !== null);

if ($isEdit) {
    $tituloPagina = "Editar Usuário";
    $descricaoPagina = "Altere as informações do usuário selecionado.";
    $iconePagina = "bi-pencil-square";
    $textoBotao = "Salvar Alterações";
    $opcaoController = "atualizar";
} else if ($isAdmin) {
    $tituloPagina = "Novo Usuário";
    $descricaoPagina = "Cadastre um novo cliente ou administrador no sistema.";
    $iconePagina = "bi-person-plus-fill";
    $textoBotao = "Cadastrar Usuário";
    $opcaoController = "cadastrar";
} else {
    $tituloPagina = "Criar Conta";
    $descricaoPagina = "Preencha todos os dados abaixo para se cadastrar e realizar suas encomendas.";
    $iconePagina = "bi-person-vcard";
    $textoBotao = "Finalizar Cadastro";
    $opcaoController = "cadastrar";
}
?>

<div class="row justify-content-center mb-5">
    <div class="col-lg-8 col-xl-7 mt-4">
        
        <div class="text-center mb-4">
            <h1 class="fw-bold text-dark"><i class="bi <?= $iconePagina ?> text-primary me-2"></i><?= $tituloPagina ?></h1>
            <p class="text-muted"><?= $descricaoPagina ?></p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <form action="../controller/usuarioController.php" method="POST">
                <input type="hidden" name="opcao" value="<?= $opcaoController ?>">
                <input type="hidden" name="idUsuario" value="<?= $isEdit ? $usuarioEdit->getIdUsuario() : '0' ?>">
                
                <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Dados Pessoais</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="nome" class="form-label small text-muted">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="nome" name="nome" 
                               value="<?= $isEdit ? $usuarioEdit->getNome() : '' ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cpf" class="form-label small text-muted">CPF <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="cpf" name="cpf" maxlength="11" placeholder="Somente números" 
                               value="<?= $isEdit ? $usuarioEdit->getCpf() : '' ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dataNascimento" class="form-label small text-muted">Data de Nascimento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control rounded-3" id="dataNascimento" name="dataNascimento" 
                               value="<?= $isEdit ? $usuarioEdit->getDataNascimento() : '' ?>" required>
                    </div>
                    
                    <?php if ($isAdmin) { ?>
                    <div class="col-md-6">
                        <label for="cargo" class="form-label small text-muted">Cargo <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3" id="cargo" name="cargo" required>
                            <option value="" <?= !$isEdit ? 'selected' : '' ?> disabled>Selecione uma opção</option>
                            <option value="cliente" <?= ($isEdit && strtolower($usuarioEdit->getCargo()) === 'cliente') ? 'selected' : '' ?>>Cliente</option>
                            <option value="admin" <?= ($isEdit && strtolower($usuarioEdit->getCargo()) === 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Contato</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-7">
                        <label for="email" class="form-label small text-muted">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="exemplo@email.com" 
                               value="<?= $isEdit ? $usuarioEdit->getEmail() : '' ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label for="telefone" class="form-label small text-muted">Telefone / Celular <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="telefone" name="telefone" maxlength="12" placeholder="DDD999999999" 
                               value="<?= $isEdit ? ($usuarioEdit->getTelefone() ?? '') : '' ?>" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Endereço de Entrega</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="cep" class="form-label small text-muted">CEP</label>
                        <input type="text" class="form-control rounded-3" id="cep" name="cep" maxlength="8" placeholder="Somente números" 
                               value="<?= $isEdit ? ($usuarioEdit->getCep() ?? '') : '' ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="logradouro" class="form-label small text-muted">Logradouro (Rua, Av, Número, Bairro)</label>
                        <input type="text" class="form-control rounded-3" id="logradouro" name="logradouro" 
                               value="<?= $isEdit ? ($usuarioEdit->getLogradouro() ?? '') : '' ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="cidade" class="form-label small text-muted">Cidade</label>
                        <input type="text" class="form-control rounded-3" id="cidade" name="cidade" 
                               value="<?= $isEdit ? ($usuarioEdit->getCidade() ?? '') : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label small text-muted">Estado (UF)</label>
                        <input type="text" class="form-control rounded-3 text-uppercase" id="estado" name="estado" maxlength="2" placeholder="Ex: ES" 
                               value="<?= $isEdit ? ($usuarioEdit->getEstado() ?? '') : '' ?>">
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-2 text-primary border-bottom pb-2">Segurança</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="senha" class="form-label small text-muted">Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control rounded-3" id="senha" name="senha" value="<?= $isEdit ? ($usuarioEdit->getSenha() ?? '') : '' ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmarSenha" class="form-label small text-muted">Confirmar Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control rounded-3" id="confirmarSenha" name="confirmarSenha" value="<?= $isEdit ? ($usuarioEdit->getSenha() ?? '') : '' ?>" required>
                    </div>
                </div>

                <div class="d-grid mt-5 gap-2 d-md-flex justify-content-md-end">
                    <?php if ($isAdmin) { ?>
                        <a href="../controller/usuarioController.php?opcao=listarTodos" class="btn btn-light fw-bold px-4 py-3 text-secondary rounded-3 border w-100 w-md-auto">
                            Cancelar
                        </a>
                    <?php } ?>
                    
                    <button type="submit" class="btn btn-primary py-3 px-5 fw-bold rounded-3 fs-5 shadow-sm w-100 w-md-auto">
                        <i class="bi bi-floppy-fill me-2"></i> <?= $textoBotao ?>
                    </button>
                </div>
                
                <?php if (!$isAdmin) { ?>
                <div class="text-center mt-4">
                    <p class="text-muted small">Já possui uma conta? <a href="loginUsuario.php" class="text-primary fw-bold text-decoration-none">Faça login aqui</a></p>
                </div>
                <?php } ?>

            </form>
        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>