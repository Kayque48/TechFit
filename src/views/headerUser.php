<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.php">
    <title>Document</title>
</head>
<body>

    <header class="techfit-header">
        <div class="header-container">
            <!-- Logo -->
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                TechFit Cliente
            </a>

            <!-- Barra de busca -->
            <form class="search-form" role="search">
                <input type="search" class="form-control" placeholder="Buscar produtos, usuários, relatórios...">
            </form>

            <!-- Menu do usuário -->
            <div class="user-menu dropdown">
                <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://github.com/mdo.png" alt="Admin" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../public/cadUser.php"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </header>
    
</body>
</html>