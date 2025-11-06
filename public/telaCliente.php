<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleCadProduto.css">
    <link rel="stylesheet" href="css/hidden.css">
    <title> Perfil - TechFit</title>

</head>
<body>
    <!-- Header -->
    <?php
        require_once '../src/views/headerUser.php'
    ?>

    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php
        require_once '../src/views/sidebars.php';
        ?>

        <!-- Sessão Visão Geral -->
        <main class="main-content">
            <div id="geral"class="hidden">
                <div class="content-header">
                    <h1 class="page-title">Seu Perfil</h1>
                    <p class="page-subtitle">Gerencie suas informações aqui</p>
                </div>

                <div class="product-form-container">
                    <form id="productForm">
                        <!-- Informações Básicas -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informações Básicas
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="clientName">Nome:</label>
                                    <p id="nome-cliente">Nome do Cliente</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientYear">Idade:</label>
                                    <p id="idade-cliente">Idade</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientOld">Membro desde:</label>
                                    <p id="membro-cliente">Data de assinatura</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPlan">Plano:</label>
                                    <p id="Plano-cliente">Tipo do Plano do Cliente</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detalhes Exercícios -->
                        <div class="exercise-details container px-4 py-5" id="custom-cards">
                            <h3 class="section-title pb-2 border-bottom">
                                <i class="fas fa-dumbbell me-2"></i>
                                Detalhes dos Exercícios
                            </h3>c  

                            <div class="row justify-content-center text-center mb-4">
                                <?php
                                $dias = [
                                    ['nome' => 'Segunda-feira', 'img' => 'img/dias/segunda.png'],
                                    ['nome' => 'Terça-feira', 'img' => 'img/dias/terca.png'],
                                    ['nome' => 'Quarta-feira', 'img' => 'img/dias/quarta.png'],
                                    ['nome' => 'Quinta-feira', 'img' => 'img/dias/quinta.png'],
                                    ['nome' => 'Sexta-feira', 'img' => 'img/dias/sexta.png'],
                                    ['nome' => 'Sábado', 'img' => 'img/dias/sabado.png'],
                                    ['nome' => 'Domingo', 'img' => 'img/dias/domingo.png'],
                                ];
                                foreach ($dias as $dia): ?>
                                    <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex flex-column align-items-center dia-semana" 
                                         onclick="atualizarTitulo('<?= $dia['nome'] ?>')">
                                        <img src="<?= $dia['img'] ?>" alt="<?= $dia['nome'] ?>" class="rounded-circle shadow" width="100" height="100" style="object-fit:cover; background:#f8f9fa;">
                                        <h5 class="fw-normal mt-3"><?= $dia['nome'] ?></h5>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <h3 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                <span id="titulo-treino">Treinos da Semana</span>
                            </h3>

                            <script>
                                function atualizarTitulo(dia) {
                                    document.getElementById('titulo-treino').textContent = 'Treinos de ' + dia;
                                }
                            </script>
                            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                                  <!-- Card 1 -->            
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">ABS</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://github.com/twbs.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>JORGE ARMADO</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>06:00 - 06:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Peito</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>MARIA SILVA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>07:00 - 07:45</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Costas</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>PAULO SOUZA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>08:00 - 08:50</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Pernas</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>ANA LIMA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>09:00 - 09:50</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Bíceps</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/50.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>CARLOS MELO</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>10:00 - 10:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card 6 -->
                    <div class="col">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('');">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Tríceps</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/women/55.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>FERNANDA DIAS</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>11:00 - 11:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                                <!-- Additional cards can be added here -->

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sessão Plano -->
        <section id="plano" class="plans container py-5 hidden">
            <div class="container py-3">
            <div class="content-header">
                <h1 class="page-title">Nossos Planos</h1>
                <p class="page-subtitle">Escolha o plano que melhor se adapta a você</p>
            </div>
            <div class="product-form-container">
                <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4 fw-normal text-body-emphasis">Planos de Academia</h1>
                    <p class="fs-5 text-body-secondary">
                    Encontre o plano ideal para alcançar seus objetivos de fitness com nossa variedade de opções.
                    </p>
                </div>

                <main>
                    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Plano Básico</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$20 <small class="text-body-secondary fw-light">/mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                            <li>Acesso a todas as máquinas</li>
                            <li>1 aula de grupo por semana</li>
                            <li>Suporte online</li>
                            </ul>
                            <button type="button" class="w-100 btn btn-lg btn-outline-primary">Inscreva-se</button>
                        </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Plano Avançado</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$40 <small class="text-body-secondary fw-light">/mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                            <li>Acesso ilimitado a todas as áreas</li>
                            <li>3 aulas de grupo por semana</li>
                            <li>Treinamento personalizado</li>
                            </ul>
                            <button type="button" class="w-100 btn btn-lg btn-primary">Comece agora</button>
                        </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-primary">
                        <div class="card-header py-3 text-bg-primary border-primary">
                            <h4 class="my-0 fw-normal">Plano Premium</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$60 <small class="text-body-secondary fw-light">/mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                            <li>Acesso total 24/7</li>
                            <li>Aulas ilimitadas de grupo</li>
                            <li>Consultoria nutricional</li>
                            <li>Treinamento pessoal ilimitado</li>
                            </ul>
                            <button type="button" class="w-100 btn btn-lg btn-primary">Entre em contato</button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <h2 class="display-6 text-center mb-4">Compare os planos</h2>

                    <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th style="width: 34%;"></th>
                                <th style="width: 22%;">Básico</th>
                                <th style="width: 22%;">Avançado</th>
                                <th style="width: 22%;">Premium</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-start">Acesso a máquinas</th>
                                <td>Limitado</td>
                                <td>Total</td>
                                <td>Total 24/7</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Aulas de grupo</th>
                                <td>1 por semana</td>
                                <td>3 por semana</td>
                                <td>Ilimitadas</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Treinamento personalizado</th>
                                <td>Não incluso</td>
                                <td>2x por mês</td>
                                <td>Ilimitado</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Consultoria nutricional</th>
                                <td>Não incluso</td>
                                <td>1x por mês</td>
                                <td>Quinzenal</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Avaliação física</th>
                                <td>Trimestral</td>
                                <td>Bimestral</td>
                                <td>Mensal</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Horário de acesso</th>
                                <td>Comercial</td>
                                <td>Estendido</td>
                                <td>24 horas</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </main>
                </div>
            </div>
        </section>

            <!-- Sessão Treino -->
            <div id="treino" class="hidden">
                <div class="content-header">
                    <h1 class="page-title">Seu Treino</h1>
                    <p class="page-subtitle">Acompanhe seu treino diário</p>
                </div>

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
                    <div class="container-fluid">
                        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Menu</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Meus Treinos</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opções
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Histórico</a></li>
                                            <li><a class="dropdown-item" href="#">Metas</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#" suze>Configurações</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <form class="d-flex mt-3 mt-lg-0" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Buscar treino" aria-label="Search" style="min-width:320px; max-width:680px; width:42vw;">
                                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">

                <!-- Conteúdo do treino será adicionado aqui -->
            </div>

            <!-- Sessão Ficha -->
            <div id="ficha" class="hidden">
                <div class="content-header">
                    <h1 class="page-title">Sua Ficha</h1>
                    <p class="page-subtitle">Acompanhe sua evolução</p>
                </div>
                <!-- Conteúdo da ficha será adicionado aqui -->
            </div>

            <!-- Sessão Configurações -->
            <div id="config" class="hidden">
                <div class="content-header">
                    <h1 class="page-title">Configurações</h1>
                    <p class="page-subtitle">Ajuste suas preferências</p>
                </div>
                <!-- Conteúdo das configurações será adicionado aqui -->
            </div>
        </main>
    </div>

    <!-- SESSÃO ALUNOS -->
     


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script src="js/hidden.js"></script>
</html>