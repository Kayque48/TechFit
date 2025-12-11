<<<<<<< HEAD
<?php
session_start();

// Autoload simples
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/',
        __DIR__ . '/models/',
        __DIR__ . '/config/'
    ];
=======
<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/FisicoController.php';
require_once __DIR__ . '/../src/controllers/PlanoController.php';
require_once __DIR__ . '/../src/controllers/AdministradorController.php';

$controllerAdm = new AdministradorController();
$controllerAluno = new AlunoController();
$controllerFisico = new FisicoController();
$controllerPlano = new PlanoController();


// Buscar dados do aluno logado
$admin = $controllerAdm->buscarPorEmail($_SESSION['emailAdm']);

if (!$admin) {
    // Se não encontrar no banco, redirecionar para login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleCadProduto.css">
    <title>TechFit Admin - Sistema Completo</title>
    <style>
        /* Sistema de show/hide para as páginas */
        .page-section {
            display: none;
        }
        .page-section.active {
            display: block;
        }
        
        /* Estilos para a navegação ativa */
        .nav-link.active {
            background-color: var(--bs-primary);
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Header -->
     <?php require_once __DIR__ . '/../src/views/admin/header.php' ?>

    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../src/views/admin/sidebars.php' ?>
        <main class="main-content">
            
            <!-- Página: Visão Geral -->
            <div id="visao-geral" class="page-section active">
                <div class="content-header">
                    <h1 class="page-title">Visão Geral</h1>
                    <p class="page-subtitle">Dashboard administrativo da TechFit</p>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title">245</h3>
                                        <p class="card-text">Total de Alunos</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title">156</h3>
                                        <p class="card-text">Produtos em Estoque</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-box fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title">R$ 12.540</h3>
                                        <p class="card-text">Faturamento Mensal</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-chart-line fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title">28</h3>
                                        <p class="card-text">Novos Este Mês</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-plus fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos ou conteúdo adicional da visão geral -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Atividade Recente</h5>
                            </div>
                            <div class="card-body">
                                <p>Últimos alunos cadastrados, vendas, etc.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Estatísticas Rápidas</h5>
                            </div>
                            <div class="card-body">
                                <p>Métricas importantes do negócio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Página: Alunos -->
            <div id="alunos" class="page-section">
                <div class="content-header">
                    <h1 class="page-title">
                        <i class="fas fa-users me-2"></i>
                        Gestão de Alunos
                    </h1>
                    <p class="page-subtitle">Gerencie o cadastro de alunos da academia</p>
                </div>

                <!-- Estatísticas Rápidas -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title" id="totalAlunos">0</h3>
                                        <p class="card-text">Total de Alunos</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title" id="mediaIdade">0</h3>
                                        <p class="card-text">Idade Média</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title" id="comAvaliacao">0</h3>
                                        <p class="card-text">Com Avaliação</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-clipboard-check fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title" id="semTelefone">0</h3>
                                        <p class="card-text">Sem Telefone</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-phone-slash fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de Ferramentas -->
                <div class="toolbar mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <div class="filter-group me-3">
                                    <select class="form-select" id="filtroAvaliacao">
                                        <option value="">Todos - Avaliação</option>
                                        <option value="PENDENTE">Avaliação Pendente</option>
                                        <option value="REALIZADA">Avaliação Realizada</option>
                                        <option value="AGENDADA">Avaliação Agendada</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <input type="text" class="form-control" placeholder="Buscar aluno..." id="buscaAluno">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Alunos -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tabelaAlunos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Idade</th>
                                        <th>Endereço</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th>Avaliação Física</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Página: Produtos -->
            <div id="produtos" class="page-section">
                <div class="content-header">
                    <h1 class="page-title">Cadastro de Produtos</h1>
                    <p class="page-subtitle">Gerencie os produtos da sua academia</p>
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
                                    <label class="form-label" for="productCode">Código do Produto</label>
                                    <input type="text" class="form-control-custom" id="productCode" placeholder="Ex: PROD-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="productName">Nome do Produto</label>
                                    <input type="text" class="form-control-custom" id="productName" placeholder="Ex: Whey Protein 900g">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="productDescription">Descrição</label>
                                <input type="text" class="form-control-custom" id="productDescription" placeholder="Ex: Whey Protein concentrado 100% puro">
                            </div>
                        </div>

                        <!-- Detalhes do Produto -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-tags me-2"></i>
                                Detalhes do Produto
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="productCategory">Categoria</label>
                                    <select class="form-control-custom" id="productCategory">
                                        <option value="">Selecione uma categoria</option>
                                        <option value="suplementos">Suplementos</option>
                                        <option value="roupas">Roupas</option>
                                        <option value="acessorios">Acessórios</option>
                                        <option value="equipamentos">Equipamentos</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="productBrand">Marca</label>
                                    <select class="form-control-custom" id="productBrand">
                                        <option value="">Selecione uma marca</option>
                                        <option value="integralmedica">Integral Médica</option>
                                        <option value="maxTitanium">Max Titanium</option>
                                        <option value="growth">Growth</option>
                                        <option value="probiotica">Probiótica</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="productQuantity">Quantidade em Estoque</label>
                                    <input type="number" class="form-control-custom" id="productQuantity" min="0" value="0">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="productPrice">Preço Unitário (R$)</label>
                                    <input type="text" class="form-control-custom" id="productPrice" placeholder="Ex: 89,90">
                                </div>
                            </div>
                        </div>

                        <!-- Status do Produto -->
                        <div class="status-section">
                            <h3 class="section-title">
                                <i class="fas fa-toggle-on me-2"></i>
                                Status do Produto
                            </h3>
                            <div class="status-options">
                                <label class="form-label mb-0 me-3">Status:</label>
                                <div class="status-option status-active selected" data-status="active">
                                    <i class="fas fa-check-circle me-2"></i>Ativo
                                </div>
                                <div class="status-option status-inactive" data-status="inactive">
                                    <i class="fas fa-times-circle me-2"></i>Inativo
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-techfit btn-success">
                                <i class="fas fa-save"></i>
                                Cadastrar Produto
                            </button>
                            <button type="button" class="btn-techfit btn-primary">
                                <i class="fas fa-sync-alt"></i>
                                Atualizar
                            </button>
                            <button type="button" class="btn-techfit btn-danger">
                                <i class="fas fa-trash-alt"></i>
                                Excluir
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TREINOS -->
            <!-- Página: Gestão de Treinos e Aulas -->
<div id="treinos" class="page-section">
    <div class="content-header">
        <h1 class="page-title">
            <i class="fas fa-dumbbell me-2"></i>
            Gestão de Treinos e Aulas
        </h1>
        <p class="page-subtitle">Gerencie treinos personalizados e aulas em grupo</p>
    </div>

    <!-- Estatísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="totalTreinos">0</h3>
                            <p class="card-text">Total de Treinos</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-dumbbell fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="totalAulas">0</h3>
                            <p class="card-text">Aulas em Grupo</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="professoresAtivos">0</h3>
                            <p class="card-text">Professores Ativos</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-tie fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="filiaisAtivas">15</h3>
                            <p class="card-text">Filiais Ativas</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-store fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de Ferramentas -->
    <div class="toolbar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroTreino">
                    <i class="fas fa-plus me-2"></i>
                    Novo Treino Personalizado
                </button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCadastroAula">
                    <i class="fas fa-users me-2"></i>
                    Nova Aula em Grupo
                </button>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <div class="filter-group me-3">
                        <select class="form-select" id="filtroTipo">
                            <option value="">Todos os Tipos</option>
                            <option value="PERSONALIZADO">Treino Personalizado</option>
                            <option value="AULA_GRUPO">Aula em Grupo</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <input type="text" class="form-control" placeholder="Buscar treino/aula..." id="buscaTreino">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs para diferentes visualizações -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="treinosTabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#lista-treinos" data-bs-toggle="tab">
                        <i class="fas fa-list me-2"></i>Lista Completa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#grade-horaria" data-bs-toggle="tab">
                        <i class="fas fa-calendar-alt me-2"></i>Grade Horária
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#view-filiais" data-bs-toggle="tab">
                        <i class="fas fa-store me-2"></i>Por Filial
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="tab-content">
                <!-- Tab: Lista Completa -->
                <div class="tab-pane fade show active" id="lista-treinos">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabelaTreinos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Professor</th>
                                    <th>Filiais</th>
                                    <th>Dias da Semana</th>
                                    <th>Horário</th>
                                    <th>Vagas</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão carregados via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Grade Horária -->
                <div class="tab-pane fade" id="grade-horaria">
                    <div class="grade-horaria-container">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select class="form-select" id="filialGrade">
                                    <option value="">Todas as Filiais</option>
                                    <!-- Opções de filiais serão carregadas via JS -->
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered grade-table">
                                <thead>
                                    <tr>
                                        <th>Horário</th>
                                        <th>Segunda</th>
                                        <th>Terça</th>
                                        <th>Quarta</th>
                                        <th>Quinta</th>
                                        <th>Sexta</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                    </tr>
                                </thead>
                                <tbody id="gradeHorariaBody">
                                    <!-- Grade será gerada via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab: Por Filial -->
                <div class="tab-pane fade" id="view-filiais">
                    <div class="row" id="filiaisContainer">
                        <!-- Cards das filiais serão gerados via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cadastro de Treino Personalizado -->
<div class="modal fade" id="modalCadastroTreino" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-dumbbell me-2"></i>
                    Cadastrar Treino Personalizado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCadastroTreino">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomeTreino" class="form-label">Nome do Treino *</label>
                                <input type="text" class="form-control" id="nomeTreino" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="professorTreino" class="form-label">Professor *</label>
                                <select class="form-select" id="professorTreino" required>
                                    <option value="">Selecione o professor</option>
                                    <!-- Professores carregados via JS -->
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricaoTreino" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricaoTreino" rows="3" placeholder="Descreva o objetivo do treino..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Filiais *</label>
                        <div class="filiais-grid">
             <!-- Grid de filiais será gerado via JavaScript -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duracaoTreino" class="form-label">Duração (minutos) *</label>
                                <input type="number" class="form-control" id="duracaoTreino" min="15" max="180" value="60" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vagasTreino" class="form-label">Vagas Simultâneas *</label>
                                <input type="number" class="form-control" id="vagasTreino" min="1" max="10" value="1" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarTreino">Salvar Treino</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cadastro de Aula em Grupo -->
<div class="modal fade" id="modalCadastroAula" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-users me-2"></i>
                    Cadastrar Aula em Grupo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCadastroAula">
                    <!-- Informações Básicas -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomeAula" class="form-label">Nome da Aula *</label>
                                <input type="text" class="form-control" id="nomeAula" required placeholder="Ex: Muay Thai Avançado">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipoAula" class="form-label">Tipo de Aula *</label>
                                <select class="form-select" id="tipoAula" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="MUAY_THAI">Muay Thai</option>
                                    <option value="JIU_JITSU">Jiu Jitsu</option>
                                    <option value="CROSSFIT">CrossFit</option>
                                    <option value="PILATES">Pilates</option>
                                    <option value="YOGA">Yoga</option>
                                    <option value="SPINNING">Spinning</option>
                                    <option value="DANCA">Dança</option>
                                    <option value="FUNCIONAL">Funcional</option>
                                    <option value="OUTRO">Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="professorAula" class="form-label">Professor *</label>
                                <select class="form-select" id="professorAula" required>
                                    <option value="">Selecione o professor</option>
                                    <!-- Professores carregados via JS -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vagasAula" class="form-label">Vagas por Turma *</label>
                                <input type="number" class="form-control" id="vagasAula" min="1" max="50" value="20" required>
                            </div>
                        </div>
                    </div>

                    <!-- Seleção de Filiais -->
                    <div class="mb-4">
                        <label class="form-label">Filiais onde a aula será oferecida *</label>
                        <div class="alert alert-info">
                            <small>Selecione as filiais que oferecerão esta aula:</small>
                        </div>
                        <div class="filiais-grid" id="gridFiliaisAula">
                            <!-- Grid de filiais para aulas -->
                        </div>
                    </div>

                    <!-- Dias da Semana e Horários -->
                    <div class="mb-4">
                        <label class="form-label">Dias e Horários *</label>
                        <div class="alert alert-info">
                            <small>Configure os horários para cada dia da semana nas filiais selecionadas:</small>
                        </div>
                        
                        <div id="horariosContainer">
                            <!-- Os horários serão gerados dinamicamente baseado nas filiais selecionadas -->
                        </div>
                        
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="btnAddHorario">
                            <i class="fas fa-plus me-1"></i>Adicionar Horário
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="descricaoAula" class="form-label">Descrição da Aula</label>
                        <textarea class="form-control" id="descricaoAula" rows="3" placeholder="Descreva a aula, equipamentos necessários, nível de dificuldade..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnSalvarAula">Salvar Aula</button>
            </div>
        </div>
    </div>
</div>
            <!-- Páginas Futuras (estrutura básica) -->
            <div id="instrutores" class="page-section">
<div class="content-header">
    <h1 class="page-title">
        <i class="fas fa-user-tie me-2"></i>
        Gestão de Instrutores
    </h1>
    <p class="page-subtitle">Gerencie a equipe de instrutores e professores</p>
</div>

<!-- Estatísticas Rápidas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title" id="totalInstrutores">0</h3>
                        <p class="card-text">Total de Instrutores</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title" id="instrutoresAtivos">0</h3>
                        <p class="card-text">Ativos</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title" id="aulasHoje">0</h3>
                        <p class="card-text">Aulas Hoje</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title" id="mediaAvaliacao">0.0</h3>
                        <p class="card-text">Avaliação Média</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-star fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Barra de Ferramentas -->
<div class="toolbar mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroInstrutor">
                <i class="fas fa-plus me-2"></i>
                Novo Instrutor
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fas fa-file-export me-2"></i>
                Exportar
            </button>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="filter-group me-3">
                    <select class="form-select" id="filtroStatus">
                        <option value="">Todos</option>
                        <option value="ATIVO">Ativos</option>
                        <option value="INATIVO">Inativos</option>
                        <option value="FERIAS">Em Férias</option>
                    </select>
                </div>
                <div class="filter-group me-3">
                    <select class="form-select" id="filtroEspecialidade">
                        <option value="">Todas Especialidades</option>
                        <option value="MUAY_THAI">Muay Thai</option>
                        <option value="JIU_JITSU">Jiu Jitsu</option>
                        <option value="CROSSFIT">CrossFit</option>
                        <option value="PILATES">Pilates</option>
                        <option value="YOGA">Yoga</option>
                    </select>
                </div>
                <div class="filter-group">
                    <input type="text" class="form-control" placeholder="Buscar instrutor..." id="buscaInstrutor">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de Instrutores -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tabelaInstrutores">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Especialidades</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Filiais</th>
                        <th>Avaliação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dados serão carregados via JavaScript/AJAX -->
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Carregando instrutores...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cadastro de Instrutor -->
<div class="modal fade" id="modalCadastroInstrutor" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie me-2"></i>
                    Cadastrar Novo Instrutor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCadastroInstrutor">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nomeInstrutor" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="nomeInstrutor" required maxlength="80">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cpfInstrutor" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpfInstrutor" required maxlength="14" placeholder="000.000.000-00">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailInstrutor" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="emailInstrutor" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefoneInstrutor" class="form-label">Telefone *</label>
                                <input type="text" class="form-control" id="telefoneInstrutor" required placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Especialidades *</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="MUAY_THAI" id="espMuayThai">
                                    <label class="form-check-label" for="espMuayThai">Muay Thai</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="JIU_JITSU" id="espJiuJitsu">
                                    <label class="form-check-label" for="espJiuJitsu">Jiu Jitsu</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="CROSSFIT" id="espCrossfit">
                                    <label class="form-check-label" for="espCrossfit">CrossFit</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="PILATES" id="espPilates">
                                    <label class="form-check-label" for="espPilates">Pilates</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="YOGA" id="espYoga">
                                    <label class="form-check-label" for="espYoga">Yoga</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="FUNCIONAL" id="espFuncional">
                                    <label class="form-check-label" for="espFuncional">Funcional</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Filiais de Atuação *</label>
                        <div class="filiais-grid" id="gridFiliaisInstrutor">
                            <!-- Grid será preenchido via JavaScript -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dataAdmissao" class="form-label">Data de Admissão *</label>
                                <input type="date" class="form-control" id="dataAdmissao" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="statusInstrutor" class="form-label">Status *</label>
                                <select class="form-select" id="statusInstrutor" required>
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                    <option value="FERIAS">Em Férias</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" rows="3" placeholder="Certificações, experiência, etc..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarInstrutor">Salvar Instrutor</button>
            </div>
        </div>
    </div>
</div>
            </div>

<!-- Página: Relatórios -->
<div id="relatorios" class="page-section">
    <div class="content-header">
        <h1 class="page-title">
            <i class="fas fa-chart-bar me-2"></i>
            Relatórios e Analytics
        </h1>
        <p class="page-subtitle">Análises detalhadas do desempenho da academia</p>
    </div>

    <!-- Filtros de Período -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Período</label>
                            <select class="form-select" id="periodoRelatorio">
                                <option value="hoje">Hoje</option>
                                <option value="semana">Esta Semana</option>
                                <option value="mes" selected>Este Mês</option>
                                <option value="trimestre">Este Trimestre</option>
                                <option value="semestre">Este Semestre</option>
                                <option value="ano">Este Ano</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">De</label>
                            <input type="date" class="form-control" id="dataInicio" value="<?php echo date('Y-m-01'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Até</label>
                            <input type="date" class="form-control" id="dataFim" value="<?php echo date('Y-m-t'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Filial</label>
                            <select class="form-select" id="filialRelatorio">
                                <option value="todas">Todas as Filiais</option>
                                <option value="1">Centro</option>
                                <option value="2">Zona Sul</option>
                                <option value="3">Zona Norte</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-primary me-2" onclick="atualizarRelatorios()">
                        <i class="fas fa-sync-alt me-2"></i>Atualizar
                    </button>
                    <button class="btn btn-success" onclick="exportarRelatorios()">
                        <i class="fas fa-file-export me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="totalVendas">R$ 0</h3>
                            <p class="card-text">Faturamento Total</p>
                            <small class="text-success" id="crescimentoVendas">
                                <i class="fas fa-arrow-up me-1"></i>0%
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="novosAlunos">0</h3>
                            <p class="card-text">Novos Alunos</p>
                            <small class="text-info" id="variacaoAlunos">
                                <i class="fas fa-chart-line me-1"></i>0%
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-plus fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="taxaRenovacao">0%</h3>
                            <p class="card-text">Taxa de Renovação</p>
                            <small class="text-warning" id="comparacaoRenovacao">
                                <i class="fas fa-balance-scale me-1"></i>0%
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-sync-alt fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title" id="mediaAulas">0</h3>
                            <p class="card-text">Média de Aulas/Dia</p>
                            <small class="text-danger" id="ocupacaoAulas">
                                <i class="fas fa-users me-1"></i>0%
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos Principais -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Faturamento Mensal</h5>
                    <select class="form-select form-select-sm w-auto" id="tipoFaturamento">
                        <option value="diario">Diário</option>
                        <option value="semanal" selected>Semanal</option>
                        <option value="mensal">Mensal</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="graficoFaturamento" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 5 Produtos Vendidos</h5>
                </div>
                <div class="card-body">
                    <div id="listaTopProdutos">
                        <!-- Carregado via JavaScript -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda Linha de Gráficos -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribuição de Alunos por Faixa Etária</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoFaixaEtaria" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Ocupação das Aulas</h5>
                    <select class="form-select form-select-sm w-auto" id="tipoAulaGrafico">
                        <option value="todos">Todas as Aulas</option>
                        <option value="muay_thai">Muay Thai</option>
                        <option value="jiu_jitsu">Jiu Jitsu</option>
                        <option value="crossfit">CrossFit</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="graficoOcupacaoAulas" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabelas Detalhadas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Últimas Matrículas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="tabelaMatriculas">
                            <thead>
                                <tr>
                                    <th>Aluno</th>
                                    <th>Data</th>
                                    <th>Plano</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Carregado via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produtos com Baixo Estoque</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="tabelaBaixoEstoque">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Estoque</th>
                                    <th>Mínimo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Carregado via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Relatórios Pré-Definidos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Relatórios Pré-Definidos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card report-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-invoice-dollar fa-3x text-primary mb-3"></i>
                                    <h6>Relatório Financeiro</h6>
                                    <p class="small text-muted">Receitas, despesas e lucro</p>
                                    <button class="btn btn-outline-primary btn-sm" onclick="gerarRelatorioFinanceiro()">
                                        Gerar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card report-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                                    <h6>Relatório de Alunos</h6>
                                    <p class="small text-muted">Ativos, inativos e evasão</p>
                                    <button class="btn btn-outline-success btn-sm" onclick="gerarRelatorioAlunos()">
                                        Gerar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card report-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-dumbbell fa-3x text-info mb-3"></i>
                                    <h6>Relatório de Aulas</h6>
                                    <p class="small text-muted">Frequência e ocupação</p>
                                    <button class="btn btn-outline-info btn-sm" onclick="gerarRelatorioAulas()">
                                        Gerar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card report-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-boxes fa-3x text-warning mb-3"></i>
                                    <h6>Relatório de Estoque</h6>
                                    <p class="small text-muted">Vendas e reposição</p>
                                    <button class="btn btn-outline-warning btn-sm" onclick="gerarRelatorioEstoque()">
                                        Gerar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <div id="configuracoes" class="page-section">
<div class="content-header">
    <h1 class="page-title">
        <i class="fas fa-cog me-2"></i>
        Configurações do Sistema
    </h1>
    <p class="page-subtitle">Configure parâmetros e preferências do sistema</p>
</div>

<!-- Tabs de Configurações -->
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="configTabs">
            <li class="nav-item">
                <a class="nav-link active" href="#config-geral" data-bs-toggle="tab">
                    <i class="fas fa-sliders-h me-2"></i>Geral
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#config-filiais" data-bs-toggle="tab">
                    <i class="fas fa-store me-2"></i>Filiais
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#config-email" data-bs-toggle="tab">
                    <i class="fas fa-envelope me-2"></i>Email
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#config-pagamentos" data-bs-toggle="tab">
                    <i class="fas fa-credit-card me-2"></i>Pagamentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#config-usuarios" data-bs-toggle="tab">
                    <i class="fas fa-users-cog me-2"></i>Usuários
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#config-backup" data-bs-toggle="tab">
                    <i class="fas fa-database me-2"></i>Backup
                </a>
            </li>
        </ul>
    </div>
>>>>>>> db0edd69cb817f06719d3d605e150943deb6dbc6
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/config/auth.php';

$auth = Auth::getInstance();
$action = $_GET['action'] ?? 'dashboard';
$controller = $_GET['controller'] ?? 'dashboard';

// Se for logout
if ($action === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Se for login, mostrar página de login
if ($action === 'login' || $action === 'doLogin') {
    if ($action === 'doLogin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if ($auth->loginAdmin($usuario, $senha)) {
            header('Location: admin.php?controller=dashboard&action=index');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos';
            require_once __DIR__ . '/views/admin/login.php';
        }
    } else {
        require_once __DIR__ . '/views/admin/login.php';
    }
    exit;
}

// Se não estiver logado e não for login/logout, redirecionar
if (!$auth->isAdmin() && $action !== 'login' && $action !== 'doLogin' && $action !== 'logout') {
    header('Location: admin.php?action=login');
    exit;
}

// Requer autenticação admin para outras ações (exceto login/logout)
if ($action !== 'login' && $action !== 'doLogin' && $action !== 'logout') {
    $auth->requireAdmin();
}

// Roteamento para área administrativa
$controllers = [
    'dashboard' => 'DashboardController',
    'aluno' => 'AlunoController',
    'professor' => 'ProfessorController',
    'aula' => 'AulaController',
    'plano' => 'PlanoController',
    'filial' => 'FilialController',
    'produto' => 'ProdutoController',
    'avaliacao' => 'AvaliacaoController'
];

$controllerName = $controllers[$controller] ?? 'DashboardController';

if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die("Ação '{$action}' não encontrada no controller '{$controllerName}'");
    }
} else {
    die("Controller '{$controllerName}' não encontrado");
}
?>
