<?php
include_once "components/cabecalho.inc.php";
?>

<!-- BANNER DE ENTRADA (Hero Section) -->
<section class="bg-primary bg-gradient text-white text-center py-5">
    <div class="container py-5">
        <h1 class="display-5 fw-bold mb-3">Sua Ideia Impressa com Qualidade e Velocidade</h1>
        <div class="row justify-content-center">
            <p class="lead text-white-50 col-lg-8">
                Soluções completas em comunicação visual, brindes personalizados e materiais de escritório para dar vida aos seus projetos.
            </p>
        </div>
    </div>
</section>

<!-- SOBRE A EMPRESA -->
<section class="container py-5 my-4">
    <div class="row align-items-stretch g-5">
        <div class="col-lg-6">
            <h2 class="text-primary fw-bold mb-4">Quem Somos</h2>
            <p class="text-secondary text-justify mb-3">A <strong>Gráfica Rápida</strong> nasceu com o objetivo de revolucionar o mercado de impressões, unindo tecnologia de ponta, atendimento excepcional e prazos recordes. Sabemos que no mundo dos negócios e nos momentos especiais da vida, o tempo e a qualidade andam juntos.</p>
            <p class="text-secondary text-justify mb-3">Nossa equipe é formada por profissionais apaixonados pelo que fazem, dedicados a transformar sua visão em realidade, seja na impressão de materiais para sua empresa ou na personalização de produtos exclusivos.</p>
            <p class="text-secondary text-justify mb-3"><strong>Missão:</strong> Entregar soluções de impressão com excelência e rapidez, facilitando a comunicação visual e o sucesso dos nossos clientes.</p>
            <p class="text-secondary text-justify mb-3"><strong>Visão:</strong> Ser reconhecida como a gráfica referência em inovação e agilidade, expandindo nosso alcance sem perder o atendimento humanizado e a atenção a cada detalhe.</p>
            <p class="text-secondary text-justify mb-0"><strong>Valores:</strong> Qualidade impecável, cumprimento rigoroso de prazos, transparência nas negociações, inovação tecnológica e foco total na satisfação do cliente.</p>
        </div>
        <div class="col-lg-6 d-flex">
            <div class="w-100 rounded-4 shadow-sm overflow-hidden">
                <img src="img/maquina_moderna_Impressão.jpg" 
                     alt="Máquina moderna de impressão" 
                     class="w-100 h-100" 
                     style="object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- VISÃO GERAL DOS SERVIÇOS (Cards do Bootstrap) -->
<section class="bg-white py-5 border-top">
    <div class="container py-4 text-center">
        <h2 class="text-primary fw-bold mb-5">O que nós fazemos</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 text-start">
            <div class="col">
                <div class="card h-100 border-light-subtle p-3 bg-light shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title text-dark fw-bold mb-3">Reproduções</h3>
                        <p class="card-text text-secondary small">Cópias e impressões P&B ou coloridas com variadas opções de papel, tamanho e acabamento para o seu dia a dia.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-light-subtle p-3 bg-light shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title text-dark fw-bold mb-3">Banners e Lonas</h3>
                        <p class="card-text text-secondary small">Comunicação visual de alto impacto em tamanhos pré-definidos com material resistente para ambientes internos e externos.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-light-subtle p-3 bg-light shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title text-dark fw-bold mb-3">Impressões Especiais</h3>
                        <p class="card-text text-secondary small">Cartazes em grandes formatos (A3, A2) com alta resolução, ideais para apresentações, eventos e decoração.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-light-subtle p-3 bg-light shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title text-dark fw-bold mb-3">Brindes Personalizados</h3>
                        <p class="card-text text-secondary small">Canecas exclusivas para presentear ou para fortalecer a marca da sua empresa. Artes feitas sob medida.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-light-subtle p-3 bg-light shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title text-dark fw-bold mb-3">Papelaria Corporativa</h3>
                        <p class="card-text text-secondary small">Cartões de visita e panfletos com cortes e envernizamentos especiais para deixar sua marca sempre em destaque.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "components/rodape.inc.php"; ?>