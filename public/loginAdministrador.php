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

// Processar login do admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'logar_admin') {
    $user = trim($_POST['user'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    
    if (empty($user) || empty($senha)) {
        header('Location: loginAdministrador.php?erro=1');
        exit;
    }

    try {
        // Buscar admin pelo usuário
        $admins = $controller->ler();
        $adminEncontrado = null;
        
        foreach ($admins as $admin) {
            if ($admin->getUser() === $user) {
                $adminEncontrado = $admin;
                break;
            }
        }
        
        if ($adminEncontrado && password_verify($senha, $adminEncontrado->getSenha())) {
            // Login bem-sucedido
            $_SESSION['admin_user'] = $adminEncontrado->getUser();
            $_SESSION['admin_id'] = $adminEncontrado->getId();
            $_SESSION['admin_logado'] = true;
            
            header('Location: telaAdministrador.php');
            exit;
        } else {
            header('Location: loginAdministrador.php?erro=1');
            exit;
        }
    } catch (Exception $e) {
        header('Location: loginAdministrador.php?erro=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - TechFit</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1E5332 0%, #68A842 100%);
            padding: 1rem;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-brand {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: #FBC70B;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }

        .login-brand h1 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .login-brand p {
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
        }

        .login-form-container {
            padding: 3rem;
        }

        .login-form-header {
            margin-bottom: 2rem;
        }

        .login-form-header h2 {
            color: #dc3545;
            margin-bottom: 0.5rem;
        }

        .login-form-header p {
            color: #6c757d;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #1E5332;
            margin-bottom: 0.5rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .input-with-icon input {
            padding-left: 3rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(220, 53, 69, 0.3);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: #fee;
            color: #c00;
            border: 1px solid #fcc;
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
        }

        .back-link a {
            color: #68A842;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-brand {
                padding: 2rem;
            }

            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Brand Section -->
        <div class="login-brand">
            <div class="login-logo">
                <i class="fas fa-user-shield"></i>
            </div>
            <h1>TechFit Admin</h1>
            <p>Painel de Administração</p>
        </div>

        <!-- Login Form -->
        <div class="login-form-container">
            <div class="login-form-header">
                <h2>Login do Administrador</h2>
                <p>Acesso restrito à equipe administrativa</p>
            </div>

            <?php if(isset($_GET['erro'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Usuário ou senha incorretos
            </div>
            <?php endif; ?>

            <form action="" method="POST">
                <input type="hidden" name="acao" value="logar_admin">
                
                <div class="form-group">
                    <label for="user">Usuário</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            id="user" 
                            name="user" 
                            class="form-input" 
                            placeholder="Digite seu usuário"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            class="form-input" 
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Entrar como Admin
                </button>

                <div class="back-link">
                    <a href="loginCliente.php">
                        <i class="fas fa-arrow-left me-1"></i>
                        Voltar para login de cliente
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>