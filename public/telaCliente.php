<?php
session_start();

$idade = $_SESSION['idade'];

// Verificar se o usuário está logado
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: loginCliente.php');
    exit;
}

// Importar os controllers
require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/FisicoController.php';
require_once __DIR__ . '/../src/controllers/PlanoController.php';

$controllerAluno = new AlunoController();
$controllerFisico = new FisicoController();

// Buscar dados do aluno logado
$aluno = $controllerAluno->buscarPorEmail($_SESSION['email']);

if (!$aluno) {
    // Se não encontrar no banco, redirecionar para login
    header('Location: loginCliente.php');
    exit;
}

// Definir o ID do aluno
$id = $aluno['ID_ALUNO'] ?? null;

// Usar o email do aluno
$Alunoemail = $_SESSION['email'];

// Processar atualização do plano
$mensagemPlano = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_plano'])) {
    $novoPlano = trim($_POST['plano_selecionado'] ?? '');
    if (!empty($novoPlano)) {
        try {
            $controllerAluno->getDAO()->atualizarPlano($email, $novoPlano);
            $mensagemPlano = 'Plano atualizado com sucesso!';
        } catch (Exception $e) {
            $mensagemPlano = 'Erro ao atualizar plano: ' . $e->getMessage();
        }
    }
}

// Buscar ficha de avaliação física (mais recente)
$fichas = !empty($email) ? $controllerFisico->lerPorIdAluno($id) : [];
$fichaRecente = !empty($fichas) ? $fichas[0] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleCadProduto.css">
    <link rel="stylesheet" href="css/hidden.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/ajuste.css">
    <link rel="stylesheet" href="css/secTreino.css">
    <link rel="stylesheet" href="css/secPlano.css">
    <link rel="stylesheet" href="css/secConfig.css">
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
            <div id="geral" class="hidden">
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
                                    <p id="nome-cliente"><?php echo htmlspecialchars($aluno['NOME_ALUNO'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientYear">Idade:</label>
                                    <p id="idade-cliente"><?php echo htmlspecialchars($idade ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientOld">Endereço:</label>
                                    <p id="endereco-cliente"><?php echo htmlspecialchars($aluno['ENDERECO_ALUNO'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPlan">Plano:</label>
                                    <p id="Plano-cliente"><?php echo htmlspecialchars($aluno['PLANO'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPhone">Telefone:</label>
                                    <p id="telefone-cliente"><?php echo htmlspecialchars($aluno['TELEFONE'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientEmail">Email:</label>
                                    <p id="email-cliente"><?php echo htmlspecialchars($aluno['EMAIL'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="exercise-details container px-4 py-5" id="custom-cards">
                            <h3 class="section-title pb-2 border-bottom">
                                <i class="fas fa-dumbbell me-2"></i>
                                Detalhes dos Exercícios
                            </h3>

                            <div class="row justify-content-center text-center mb-4">
                                <?php
                                $dias = [
                                    ['nome' => 'Segunda-feira', 'img' => 'https://plus.unsplash.com/premium_photo-1672862927484-cfc92dd88081?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Terça-feira',   'img' => 'https://plus.unsplash.com/premium_photo-1661630801762-b59faf22d543?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Quarta-feira',  'img' => 'https://images.unsplash.com/photo-1669989179344-3e84780dab7d?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Quinta-feira',  'img' => 'https://images.unsplash.com/photo-1605720789771-a7fb8ab19d04?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Sexta-feira',   'img' => 'https://images.unsplash.com/photo-1734458211458-4d508abf564e?q=80&w=627&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Sábado',        'img' => 'https://images.unsplash.com/photo-1609899517237-77d357b047cf?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                    ['nome' => 'Domingo',       'img' => 'https://images.unsplash.com/photo-1581122584612-713f89daa8eb?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                                ];
                                foreach ($dias as $dia): ?>
                                    <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex flex-column align-items-center dia-semana"
                                         onclick="atualizarTitulo('<?= $dia['nome'] ?>')"
                                         role="button" style="cursor:pointer;">
                                        <img src="<?= $dia['img'] ?>" alt="<?= $dia['nome'] ?>" class="rounded-circle shadow" width="100" height="100" style="object-fit:cover; background:#f8f9fa;">
                                        <h5 class="fw-normal mt-3"><?= $dia['nome'] ?></h5>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <h3 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                <span id="titulo-treino">Treinos da Semana</span>
                            </h3>

                            <style>
                                /* pequeno destaque para o dia selecionado */
                                .dia-semana.active-day { outline: 3px solid #0d6efd; border-radius: 12px; padding: 4px; }
                                .d-none { display: none !important; }
                            </style>

                            <script>
                                function atualizarTitulo(dia) {
                                    const titulo = document.getElementById('titulo-treino');
                                    titulo.textContent = 'Treinos de ' + dia;

                                    // destacar dia selecionado
                                    document.querySelectorAll('.dia-semana').forEach(el => {
                                        const text = el.querySelector('h5')?.textContent?.trim();
                                        if (text === dia) el.classList.add('active-day'); else el.classList.remove('active-day');
                                    });

                                    // mostrar apenas cards do dia selecionado
                                    document.querySelectorAll('.card-col').forEach(card => {
                                        const cardDay = card.dataset.day;
                                        if (cardDay === dia) card.classList.remove('d-none'); else card.classList.add('d-none');
                                    });
                                }

                                // função para resetar visualização (mostrar todos)
                                function mostrarTodos() {
                                    document.getElementById('titulo-treino').textContent = 'Treinos da Semana';
                                    document.querySelectorAll('.dia-semana').forEach(el => el.classList.remove('active-day'));
                                    document.querySelectorAll('.card-col').forEach(card => card.classList.remove('d-none'));
                                }

                                // inicializar mostrando todos
                                document.addEventListener('DOMContentLoaded', function() {
                                    mostrarTodos();
                                });
                            </script>

                            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                                <!-- Card 1 - Segunda -->
                                <div class="col card-col" data-day="Segunda-feira">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/abs.jpg'); background-size:cover;">
                                        <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                            <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">ABS</h4>
                                            <ul class="d-flex list-unstyled mt-auto">
                                                <li class="me-auto">
                                                    <img src="https://github.com/twbs.png" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
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

                                <!-- Card 2 - Terça -->
                                <div class="col card-col" data-day="Terça-feira">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/peito.jpg'); background-size:cover;">
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

                                <!-- Card 3 - Quarta -->
                                <div class="col card-col" data-day="Quarta-feira">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/costas.jpg'); background-size:cover;">
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

                                <!-- Card 4 - Quinta -->
                                <div class="col card-col" data-day="Quinta-feira">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/pernas.jpg'); background-size:cover;">
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

                                <!-- Card 5 - Sexta -->
                                <div class="col card-col" data-day="Sexta-feira">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/biceps.jpg'); background-size:cover;">
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

                                <!-- Card 6 - Sábado -->
                                <div class="col card-col" data-day="Sábado">
                                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/triceps.jpg'); background-size:cover;">
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

                                <!-- Additional cards can be added here with data-day="Nome do Dia" -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Seção Plano -->
            <section id="plano" class="plans container py-5 hidden">
                <div class="container py-3">
                    <div class="content-header">
                        <h1 class="page-title">Nossos Planos</h1>
                        <p class="page-subtitle">Escolha o plano que melhor se adapta a você</p>
                    </div>

                    <div class="product-form-container">
                        <div class="pricing-header text-center">
                            <h1 class="display-4 fw-normal text-body-emphasis">Planos de Academia</h1>
                            <p class="fs-5 text-body-secondary">
                            Encontre o plano ideal para alcançar seus objetivos de fitness com nossa variedade de opções.
                            </p>
                        </div>
                    
                        <?php if (!empty($mensagemPlano)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($mensagemPlano) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Formulário para Atualizar Plano -->
                        <form id="updatePlanForm" method="POST" action="../../src/models/atualizarPlano.php">
                            <input type="hidden" id="selectedPlanInput" name="selectedPlan" value="">
                        </form>

                        <script>
                            function updatePlan(plan) {
                                // Define o valor do plano selecionado no campo oculto
                                document.getElementById('selectedPlanInput').value = plan;

                                // Submete o formulário para atualizar o plano
                                document.getElementById('updatePlanForm').submit();
                            }
                        </script>

                        <form method="POST" action="">
                            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                                <!-- Plano Básico -->
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Plano Básico</h5>
                                            <p class="card-text display-6">$20<small class="text-body-secondary fw-light">/mês</small></p>
                                            <ul class="list-unstyled mb-4 flex-grow-1">
                                                <li><i class="fas fa-check text-success me-2"></i>Acesso a todas as máquinas</li>
                                                <li><i class="fas fa-check text-success me-2"></i>1 aula de grupo por semana</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Suporte online</li>
                                            </ul>
                                            <button type="button" class="btn btn-primary btn-select-plan" data-plan="basico" onclick="updatePlan('basico')">Selecionar Plano Básico</button>
                                    </div>
                                </div>

                                <!-- Plano Intermediário -->
                                <div class="col">
                                    <div class="card h-100 shadow-sm border-primary">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Plano Intermediário</h5>
                                            <p class="card-text display-6">$35<small class="text-body-secondary fw-light">/mês</small></p>
                                            <ul class="list-unstyled mb-4 flex-grow-1">
                                                <li><i class="fas fa-check text-success me-2"></i>Acesso ilimitado</li>
                                                <li><i class="fas fa-check text-success me-2"></i>3 aulas por semana</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Acompanhamento com personal</li>
                                            </ul>
                                            <button type="button" class="btn btn-primary btn-select-plan" data-plan="intermediario" onclick="updatePlan('intermediario')">Selecionar Plano Intermediário</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Plano Premium -->
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">Plano Premium</h5>
                                            <p class="card-text display-6">$50<small class="text-body-secondary fw-light">/mês</small></p>
                                            <ul class="list-unstyled mb-4 flex-grow-1">
                                                <li><i class="fas fa-check text-success me-2"></i>Acesso 24h</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Aulas ilimitadas</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Consultoria nutricional</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Treinamento pessoal ilimitado</li>
                                            </ul>
                                            <button type="button" class="btn btn-primary btn-select-plan" data-plan="premium" onclick="updatePlan('premium')">Selecionar Plano Premium</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="atualizar_plano" value="1">
                        </form>


                   <div class="product-form-container">             
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
                        </div>
                    </div>
            </section>
            

            <!-- ===================== SEÇÃO TREINO ===================== -->
            <div id="treino" class="hidden">

                <div class="content-header">
                    <h1 class="page-title">Histórico de Treinos</h1>
                    <p class="page-subtitle">Consulte os treinos realizados e o total de horas treinadas</p>
                </div>

            <div class="product-form-container">

                <!-- Busca -->
                <div class="form-section">
                    <h2 class="section-title">Buscar Treinos</h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Pesquisar por nome do treino</label>
                            <input type="text" class="form-control-custom" placeholder="Ex: Peito, Costas, Pernas...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Filtrar por data</label>
                            <input type="date" class="form-control-custom">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Filtrar por duração</label>
                            <select class="form-control-custom">
                                <option value="">Selecione</option>
                                <option>Menos de 30 min</option>
                                <option>30 min - 1h</option>
                                <option>1h - 2h</option>
                                <option>Mais de 2h</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Histórico -->
                <div class="form-section">
                    <h2 class="section-title">Treinos Realizados</h2>

                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Treino</th>
                                    <th>Duração</th>
                                    <th>Calorias</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id="tabela-treinos">
                                <tr>
                                    <td>20/11/2025</td>
                                    <td>Peito e Tríceps</td>
                                    <td>01:12h</td>
                                    <td>430 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                                <tr>
                                    <td>18/11/2025</td>
                                    <td>Pernas e Ombros</td>
                                    <td>01:45h</td>
                                    <td>520 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                                <tr>
                                    <td>16/11/2025</td>
                                    <td>Costas e Bíceps</td>
                                    <td>00:58h</td>
                                    <td>390 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="form-section">
                    <h2 class="section-title">Estatísticas Gerais</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label cla  ss="form-label">Total de treinos realizados</label>
                            <input type="text" class="form-control-custom" value="34 treinos" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Total de horas treinadas</label>
                            <input type="text" class="form-control-custom" value="41h e 22min" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Média semanal</label>
                            <input type="text" class="form-control-custom" value="4 treinos/semana" disabled>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
         <!-- ===================== SEÇÃO FICHA ===================== -->
        <div id="ficha" class="hidden">

            <div class="content-header">
                <h1 class="page-title">Ficha de Avaliação Física</h1>
                <p class="page-subtitle">Acompanhe suas medidas, evolução e composição corporal</p>
            </div>

            <div class="product-form-container">

                <!-- Tabela com dados do banco -->
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-chart-line me-2"></i> Avaliação Física Mais Recente</h2>

                    <?php if ($fichaRecente): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Data da Avaliação</strong></td>
                                    <td><?= !empty($fichaRecente->getData()) ? date('d/m/Y', strtotime($fichaRecente->getData())) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Peso (kg)</strong></td>
                                    <td><?= !empty($fichaRecente->getPeso()) ? htmlspecialchars($fichaRecente->getPeso()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Altura (m)</strong></td>
                                    <td><?= !empty($fichaRecente->getAltura()) ? htmlspecialchars($fichaRecente->getAltura()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>IMC</strong></td>
                                    <td><?= !empty($fichaRecente->getImc()) ? htmlspecialchars($fichaRecente->getImc()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Peitoral (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getPeitoral()) ? htmlspecialchars($fichaRecente->getPeitoral()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Cintura (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getCintura()) ? htmlspecialchars($fichaRecente->getCintura()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Quadril (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getQuadril()) ? htmlspecialchars($fichaRecente->getQuadril()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Braço Esquerdo (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getBraEsquerdo()) ? htmlspecialchars($fichaRecente->getBraEsquerdo()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Braço Direito (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getBraDireito()) ? htmlspecialchars($fichaRecente->getBraDireito()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Coxa (cm)</strong></td>
                                    <td><?= !empty($fichaRecente->getCoxa()) ? htmlspecialchars($fichaRecente->getCoxa()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Gordura Corporal (%)</strong></td>
                                    <td><?= !empty($fichaRecente->getGordura()) ? htmlspecialchars($fichaRecente->getGordura()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Massa Magra (kg)</strong></td>
                                    <td><?= !empty($fichaRecente->getMasMagra()) ? htmlspecialchars($fichaRecente->getMasMagra()) : 'null' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>TMB (kcal)</strong></td>
                                    <td><?= !empty($fichaRecente->getTmb()) ? htmlspecialchars($fichaRecente->getTmb()) : 'null' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Sem dados registrados</strong>
                        <p>Você ainda não tem nenhuma ficha de avaliação. <a href="cadastrarFicha.php" class="alert-link">Clique aqui para criar uma</a></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Histórico de Avaliações -->
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-history me-2"></i> Histórico de Avaliações</h2>

                    <?php if (!empty($fichas) && count($fichas) > 1): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Peso (kg)</th>
                                    <th>Altura (m)</th>
                                    <th>IMC</th>
                                    <th>% Gordura</th>
                                    <th>Cintura (cm)</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fichas as $ficha): ?>
                                <tr>
                                    <td><?= !empty($ficha->getData()) ? date('d/m/Y', strtotime($ficha->getData())) : 'null' ?></td>
                                    <td><?= !empty($ficha->getPeso()) ? htmlspecialchars($ficha->getPeso()) : 'null' ?></td>
                                    <td><?= !empty($ficha->getAltura()) ? htmlspecialchars($ficha->getAltura()) : 'null' ?></td>
                                    <td><?= !empty($ficha->getImc()) ? htmlspecialchars($ficha->getImc()) : 'null' ?></td>
                                    <td><?= !empty($ficha->getGordura()) ? htmlspecialchars($ficha->getGordura()) . '%' : 'null' ?></td>
                                    <td><?= !empty($ficha->getCintura()) ? htmlspecialchars($ficha->getCintura()) : 'null' ?></td>
                                    <td>
                                        <a href="listaFichas.php?editar=<?= $ficha->getId() ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-secondary">
                        <i class="fas fa-calendar me-2"></i>
                        Você tem apenas 1 avaliação registrada. Crie mais fichas para acompanhar sua evolução.
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Botões de Ação -->
                <div class="action-buttons">
                    <a href="cadastrarFicha.php" class="btn-techfit btn-primary">
                        <i class="fas fa-plus me-2"></i> Nova Avaliação
                    </a>
                    <a href="listaFichas.php" class="btn-techfit btn-success">
                        <i class="fas fa-list me-2"></i> Ver Todas as Fichas
                    </a>
                </div>
            </div>
        </div>
        </main>
        </div>
     </footer>
      <?php 
        require_once '../src/views/footer.php';
      ?>

</body>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/hidden.js"></script>
<script src="js/modal.js"></script>
<script src="js/treino.js"></script>
<script src="js/config.js"></script>
</html>