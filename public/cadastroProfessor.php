<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se o admin está logado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: loginAdm.php?erro=2');
    exit;
}

require_once __DIR__ . '/../src/controllers/ProfessorController.php';
$controller = new ProfessorController();

$mensagem = '';
$tipoMensagem = '';

// Processar cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] == 'criar') {
        $nome = trim($_POST['nome'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $especialidade = trim($_POST['especialidade'] ?? '');

        if (!empty($nome) && !empty($especialidade)) {
            try {
                $controller->criar($nome, $cpf, $especialidade);
                $mensagem = 'Professor cadastrado com sucesso!';
                $tipoMensagem = 'sucesso';
            } catch (Exception $e) {
                $mensagem = 'Erro ao cadastrar: ' . $e->getMessage();
                $tipoMensagem = 'erro';
            }
        } else {
            $mensagem = 'Preencha todos os campos obrigatórios';
            $tipoMensagem = 'erro';
        }
    }
}

$Admin = ['USER' => $_SESSION['usuario']];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor - TechFit</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            background: linear-gradient(135deg, var(--gray-light) 0%, #e8f4f8 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Header */
        .techfit-header {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, #2a7a4a 100%);
            color: white;
            padding: 1.25rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 1.6rem;
            gap: 1rem;
        }

        .logo-icon {
            background: var(--amarelo);
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--verde-escuro);
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(251, 199, 11, 0.3);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .admin-name {
            color: var(--amarelo);
            font-weight: 700;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: var(--laranja);
            border-color: var(--laranja);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(233, 93, 41, 0.4);
        }

        /* Card do formulário */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin: 2rem auto;
            max-width: 900px;
            animation: fadeIn 0.6s ease-out;
        }

        .form-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--verde-claro);
        }

        .form-card-title {
            color: var(--verde-escuro);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        /* Alertas */
        .alert-custom {
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.4s ease-out;
        }

        .alert-sucesso {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .alert-erro {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: var(--verde-escuro);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required::after {
            content: " *";
            color: var(--laranja);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--azul);
            box-shadow: 0 0 0 0.2rem rgba(0, 147, 209, 0.15);
            transform: translateY(-2px);
        }

        /* Botões */
        .btn-group-custom {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 0.85rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--verde-claro), #5a9438);
            color: white;
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, #6c757d, #545b62);
            color: white;
        }

        .info-box {
            background: rgba(0, 147, 209, 0.1);
            border-left: 4px solid var(--azul);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            margin: 0;
            color: #0c5460;
            font-size: 0.95rem;
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .form-card {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn-group-custom {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
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
                <span>TechFit Admin</span>
            </a>

            <div class="user-info">
                <?php
                $nomeCompleto = $Admin['USER'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <span class="admin-greeting">
                    Olá, <span class="admin-name"><?= htmlspecialchars($primeiroNome) ?></span>
                </span>
                <a class="btn-logout" href="telaAdministrador.php?action=logout"
                    onclick="return confirm('Deseja realmente sair?')">
                    <i class="fas fa-sign-out-alt"></i>
                    Sair
                </a>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="container">
        <div class="mt-4 mb-4">
            <a href="telaAdministrador.php" class="text-decoration-none d-flex align-items-center"
                style="color: var(--verde-escuro); font-weight: 600;">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar
            </a>
        </div>

        <?php if ($mensagem): ?>
            <div class="alert-custom alert-<?= $tipoMensagem ?>">
                <i class="fas fa-<?= $tipoMensagem === 'sucesso' ? 'check-circle' : 'exclamation-circle' ?> fa-lg"></i>
                <span><?= htmlspecialchars($mensagem) ?></span>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <div class="form-card-header">
                <h3 class="form-card-title">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Cadastrar Novo Professor
                </h3>
            </div>

            <div class="info-box">
                <p>
                    <i class="fas fa-info-circle me-2"></i>
                    Preencha os dados do professor que será responsável pelas aulas e treinos na academia.
                </p>
            </div>

            <form action="" method="post">
                <input type="hidden" name="acao" value="criar">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nome Completo</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nome"
                            placeholder="Ex: João Silva"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">CPF</label>
                        <input
                            type="text"
                            class="form-control"
                            name="cpf"
                            placeholder="000.000.000-00"
                            maxlength="14">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Especialidade</label>
                        <input
                            type="text"
                            class="form-control"
                            name="especialidade"
                            placeholder="Ex: Musculação, Yoga, CrossFit"
                            required>
                    </div>
                </div>

                <div class="btn-group-custom">
                    <button type="submit" class="btn-custom btn-primary-custom">
                        <i class="fas fa-save"></i>
                        Cadastrar Professor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Máscara de CPF
        const cpfInput = document.querySelector('input[name="cpf"]');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length <= 11) {
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                }
                
                e.target.value = value;
            });
        }
    </script>
</body>
</html>