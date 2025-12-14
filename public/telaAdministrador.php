<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se está logado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: loginAdm.php?erro=2');
    exit;
}

require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/PlanoController.php';

$alunoController = new AlunoController();
$planoController = new PlanoController();

$alunos = $alunoController->ler();


// Dados do admin para o header
$Admin = ['USER' => $_SESSION['usuario']];

// Action de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: loginAdm.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - TechFit</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styleAdmin.css">

    <style>
        :root {
            --verde-escuro: #1E5332;
            --verde-claro: #68A842;
            --amarelo: #FBC70B;
            --laranja: #E95D29;
            --azul: #0093D1;
            --gray-light: #f8f9fa;
        }

        body {
            background-color: var(--gray-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Header Aprimorado */
        .techfit-header {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, #2a7a4a 100%);
            color: white;
            padding: 1.25rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 1.6rem;
            gap: 1rem;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            background: var(--amarelo);
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--verde-escuro);
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(251, 199, 11, 0.3);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .admin-greeting {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .admin-name {
            color: var(--amarelo);
            font-weight: 700;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background: var(--laranja);
            border-color: var(--laranja);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(233, 93, 41, 0.4);
        }

        /* Layout */
        .main-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar Aprimorada */
        .techfit-sidebar {
            width: 280px;
            background: white;
            padding: 2rem 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 80px;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .sidebar-section {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
        }

        .sidebar-section-title {
            color: var(--verde-escuro);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .nav-pills .nav-link {
            border-radius: 10px;
            margin-bottom: 0.5rem;
            padding: 0.85rem 1.25rem;
            color: #495057;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover {
            background: rgba(104, 168, 66, 0.1);
            color: var(--verde-escuro);
            transform: translateX(5px);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--verde-claro), #5a9438);
            color: white;
            box-shadow: 0 4px 12px rgba(104, 168, 66, 0.3);
        }

        .nav-icon {
            width: 22px;
            font-size: 1.1rem;
            text-align: center;
        }

        /* Conteúdo Principal */
        .main-content {
            flex: 1;
            padding: 2.5rem;
            background: var(--gray-light);
        }

        .page-hidden {
            display: none;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card.primary::before {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .stat-card.success::before {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }

        .stat-card.warning::before {
            background: linear-gradient(135deg, #ffc107, #e0a800);
        }

        .stat-card.danger::before {
            background: linear-gradient(135deg, #dc3545, #bd2130);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .stat-card.primary .stat-icon {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .stat-card.success .stat-icon {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .stat-card.warning .stat-icon {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .stat-card.purple::before {
            background: linear-gradient(135deg, #6f42c1, #4b2e83);
        }

        .stat-card.purple .stat-icon {
            background: rgba(111, 66, 193, 0.15);
            color: #6f42c1;
        }


        .stat-card.danger .stat-icon {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #212529;
        }

        /* Action Cards */
        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: white;
            padding: 2rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--verde-claro);
        }

        .action-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .action-card.primary .action-icon {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }

        .action-card.success .action-icon {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
        }

        .action-card.warning .action-icon {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: white;
        }

        .action-card.purple .action-icon {
            background: linear-gradient(135deg, #6f42c1, #4b2e83);
            color: white;
        }

        .action-card.purple:hover {
            border-color: #6f42c1;
        }


        .action-card.danger .action-icon {
            background: linear-gradient(135deg, #dc3545, #bd2130);
            color: white;
        }

        .action-title {
            color: #212529;
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .content-card-header {
            border-bottom: 2px solid var(--gray-light);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .content-card-title {
            color: var(--verde-escuro);
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        /* Activity List */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            padding: 1.25rem;
            border-bottom: 1px solid var(--gray-light);
            transition: background 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(104, 168, 66, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .activity-title {
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .activity-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }



        /* Responsivo */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .techfit-sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }

            .header-container {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .main-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {

            .stats-grid,
            .action-cards {
                grid-template-columns: 1fr;
            }
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="techfit-header">
        <div class="header-container">
            <a href="telaAdministrador.php" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <span>TechFit Admin</span>
            </a>

            <div class="user-info">
                <?php
                $nomeCompleto = $Admin['USER'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <span class="admin-greeting">
                    Olá, <span class="admin-name"><?= htmlspecialchars($primeiroNome) ?></span>
                </span>
                <a class="btn-logout" href="telaAdministrador.php?action=logout"
                    onclick="return confirm('Deseja realmente sair?')">
                    <i class="fas fa-sign-out-alt"></i>
                    Sair
                </a>
            </div>
        </div>
    </header>

    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <nav class="techfit-sidebar">
            <div class="sidebar-section">
                <div class="sidebar-section-title">Menu Principal</div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-page="dashboard"
                            onclick="showPage('dashboard'); return false;">
                            <i class="nav-icon fas fa-chart-line"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="alunos" onclick="showPage('alunos'); return false;">
                            <i class="nav-icon fas fa-users"></i>
                            Alunos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="planos" onclick="showPage('planos'); return false;">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            Planos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="colaboradores"
                            onclick="showPage('colaboradores'); return false;">
                            <i class="nav-icon fas fa-user-tie"></i>
                            colaboradores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="treinos" onclick="showPage('treinos'); return false;">
                            <i class="nav-icon fas fa-dumbbell"></i>
                            Treinos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="produtos" onclick="showPage('produtos'); return false;">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            Produtos
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Relatórios</div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showPage('relatorios'); return false;">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            Financeiro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showPage('analytics'); return false;">
                            <i class="nav-icon fas fa-analytics"></i>
                            Analytics
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Configurações</div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showPage('config'); return false;">
                            <i class="nav-icon fas fa-cog"></i>
                            Sistema
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <!-- Dashboard -->
            <div id="dashboard" class="page-content fade-in">
                <h2 style="color: var(--verde-escuro); font-weight: 700; margin-bottom: 2rem;">
                    <i class="fas fa-chart-line me-2"></i>
                    Visão Geral do Sistema
                </h2>

                <!-- Estatísticas -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-label">Total de Alunos</div>
                        <div class="stat-value"><?= $alunoController->contar() ?></div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-label">Planos Ativos</div>
                        <div class="stat-value"><?= $planoController->contar() ?></div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-label">Produtos</div>
                        <div class="stat-value">48</div>
                    </div>

                    <div class="stat-card purple">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-label">Professores</div>
                        <div class="stat-value">8</div>
                    </div>


                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-label">Receita Mensal</div>
                        <div class="stat-value">R$ 28k</div>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-bolt"></i>
                            Ações Rápidas
                        </h3>
                    </div>
                    <div class="action-cards">
                        <a href="cadastroCliente.php" class="action-card primary">
                            <div class="action-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h6 class="action-title">Novo Aluno</h6>
                        </a>

                        <a href="PlanoCRUD.php" class="action-card success">
                            <div class="action-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <h6 class="action-title">Novo Plano</h6>
                        </a>

                        <a href="cadastroProduto.php" class="action-card warning">
                            <div class="action-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h6 class="action-title">Novo Produto</h6>
                        </a>

                        <a href="cadastroProfessor.php" class="action-card purple">
                            <div class="action-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h6 class="action-title">Novo Professor</h6>
                        </a>


                        <a href="#" onclick="showPage('relatorios'); return false;" class="action-card danger">
                            <div class="action-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h6 class="action-title">Relatórios</h6>
                        </a>
                    </div>
                </div>

                <!-- Atividades Recentes -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-clock"></i>
                            Atividades Recentes
                        </h3>
                    </div>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-header">
                                <h6 class="activity-title">
                                    <i class="fas fa-user-plus text-primary me-2"></i>
                                    Novo aluno cadastrado
                                </h6>
                                <span class="activity-time">Há 5 minutos</span>
                            </div>
                            <p class="activity-description">João Silva realizou cadastro no plano Premium</p>
                        </li>
                        <li class="activity-item">
                            <div class="activity-header">
                                <h6 class="activity-title">
                                    <i class="fas fa-edit text-warning me-2"></i>
                                    Plano atualizado
                                </h6>
                                <span class="activity-time">Há 1 hora</span>
                            </div>
                            <p class="activity-description">Plano Premium teve o preço ajustado para R$ 149,90</p>
                        </li>
                        <li class="activity-item">
                            <div class="activity-header">
                                <h6 class="activity-title">
                                    <i class="fas fa-box text-success me-2"></i>
                                    Produto adicionado
                                </h6>
                                <span class="activity-time">Há 2 horas</span>
                            </div>
                            <p class="activity-description">Whey Protein 1kg foi adicionado ao estoque</p>
                        </li>
                        <li class="activity-item">
                            <div class="activity-header">
                                <h6 class="activity-title">
                                    <i class="fas fa-file-invoice text-info me-2"></i>
                                    Pagamento processado
                                </h6>
                                <span class="activity-time">Há 3 horas</span>
                            </div>
                            <p class="activity-description">Maria Oliveira efetuou pagamento de R$ 89,90</p>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Página de Alunos (escondida) -->
            <div id="alunos" class="page-content page-hidden">

                <!-- Cards Resumo -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-label">Total de Alunos</div>
                        <div class="stat-value">48</div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Último Acesso ao Site</div>
                        <div class="stat-value">40</div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-label">Último Acesso ao Academia</div>
                        <div class="stat-value">8</div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Alunos Cadastrados
                        </h3>

                        <div class="action-buttons">
                            <a href="cadastroCliente.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Novo Aluno
                            </a>

                            <a href="listaAlunos.php" class="btn btn-success">
                                <i class="fas fa-list me-2"></i> Ver Todas as Fichas
                            </a>
                        </div>

                    </div>

                    <?php if (!empty($alunos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th>Data de Nascimento</th>
                                        <th>Endereço</th>
                                        <th>Plano</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($alunos as $aluno): ?>
                                        <tr>
                                            <td><?= $aluno->getId() ?></td>
                                            <td><?= $aluno->getNome() ?></td>
                                            <td><?= $aluno->getTelefone() ?></td>
                                            <td><?= $aluno->getEmail() ?></td>
                                            <td><?= $aluno->getDataNasc() ?></td>
                                            <td><?= $aluno->getEndereco() ?></td>
                                            <td><?= $aluno->getPlano() ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Sem dados registrados</strong>
                            <p>
                                Você ainda não tem nenhum aluno cadastrado.
                                <a href="cadastrarAluno.php" class="alert-link">Clique aqui para criar um</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>



            <!-- Página de Planos (escondida) -->
            <div id="planos" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Gerenciar Planos
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de gerenciamento de planos em desenvolvimento...</p>
                </div>
            </div>

            <!-- Página de Colaboradores (escondida) -->
            <div id="colaboradores" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-user-tie"></i>
                            Gerenciar Colaboradores
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de gerenciamento de colaboradores em desenvolvimento...</p>
                </div>
            </div>

            <!-- Página de Treinos (escondida) -->
            <div id="treinos" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-dumbbell"></i>
                            Gerenciar Treinos
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de gerenciamento de treinos em desenvolvimento...</p>
                </div>
            </div>

            <!-- Página de Produtos (escondida) -->
            <div id="produtos" class="page-content page-hidden">

                <!-- Cards Resumo -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-label">Total de Produtos</div>
                        <div class="stat-value">48</div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Ativos</div>
                        <div class="stat-value">40</div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-label">Inativos</div>
                        <div class="stat-value">8</div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Produtos Cadastrados
                        </h3>

                        <a href="cadastroProduto.php" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Novo Produto
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Whey Protein</td>
                                    <td>Suplemento</td>
                                    <td>R$ 129,90</td>
                                    <td>
                                        <span class="badge bg-success">Ativo</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="editarProduto.php?id=1" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="excluirProduto.php?id=1"
                                            onclick="return confirm('Deseja realmente excluir?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- PHP foreach depois -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Página de Relatórios (escondida) -->
            <div id="relatorios" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-chart-bar"></i>
                            Relatórios Financeiros
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de relatórios em desenvolvimento...</p>
                </div>
            </div>

            <!-- Página de Analytics (escondida) -->
            <div id="analytics" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-analytics"></i>
                            Analytics do Sistema
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de analytics em desenvolvimento...</p>
                </div>
            </div>

            <!-- Página de Configurações (escondida) -->
            <div id="config" class="page-content page-hidden">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-cog"></i>
                            Configurações do Sistema
                        </h3>
                    </div>
                    <p class="text-muted">Funcionalidade de configurações em desenvolvimento...</p>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPage(pageId) {
            // Esconder todas as páginas
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.add('page-hidden');
            });

            // Remover active de todos os links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Mostrar página selecionada
            const selectedPage = document.getElementById(pageId);
            if (selectedPage) {
                selectedPage.classList.remove('page-hidden');
                selectedPage.classList.add('fade-in');
            }

            // Adicionar active ao link clicado (se existir no sidebar)
            const activeLink = document.querySelector(`.nav-link[data-page="${pageId}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }

            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    </script>
</body>

</html>