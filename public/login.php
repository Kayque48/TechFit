<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/AdministradorController.php';
$controllerAdm = new AdministradorController();
$controllerAluno = new AlunoController();

// Processar login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'logar') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    
    if (empty($email) || empty($senha)) {
        header('Location: login.php?erro=1');
        exit;
    }

    // Verificar se é admin (@techfit.com.br)
    if (str_ends_with($email, '@techfit.com.br')) {
        try {
            require_once __DIR__ . '/../src/controllers/AdministradorController.php';
            $controllerAdm = new AdministradorController();
            
            $admin = $controllerAdm->buscarPorEmail($email);
            
            if ($admin && password_verify($senha, $admin['SENHA'])) {
                $_SESSION['email'] = $admin['EMAIL_ADM'];
                $_SESSION['nome'] = $admin['AUSER'];
                $_SESSION['tipo_usuario'] = 'admin';
                $_SESSION['logado'] = true;
                
                header('Location: telaAdministrador.php');
                exit;
            }
        } catch (Exception $e) {
            // Log error
        }
    } else {
        // Login de cliente
        try {
            require_once __DIR__ . '/../src/controllers/AlunoController.php';
            $controllerAluno = new AlunoController();
            
            $aluno = $controllerAluno->buscarPorEmail($email);
            
            if ($aluno && password_verify($senha, $aluno['SENHA'])) {
                $_SESSION['email'] = $aluno['EMAIL'];
                $_SESSION['nome'] = $aluno['NOME_ALUNO'];
                $_SESSION['tipo_usuario'] = 'cliente';
                $_SESSION['logado'] = true;
                
                header('Location: telaCliente.php');
                exit;
            }
        } catch (Exception $e) {
            // Log error
        }
    }
    
    header('Location: login.php?erro=1');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechFit</title>
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-brand {
            background: linear-gradient(135deg, #1E5332 0%, #2a7a4a 100%);
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
            color: #1E5332;
            margin-bottom: 1.5rem;
        }

        .login-brand h1 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .login-brand p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .login-form-container {
            padding: 3rem;
        }

        .login-form-header {
            margin-bottom: 2rem;
        }

        .login-form-header h2 {
            color: #1E5332;
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
            border-color: #0093D1;
            box-shadow: 0 0 0 3px rgba(0, 147, 209, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .forgot-password {
            color: #0093D1;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #0093D1 0%, #007bb8 100%);
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
            box-shadow: 0 8px 16px rgba(0, 147, 209, 0.3);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #6c757d;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #e9ecef;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .signup-link {
            text-align: center;
            color: #6c757d;
        }

        .signup-link a {
            color: #68A842;
            font-weight: 600;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
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

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
                <i class="fas fa-dumbbell"></i>
            </div>
            <h1>TechFit</h1>
            <p>Transforme seu corpo, transforme sua vida</p>
        </div>

        <!-- Login Form -->
        <div class="login-form-container">
            <div class="login-form-header">
                <h2>Bem-vindo de volta!</h2>
                <p>Entre com suas credenciais para acessar sua conta</p>
            </div>

            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Email ou senha incorretos
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['recuperacao']) && $_GET['recuperacao'] === 'sucesso'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Senha redefinida com sucesso! Faça login com sua nova senha.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Cadastro realizado com sucesso! Faça login com suas credenciais.
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <input type="hidden" name="acao" value="logar">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="seu@email.com"
                            required>
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
                            required>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="lembrar">
                        <span>Lembrar-me</span>
                    </label>
                    <a href="recuperarSenha.php" class="forgot-password">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>

                <div class="divider">ou</div>

                <div class="signup-link">
                    Não tem uma conta? <a href="cadastroCliente.php">Cadastre-se agora</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>