<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/sidebars.css">
    <title>Sidebars</title>
</head>
<body>
    <nav class="techfit-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-tachometer-alt"></i>
                    Painel de Controle
                </div>
            </div>

            <!-- Menu de Navegação -->
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-section="geral" onclick="mostrarSecao('geral'); return false;">
                        <i class="nav-icon fas fa-home"></i>
                        Visão Geral
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="alunos" onclick="mostrarSecao('alunos'); return false;">
                        <i class="nav-icon fas fa-users"></i>
                        Alunos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="treino" onclick="mostrarSecao('treino'); return false;">
                        <i class="nav-icon fas fa-dumbbell"></i>
                        Treinos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="instrutores" onclick="mostrarSecao('instrutores'); return false;">
                        <i class="nav-icon fas fa-user-tie"></i>
                        Instrutores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="produtos" onclick="mostrarSecao('produtos'); return false;">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="relatorios" onclick="mostrarSecao('relatorios'); return false;">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        Relatórios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="config" onclick="mostrarSecao('config'); return false;">
                        <i class="nav-icon fas fa-cog"></i>
                        Configurações
                    </a>
                </li>
            </ul>
        </nav>
</body>
</html>