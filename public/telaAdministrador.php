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
    
    <div class="card-body">
        <div class="tab-content">
            
            <!-- Tab: Configurações Gerais -->
            <div class="tab-pane fade show active" id="config-geral">
                <h5 class="mb-4">Configurações Gerais do Sistema</h5>
                <form id="formConfigGeral">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomeAcademia" class="form-label">Nome da Academia</label>
                                <input type="text" class="form-control" id="nomeAcademia" value="TechFit Academia">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" placeholder="00.000.000/0000-00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefoneEmpresa" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefoneEmpresa" placeholder="(00) 0000-0000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailEmpresa" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailEmpresa" placeholder="contato@techfit.com">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="enderecoEmpresa" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="enderecoEmpresa" placeholder="Rua, Número - Bairro">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="horaAbertura" class="form-label">Horário de Abertura</label>
                                <input type="time" class="form-control" id="horaAbertura" value="06:00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="horaFechamento" class="form-label">Horário de Fechamento</label>
                                <input type="time" class="form-control" id="horaFechamento" value="22:00">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="logoEmpresa" class="form-label">Logo da Empresa</label>
                        <input type="file" class="form-control" id="logoEmpresa" accept="image/*">
                        <small class="text-muted">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="modoManutencao">
                            <label class="form-check-label" for="modoManutencao">
                                Modo Manutenção (desativa acesso de alunos)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Configurações
                    </button>
                </form>
            </div>

            <!-- Tab: Filiais -->
            <div class="tab-pane fade" id="config-filiais">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Gestão de Filiais</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaFilial">
                        <i class="fas fa-plus me-2"></i>Nova Filial
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>Capacidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaFiliais">
                            <tr>
                                <td>1</td>
                                <td>TechFit Centro</td>
                                <td>Av. Principal, 100 - Centro</td>
                                <td>(19) 3000-0001</td>
                                <td>200 alunos</td>
                                <td><span class="badge bg-success">Ativa</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>TechFit Zona Sul</td>
                                <td>Rua das Flores, 50 - Jardim</td>
                                <td>(19) 3000-0002</td>
                                <td>150 alunos</td>
                                <td><span class="badge bg-success">Ativa</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab: Email -->
            <div class="tab-pane fade" id="config-email">
                <h5 class="mb-4">Configurações de Email</h5>
                <form id="formConfigEmail">
                    <div class="mb-3">
                        <label for="smtpHost" class="form-label">Servidor SMTP</label>
                        <input type="text" class="form-control" id="smtpHost" placeholder="smtp.gmail.com">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="smtpPort" class="form-label">Porta</label>
                                <input type="number" class="form-control" id="smtpPort" value="587">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="smtpEncrypt" class="form-label">Criptografia</label>
                                <select class="form-select" id="smtpEncrypt">
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                    <option value="">Nenhuma</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="smtpUser" class="form-label">Usuário/Email</label>
                        <input type="email" class="form-control" id="smtpUser" placeholder="contato@techfit.com">
                    </div>

                    <div class="mb-3">
                        <label for="smtpPass" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="smtpPass" placeholder="••••••••">
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary" onclick="testarEmail()">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Email de Teste
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Configurações
                    </button>
                </form>
            </div>

            <!-- Tab: Pagamentos -->
            <div class="tab-pane fade" id="config-pagamentos">
                <h5 class="mb-4">Métodos de Pagamento</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Cartão de Crédito</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pagCartao" checked>
                                    </div>
                                </div>
                                <p class="text-muted small mb-0">Aceitar pagamentos com cartão de crédito</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0"><i class="fas fa-barcode me-2"></i>Boleto Bancário</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pagBoleto" checked>
                                    </div>
                                </div>
                                <p class="text-muted small mb-0">Aceitar pagamentos via boleto</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0"><i class="fas fa-qrcode me-2"></i>PIX</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pagPix" checked>
                                    </div>
                                </div>
                                <p class="text-muted small mb-0">Aceitar pagamentos via PIX</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0"><i class="fas fa-money-bill me-2"></i>Dinheiro</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pagDinheiro" checked>
                                    </div>
                                </div>
                                <p class="text-muted small mb-0">Aceitar pagamentos em dinheiro</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="mb-3">Gateway de Pagamento</h6>
                <form>
                    <div class="mb-3">
                        <label for="gatewayPagamento" class="form-label">Provedor</label>
                        <select class="form-select" id="gatewayPagamento">
                            <option value="">Selecione...</option>
                            <option value="mercadopago">Mercado Pago</option>
                            <option value="pagseguro">PagSeguro</option>
                            <option value="stripe">Stripe</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="apiKey" class="form-label">API Key</label>
                        <input type="password" class="form-control" id="apiKey" placeholder="Digite sua chave de API">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Configurações
                    </button>
                </form>
            </div>

            <!-- Tab: Usuários do Sistema -->
            <div class="tab-pane fade" id="config-usuarios">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Usuários do Sistema</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                        <i class="fas fa-user-plus me-2"></i>Novo Usuário
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Status</th>
                                <th>Último Acesso</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Administrador</td>
                                <td>admin@techfit.com</td>
                                <td><span class="badge bg-danger">Administrador</span></td>
                                <td><span class="badge bg-success">Ativo</span></td>
                                <td>Hoje, 10:30</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-user-lock"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Maria Silva</td>
                                <td>maria@techfit.com</td>
                                <td><span class="badge bg-primary">Gerente</span></td>
                                <td><span class="badge bg-success">Ativo</span></td>
                                <td>Ontem, 18:45</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-user-lock"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab: Backup -->
            <div class="tab-pane fade" id="config-backup">
                <h5 class="mb-4">Backup e Segurança</h5>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-download me-2"></i>Backup Manual</h6>
                                <p class="card-text text-muted">Faça backup completo do sistema agora</p>
                                <button class="btn btn-primary" onclick="fazerBackup()">
                                    <i class="fas fa-download me-2"></i>Fazer Backup Agora
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-upload me-2"></i>Restaurar Backup</h6>
                                <p class="card-text text-muted">Restaure dados de um backup anterior</p>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalRestaurar">
                                    <i class="fas fa-upload me-2"></i>Restaurar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="mb-3">Backup Automático</h6>
                <form>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="backupAuto" checked>
                            <label class="form-check-label" for="backupAuto">
                                Ativar backup automático
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="frequenciaBackup" class="form-label">Frequência</label>
                        <select class="form-select" id="frequenciaBackup">
                            <option value="diario">Diário</option>
                            <option value="semanal" selected>Semanal</option>
                            <option value="mensal">Mensal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="horaBackup" class="form-label">Horário</label>
                        <input type="time" class="form-control" id="horaBackup" value="02:00">
                        <small class="text-muted">Backup será realizado automaticamente neste horário</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Configurações
                    </button>
                </form>

                <hr class="my-4">

                <h6 class="mb-3">Histórico de Backups</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Tipo</th>
                                <th>Tamanho</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09/12/2025 02:00</td>
                                <td>Automático</td>
                                <td>245 MB</td>
                                <td><span class="badge bg-success">Sucesso</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Download"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>02/12/2025 02:00</td>
                                <td>Automático</td>
                                <td>243 MB</td>
                                <td><span class="badge bg-success">Sucesso</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Download"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
            </div>

        </main>
    </div>

    <!-- Modal de Cadastro de Aluno -->
    <div class="modal fade" id="modalCadastroAluno" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Novo Aluno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCadastroAluno">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomeAluno" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nomeAluno" name="nomeAluno" required maxlength="80">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="idadeAluno" class="form-label">Idade *</label>
                                    <input type="number" class="form-control" id="idadeAluno" name="idadeAluno" required min="16" max="100">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="enderecoAluno" class="form-label">Endereço *</label>
                            <input type="text" class="form-control" id="enderecoAluno" name="enderecoAluno" required maxlength="80">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefoneAluno" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefoneAluno" name="telefoneAluno" maxlength="19" placeholder="(11) 99999-9999">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailAluno" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="emailAluno" name="emailAluno" required maxlength="50">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="avaliacaoAluno" class="form-label">Status da Avaliação Física *</label>
                            <select class="form-select" id="avaliacaoAluno" name="avaliacaoAluno" required>
                                <option value="">Selecione...</option>
                                <option value="PENDENTE">Pendente</option>
                                <option value="AGENDADA">Agendada</option>
                                <option value="REALIZADA">Realizada</option>
                                <option value="REAGENDAR">Precisa Reagendar</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSalvarAluno">Salvar Aluno</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sistema de navegação entre páginas (show/hide)
    function showPage(pageId) {
        // Esconder todas as páginas
        document.querySelectorAll('.page-section').forEach(page => {
            page.classList.remove('active');
        });
        
        // Remover classe active de todos os links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        // Mostrar página selecionada
        document.getElementById(pageId).classList.add('active');
        
        // Ativar link correspondente
        event.target.classList.add('active');
        
        // Se for a página de alunos, carregar os dados
        if (pageId === 'alunos') {
            carregarDadosAlunos();
        }
    }

    // Sistema de seleção de status no formulário de produtos
    document.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // exemplo carregar produtos
async function carregarProdutos() {
    const res = await fetch('/techfit-backend/api/produtos.php');
    const produtos = await res.json();
    // popular tabela do front
    console.log(produtos);
}

// cadastrar produto (chamar no submit)
async function cadastrarProduto(payload) {
    const res = await fetch('/techfit-backend/api/produtos.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
    });
    return await res.json();
}
async function gerarGraficoAlunosPorFilial(ctx) {
    const res = await fetch('/techfit-backend/api/relatorios.php');
    const json = await res.json();
    // usar Chart.js
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: json.labels,
            datasets: [{
                label: 'Alunos por Filial',
                data: json.values,
                // cores e opções você define no front
            }]
        },
        options: {}
    });
}
// Carregar dados dos instrutores
async function carregarDadosInstrutores() {
    try {
        // Implementar chamada à API no futuro
        // const response = await fetch('/api/instrutores.php');
        // const data = await response.json();
        
        // Mock de dados para demonstração
        setTimeout(() => {
            const tbody = document.querySelector('#tabelaInstrutores tbody');
            tbody.innerHTML = `
                <tr>
                    <td>1</td>
                    <td><img src="https://via.placeholder.com/40" class="rounded-circle" alt="Instrutor"></td>
                    <td>Carlos Silva</td>
                    <td><span class="badge bg-primary me-1">Muay Thai</span><span class="badge bg-success">CrossFit</span></td>
                    <td>(11) 98765-4321</td>
                    <td>carlos@techfit.com</td>
                    <td>Centro, Zona Sul</td>
                    <td><i class="fas fa-star text-warning"></i> 4.8</td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" title="Visualizar"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img src="https://via.placeholder.com/40" class="rounded-circle" alt="Instrutor"></td>
                    <td>Marina Santos</td>
                    <td><span class="badge bg-info me-1">Pilates</span><span class="badge bg-warning">Yoga</span></td>
                    <td>(11) 97654-3210</td>
                    <td>marina@techfit.com</td>
                    <td>Centro</td>
                    <td><i class="fas fa-star text-warning"></i> 4.9</td>
                    <td><span class="badge bg-success">Ativo</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" title="Visualizar"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            
            // Atualizar estatísticas
            document.getElementById('totalInstrutores').textContent = '12';
            document.getElementById('instrutoresAtivos').textContent = '10';
            document.getElementById('aulasHoje').textContent = '24';
            document.getElementById('mediaAvaliacao').textContent = '4.7';
        }, 500);
    } catch (error) {
        console.error('Erro ao carregar instrutores:', error);
    }
}

// Salvar instrutor
document.getElementById('btnSalvarInstrutor')?.addEventListener('click', async function() {
    const form = document.getElementById('formCadastroInstrutor');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Coletar especialidades selecionadas
    const especialidades = [];
    document.querySelectorAll('#formCadastroInstrutor input[type="checkbox"]:checked').forEach(cb => {
        especialidades.push(cb.value);
    });

    const instrutor = {
        nome: document.getElementById('nomeInstrutor').value,
        cpf: document.getElementById('cpfInstrutor').value,
        email: document.getElementById('emailInstrutor').value,
        telefone: document.getElementById('telefoneInstrutor').value,
        especialidades: especialidades,
        dataAdmissao: document.getElementById('dataAdmissao').value,
        status: document.getElementById('statusInstrutor').value,
        observacoes: document.getElementById('observacoes').value
    };

    try {
        // Implementar chamada à API no futuro
        // const response = await fetch('/api/instrutores.php', {
        //     method: 'POST',
        //     headers: {'Content-Type': 'application/json'},
        //     body: JSON.stringify(instrutor)
        // });
        
        console.log('Dados do instrutor:', instrutor);
        alert('Instrutor cadastrado com sucesso!');
        bootstrap.Modal.getInstance(document.getElementById('modalCadastroInstrutor')).hide();
        form.reset();
        carregarDadosInstrutores();
    } catch (error) {
        console.error('Erro ao salvar instrutor:', error);
        alert('Erro ao cadastrar instrutor. Tente novamente.');
    }
});
function testarEmail() {
    alert('Enviando email de teste...');
    // Implementar chamada à API
}

function fazerBackup() {
    if (confirm('Deseja iniciar o backup agora? Isso pode levar alguns minutos.')) {
        alert('Backup iniciado! Você será notificado quando concluir.');
        // Implementar chamada à API
    }
}

// Salva configurações gerais
document.getElementById('formConfigGeral')?.addEventListener('submit', function(e) {
    e.preventDefault();
    // Implementar salvamento
    alert('Configurações salvas com sucesso!');
});

// Salva configurações de email
document.getElementById('formConfigEmail')?.addEventListener('submit', function(e) {
    e.preventDefault();
    // Implementar salvamento
    alert('Configurações de email salvas com sucesso!');
});

</script>
    
</body>
</html>
