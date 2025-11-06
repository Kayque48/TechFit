<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/sidebars.css">
    <title>Document</title>
</head>
<body>

 <nav class="techfit-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-tachometer-alt"></i>
                    Menu
                </div>
            </div>

            <!-- Menu de Navegação -->
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="mostrarSecao('geral'); return false;">
                        <i class="nav-icon fas fa-home"></i>
                        Visão Geral
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="mostrarSecao('plano'); return false;">
                        <i class="nav-icon fas fa-users"></i>
                        Plano
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="mostrarSecao('treino'); return false;">
                        <i class="nav-icon fas fa-dumbbell"></i>
                        Treino
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="mostrarSecao('ficha'); return false;">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        Ficha
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="mostrarSecao('config'); return false;">
                        <i class="nav-icon fas fa-cog"></i>
                        Configurações
                    </a>
                </li>
            </ul>
        </nav>
    
</body>
</html>