<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/controllers/AdministradorController.php';
$controller = new AdministradorController();

// Processar login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'logar') {
    $user = trim($_POST['usuario'] ?? '');
    $senhaDigitada = trim($_POST['senha'] ?? '');

    if (empty($user) || empty($senhaDigitada)) {
        header('Location: loginAdm.php?erro=1');
        exit;
    }

    try {
        $admin = $controller->buscarPorUsuario($user);

        if ($admin && $admin->getSenha() === $senhaDigitada) {
            // Login bem-sucedido
            $_SESSION['usuario'] = $admin->getUser();
            $_SESSION['admin_id'] = $admin->getId();
            $_SESSION['logado'] = true;

            header('Location: telaAdministrador.php');
            exit;
        }

        // Login errado
        header('Location: loginAdm.php?erro=1');
        exit;

    } catch (Exception $e) {
        error_log("Erro no login admin: " . $e->getMessage());
        header('Location: loginAdm.php?erro=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFit - Login Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --verde-escuro: #1E5332;
            --verde-claro: #68A842;
        }

        body {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, var(--verde-claro) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, var(--verde-claro) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-body {
            padding: 2rem;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, var(--verde-claro) 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 83, 50, 0.4);
        }

        .form-control:focus {
            border-color: var(--verde-claro);
            box-shadow: 0 0 0 0.2rem rgba(104, 168, 66, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
            <h2 class="mt-3 mb-0">TechFit</h2>
            <p class="mb-0">Área Administrativa</p>
        </div>
        <div class="login-body">
            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <?php if ($_GET['erro'] == '2'): ?>
                        Acesso negado. Faça login para continuar.
                    <?php else: ?>
                        Usuário ou senha inválidos
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="acao" value="logar">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="loginCliente.php" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Voltar para Login do Cliente
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>