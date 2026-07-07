<?php include_once "components/cabecalho.inc.php"; ?>

    <main class="d-flex align-items-center justify-content-center w-100 py-4" style="min-height: 75vh;">
        <div class="w-100" style="max-width: 400px;">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5 bg-white">
                
                <div class="text-center mb-4">
                    <a href="index.html" class="text-decoration-none d-inline-flex align-items-center justify-content-center text-primary fw-bold fs-3 mb-3">
                        <i class="bi bi-printer-fill me-2"></i> Gráfica Rápida
                    </a>
                    <h2 class="h5 fw-bold text-dark mb-0">Entrar no Sistema</h2>
                </div>
                
                <?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
                    <div class="alert alert-danger alert-dismissible fade show small rounded-3 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>E-mail ou senha incorretos. Tente novamente.</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="../controller/usuarioController.php" method="POST">
                    
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-medium small text-dark">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control p-2" required placeholder="Digite seu e-mail">
                    </div>

                    <div class="mb-4 text-start">
                        <label for="senha" class="form-label fw-medium small text-dark">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control p-2" required placeholder="Digite sua senha">
                    </div>

                    <input type="hidden" name="opcao" value="autenticar">

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm">
                        Acessar <i class="bi bi-box-arrow-in-right ms-1"></i>
                    </button>

                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <span class="text-muted small">Ainda não tem uma conta?</span> 
                    <br>
                    <a href="cadastrarUsuario.php" class="text-primary text-decoration-none fw-bold small">Cadastre-se aqui</a>
                </div>
                
            </div>
        </div>
    </main>

<?php include_once "components/rodape.inc.php"; ?>