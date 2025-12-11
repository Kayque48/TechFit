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
    
    <!-- CSS Customizados -->
    <link rel="stylesheet" href="css/headerAdmin.css">
    <link rel="stylesheet" href="css/sidebars.css">
    <link rel="stylesheet" href="css/styleClient.css">
    
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
        }

        .main-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .page-hidden {
            display: none;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--verde-claro), #5a9438);
            color: white;
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .stats-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .bg-primary-custom { background: linear-gradient(135deg, #007bff, #0056b3); }
        .bg-success-custom { background: linear-gradient(135deg, #28a745, #1e7e34); }
        .bg-warning-custom { background: linear-gradient(135deg, #ffc107, #e0a800); }
        .bg-danger-custom { background: linear-gradient(135deg, #dc3545, #bd2130); }

        .quick-action {
            padding: 1rem;
            border-radius: 10px;
            background: white;
            border: 2px solid var(--gray-light);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .quick-action:hover {
            border-color: var(--verde-claro);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            color: var(--verde-escuro);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--verde-claro);
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
                TechFit Admin
            </a>

            <form class="search-form" role="search">
                <input type="search" class="form-control" placeholder="Buscar produtos, alunos, relatórios...">
            </form>

            <div class="user-menu">
                <?php
                $nomeCompleto = $Admin['USER'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <h4 class="adm-ola">Olá, <span class="adm-nome"><?= htmlspecialchars($primeiroNome) ?></span></h4>
                <a class="btn btn-danger btn-sm" href="telaAdministrador.php?action=logout" 
                   onclick="return confirm('Deseja realmente sair?')">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </div>
    </header>

    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <nav class="techfit-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-tachometer-alt"></i>
                    Painel de Controle
                </div>
            </div>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="showPage('visao-geral'); return false;">
                        <i class="nav-icon fas fa-home"></i>
                        Visão Geral
                    </a>
                </li>
                <li class="nav-item">
                    <a href="PlanoCRUD.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        Planos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showPage('alunos'); return false;">
                        <i class="nav-icon fas fa-users"></i>
                        Alunos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showPage('treinos'); return false;">
                        <i class="nav-icon fas fa-dumbbell"></i>
                        Treinos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showPage('produtos'); return false;">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showPage('relatorios'); return false;">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        Relatórios
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <!-- Visão Geral -->
            <div id="visao-geral" class="page-content">
                <h2 class="section-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Dashboard - Visão Geral
                </h2>

                <!-- Cards de Estatísticas -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary-custom">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-muted">Total Alunos</h6>
                                    <h3 class="mb-0">150</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success-custom">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-muted">Planos Ativos</h6>
                                    <h3 class="mb-0">120</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning-custom">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-muted">Produtos</h6>
                                    <h3 class="mb-0">45</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-danger-custom">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-muted">Receita Mensal</h6>
                                    <h3 class="mb-0">R$ 25k</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bolt me-2"></i> Ações Rápidas
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="cadastroCliente.php" class="quick-action text-center">
                                    <i class="fas fa-user-plus fa-2x mb-2 text-primary"></i>
                                    <h6 class="mb-0">Novo Aluno</h6>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="PlanoCRUD.php" class="quick-action text-center">
                                    <i class="fas fa-calendar-plus fa-2x mb-2 text-success"></i>
                                    <h6 class="mb-0">Novo Plano</h6>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="cadastroProduto.php" class="quick-action text-center">
                                    <i class="fas fa-box-open fa-2x mb-2 text-warning"></i>
                                    <h6 class="mb-0">Novo Produto</h6>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" onclick="showPage('relatorios'); return false;" class="quick-action text-center">
                                    <i class="fas fa-chart-bar fa-2x mb-2 text-danger"></i>
                                    <h6 class="mb-0">Relatórios</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Atividades Recentes -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clock me-2"></i> Atividades Recentes
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Novo aluno cadastrado</h6>
                                    <small>Há 5 minutos</small>
                                </div>
                                <p class="mb-1">João Silva realizou cadastro</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Plano atualizado</h6>
                                    <small>Há 1 hora</small>
                                </div>
                                <p class="mb-1">Plano Premium foi modificado</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Produto adicionado</h6>
                                    <small>Há 2 horas</small>
                                </div>
                                <p class="mb-1">Whey Protein foi adicionado ao estoque</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outras páginas (escondidas inicialmente) -->
            <div id="alunos" class="page-content page-hidden">
                <h2 class="section-title">Gerenciar Alunos</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Funcionalidade de gerenciamento de alunos em desenvolvimento...</p>
                        <a href="cadastroCliente.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adicionar Aluno
                        </a>
                    </div>
                </div>
            </div>

            <div id="treinos" class="page-content page-hidden">
                <h2 class="section-title">Gerenciar Treinos</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Funcionalidade de gerenciamento de treinos em desenvolvimento...</p>
                    </div>
                </div>
            </div>

            <div id="produtos" class="page-content page-hidden">
                <h2 class="section-title">Gerenciar Produtos</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Funcionalidade de gerenciamento de produtos em desenvolvimento...</p>
                        <a href="cadastroProduto.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adicionar Produto
                        </a>
                    </div>
                </div>
            </div>

            <div id="relatorios" class="page-content page-hidden">
                <h2 class="section-title">Relatórios e Análises</h2>
                <div class="card">
                    <div class="card-body">
                        <p>Funcionalidade de relatórios em desenvolvimento...</p>
                    </div>
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
            }
            
            // Adicionar active ao link clicado
            event.target.closest('.nav-link')?.classList.add('active');
        }
        
        // Mostrar visão geral por padrão
        document.addEventListener('DOMContentLoaded', function() {
            showPage('visao-geral');
        });
    </script>
</body>
</html>