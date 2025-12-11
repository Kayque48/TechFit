<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFit - Área do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <style>
        .cliente-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .cliente-sidebar {
            background: #f8f9fa;
            min-height: calc(100vh - 56px);
            padding: 1rem 0;
        }
        .cliente-sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1.5rem;
            border-radius: 0;
        }
        .cliente-sidebar .nav-link:hover,
        .cliente-sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark cliente-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="cliente.php?action=dashboard">
                <i class="bi bi-activity"></i> TechFit
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-white me-3">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['cliente_nome'] ?? 'Cliente'); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cliente.php?action=logout">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 cliente-sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'dashboard' ? 'active' : ''; ?>" 
                           href="cliente.php?action=dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'perfil' ? 'active' : ''; ?>" 
                           href="cliente.php?action=perfil">
                            <i class="bi bi-person"></i> Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'avaliacoes' ? 'active' : ''; ?>" 
                           href="cliente.php?action=avaliacoes">
                            <i class="bi bi-clipboard-data"></i> Minhas Avaliações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['action'] ?? '') === 'plano' ? 'active' : ''; ?>" 
                           href="cliente.php?action=plano">
                            <i class="bi bi-card-list"></i> Meu Plano
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 mt-4">

