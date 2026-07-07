<?php

include_once "../model/Usuario.inc.php";
include_once "components/cabecalho.inc.php";
?>

<div class="row mb-4 mt-4">
    <div class="col-12">
        <div class="text-center mb-5 mt-3">
            <h1 class="fw-bold text-dark"><i class="bi bi-chat-dots-fill text-primary me-2"></i>Fale Conosco</h1>
            <p class="text-muted fs-5">Dúvidas, orçamentos ou sugestões? Estamos prontos para ajudar!</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white p-4 p-md-5" style="background: linear-gradient(145deg, #0d6efd, #0b5ed7);">
            <h4 class="fw-bold mb-4">Informações de Contato</h4>
            <p class="mb-4 opacity-75 small">Preencha o formulário ao lado e nossa equipe retornará o mais breve possível, ou entre em contato direto pelos canais abaixo.</p>
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-geo-alt-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Endereço</h6>
                    <span class="small opacity-75">Av. Principal, 1000 - Centro<br>Sua Cidade - UF, 00000-000</span>
                </div>
            </div>
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-telephone-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Telefone / WhatsApp</h6>
                    <span class="small opacity-75">(00) 99999-0000</span>
                </div>
            </div>
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-envelope-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">E-mail</h6>
                    <span class="small opacity-75">contato@graficarapida.com.br</span>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-clock-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Atendimento</h6>
                    <span class="small opacity-75">Seg. a Sex. das 08h às 18h</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
            <h4 class="fw-bold text-dark mb-4">Envie uma mensagem</h4>
            
            <form action="#" method="POST">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label small text-muted fw-medium">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="nome" name="nome" placeholder="Digite seu nome" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label small text-muted fw-medium">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg rounded-3 fs-6" id="email" name="email" placeholder="exemplo@email.com" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="assunto" class="form-label small text-muted fw-medium">Assunto <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg rounded-3 fs-6" id="assunto" name="assunto" required>
                            <option value="" disabled selected>Selecione um assunto</option>
                            <option value="orcamento">Solicitar Orçamento</option>
                            <option value="duvida">Dúvida sobre Serviço</option>
                            <option value="reclamacao">Reclamação</option>
                            <option value="outro">Outro assunto</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="mensagem" class="form-label small text-muted fw-medium">Sua Mensagem <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3" id="mensagem" name="mensagem" rows="5" placeholder="Como podemos ajudar?" required></textarea>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-3 rounded-3 shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Enviar Mensagem
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php
include_once "components/rodape.inc.php";
?>