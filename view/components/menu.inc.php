<?php require_once "../model/Usuario.inc.php"; ?>

<style>
    .navbar-custom .nav-item .nav-link {
        transition: all 0.2s ease-in-out;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }
    .navbar-custom .nav-item .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.08);
        color: #0d6efd !important;
    }

    .admin-menu-btn {
        background-color: #212529 !important;
        color: #ffffff !important;
        border-radius: 0.5rem;
        transition: background-color 0.2s;
    }
    .admin-menu-btn:hover {
        background-color: #343a40 !important;
        color: #ffffff !important;
    }

    .user-menu-btn {
        background-color: #f8f9fa;
        color: #0d6efd !important;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }
    .user-menu-btn:hover {
        background-color: #e9ecef;
    }

    .dropdown-custom {
        border-radius: 0.75rem;
        padding: 0.5rem;
    }
    .dropdown-custom .dropdown-item {
        border-radius: 0.4rem;
        transition: all 0.2s ease;
        padding: 0.5rem 1rem;
        font-weight: 500;
        color: #495057;
    }
    .dropdown-custom .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
        transform: translateX(3px);
    }
</style>

<header class="mb-4" style="position: relative; z-index: 1050;">
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom border-bottom sticky-top py-3">
        <div class="container">
            
            <a class="navbar-brand d-flex align-items-center text-primary fw-bold fs-4" href="index.php">
                <svg class="me-2 text-primary" fill="currentColor" width="40" height="40" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z" />
                </svg>
                Gráfica Rápida
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 fw-medium">
                    
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="index.php">A Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../controller/servicoController.php?opcao=listarTodos">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="faleConosco.php">Fale Conosco</a>
                    </li>
                    
                    <?php if (!isset($_SESSION['usuario'])) { ?>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link text-dark" href="cadastrarUsuario.php">Cadastre-se</a>
                        </li>
                        <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                            <a href="loginUsuario.php" class="btn btn-primary px-4 fw-bold rounded-3 shadow-sm">Login</a>
                        </li>
                    <?php } else { ?>
                    
                        <?php if ($_SESSION['usuario']->isAdmin()) { ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle admin-menu-btn px-3 fw-bold shadow-sm" href="#" id="adminMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-shield-lock-fill me-1 text-warning"></i> Administração
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 dropdown-custom" aria-labelledby="adminMenu">
                                <li>
                                    <a class="dropdown-item" href="../controller/usuarioController.php?opcao=listarTodos">
                                        <i class="bi bi-people text-secondary me-2"></i> Gerenciar Usuários
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../controller/servicoController.php?opcao=listarTodos&acao=gerenciar">
                                        <i class="bi bi-tools text-secondary me-2"></i> Gerenciar Serviços
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../controller/vendaController.php?opcao=listarTodas">
                                        <i class="bi bi-receipt text-secondary me-2"></i> Todas as Vendas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle user-menu-btn px-3 fw-bold" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?= $_SESSION['usuario']->getNome() ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 dropdown-custom" aria-labelledby="userMenu">
                                <li>
                                    <a class="dropdown-item" href="mostrarCarrinho.php">
                                        <i class="bi bi-cart text-secondary me-2"></i> Carrinho
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="perfilUsuario.php">
                                        <i class="bi bi-person text-secondary me-2"></i> Meu Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../controller/vendaController.php?opcao=listarMinhasVendas">
                                        <i class="bi bi-box-seam text-secondary me-2"></i> Minhas Encomendas
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="../controller/usuarioController.php?opcao=sair">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair do Sistema
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php } ?>
                </ul>
            </div>
            
        </div>
    </nav>
</header>