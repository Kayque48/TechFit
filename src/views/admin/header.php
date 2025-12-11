<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/headerAdmin.css">
    <title>Header - Admin</title>
</head>
<body>
<header class="techfit-header">
        <div class="header-container">
            <!-- Logo -->
            <a href="" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                TechFit Admin
            </a>

            <!-- Barra de busca -->
            <form class="search-form" role="search">
                <input type="search" class="form-control" placeholder="Buscar produtos, alunos, relatórios...">
            </form>

            <!-- Menu do usuário -->
            <div class="user-menu dropdown">
                <?php
                $nomeCompleto = $Admin['USER'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <a class="nav-link text-danger" href="admin.php?action=logout"
                    onclick="return confirm('Deseja realmente sair?')">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
                <h4 class="adm-ola">Olá, <span class="adm-nome"><?= htmlspecialchars($primeiroNome) ?></span></h4>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </header>
    
</body>
</html>