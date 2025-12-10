<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../public/css/headerUser.css">
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
                <?php
                $nomeCompleto = $aluno['NOME_ALUNO'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <h4 class="cliente-ola">Olá, <span class="cliente-nome"><?= htmlspecialchars($primeiroNome) ?></span></h4>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="../public/loginCliente.php"><i
                                class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </header>

</body>

</html>