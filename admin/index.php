<?php
/**
 * Página inicial do TechFit
 * Redireciona para área do cliente ou administração
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFit - Sistema de Gestão de Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem;
            text-align: center;
        }
        .welcome-body {
            padding: 3rem;
        }
        .access-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
        }
        .access-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        .access-card .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .btn-access {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            margin-top: 1rem;
        }
        .btn-access:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <div class="welcome-header">
            <i class="bi bi-activity" style="font-size: 4rem;"></i>
            <h1 class="mt-3 mb-0">TechFit</h1>
            <p class="mb-0">Sistema de Gestão de Academia</p>
        </div>
        <div class="welcome-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="access-card">
                        <div class="icon text-primary">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h3>Área do Cliente</h3>
                        <p class="text-muted">Acesse sua conta para visualizar seu perfil, avaliações físicas e plano ativo.</p>
                        <a href="cliente.php?action=login" class="btn btn-primary btn-access">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar como Cliente
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="access-card">
                        <div class="icon text-danger">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3>Área Administrativa</h3>
                        <p class="text-muted">Acesse o painel administrativo para gerenciar alunos, professores, planos e muito mais.</p>
                        <a href="admin.php?action=login" class="btn btn-danger btn-access">
                            <i class="bi bi-shield-check"></i> Entrar como Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

