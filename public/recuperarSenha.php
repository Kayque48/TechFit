<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inicia sessão
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/../src/controllers/AlunoController.php';
    $controller = new AlunoController();

    $mensagem = '';
    $tipoMensagem = '';

    // Processar recuperação de senha
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['etapa'])) {
            
            // ETAPA 1: Verificar email
            if ($_POST['etapa'] == '1') {
                $email = trim($_POST['email'] ?? '');
                
                if (empty($email)) {
                    $mensagem = 'Por favor, insira um email válido';
                    $tipoMensagem = 'danger';
                } elseif (!$controller->getDAO()->emailExiste($email)) {
                    $mensagem = 'Email não encontrado no sistema';
                    $tipoMensagem = 'danger';
                } else {
                    // Email encontrado - simular envio
                    $mensagem = 'Verifique seu email para redefinir a senha! (Para teste, use a etapa 2)';
                    $tipoMensagem = 'success';
                    $_SESSION['email_recuperacao'] = $email;
                }
            }
            
            // ETAPA 2: Redefinir senha
            elseif ($_POST['etapa'] == '2') {
                $email = $_SESSION['email_recuperacao'] ?? '';
                $novaSenha = $_POST['nova_senha'] ?? '';
                $confirmarSenha = $_POST['confirmar_senha'] ?? '';
                
                if (empty($novaSenha) || empty($confirmarSenha)) {
                    $mensagem = 'Preencha todos os campos de senha';
                    $tipoMensagem = 'danger';
                } elseif ($novaSenha !== $confirmarSenha) {
                    $mensagem = 'As senhas não correspondem';
                    $tipoMensagem = 'danger';
                } elseif (strlen($novaSenha) < 6) {
                    $mensagem = 'A senha deve ter no mínimo 6 caracteres';
                    $tipoMensagem = 'danger';
                } else {
                    try {
                        // Hash da nova senha
                        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                        
                        // Buscar usuário por email e atualizar
                        $aluno = $controller->buscarPorEmail($email);
                        if ($aluno) {
                            // UPDATE direto no banco
                            $dao = $controller->getDAO();
                            $dao->atualizarSenha($email, $senhaHash);
                            
                            unset($_SESSION['email_recuperacao']);
                            $mensagem = 'Senha redefinida com sucesso! Redirecionando...';
                            $tipoMensagem = 'success';
                            header('refresh:3;url=loginCliente.php?recuperacao=sucesso');
                        }
                    } catch (Exception $e) {
                        $mensagem = 'Erro ao redefinir senha: ' . $e->getMessage();
                        $tipoMensagem = 'danger';
                    }
                }
            }
        }
    }

    $emailVerificado = isset($_SESSION['email_recuperacao']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  
  
  <!-- Estilos customizados -->
  <link rel="stylesheet" href="css/styleCadProduto.css">
  
  <title>Recuperar Senha - TechFit</title>
  <style>
    body {
        background: linear-gradient(135deg, #1E5332 0%, #68A842 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .recovery-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        max-width: 450px;
        width: 100%;
        padding: 3rem 2.5rem;
        position: relative;
        border-top: 6px solid #68A842;
    }

    .recovery-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .recovery-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #68A842, #5a9438);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .recovery-header h2 {
        color: #1E5332;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .recovery-header p {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .back-link {
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: #6c757d;
        cursor: pointer;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: #1E5332;
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #1E5332;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: white;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #0093D1;
        box-shadow: 0 0 0 0.2rem rgba(0, 147, 209, 0.15);
        transform: translateY(-2px);
    }

    .alert-custom {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success-custom {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger-custom {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .btn-recovery {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, #68A842, #5a9438);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-recovery:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(104, 168, 66, 0.3);
    }

    .progress-steps {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        justify-content: center;
    }

    .step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        background: #e9ecef;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .step.active {
        background: #68A842;
        color: white;
    }

    .step.completed {
        background: #68A842;
        color: white;
    }

    .divider-line {
        text-align: center;
        margin: 1.5rem 0;
        color: #6c757d;
    }

    .divider-line a {
        color: #0093D1;
        text-decoration: none;
        font-weight: 500;
    }

    .divider-line a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="recovery-container">
    <a href="loginCliente.php" class="back-link" title="Voltar ao login">
      <i class="fas fa-times"></i>
    </a>

    <div class="recovery-header">
      <div class="recovery-icon">
        <i class="fas fa-key"></i>
      </div>
      <h2>Recuperar Senha</h2>
      <p>Redefinir sua senha TechFit</p>
    </div>

    <!-- Progress Steps -->
    <div class="progress-steps">
      <div class="step <?= !$emailVerificado ? 'active' : 'completed' ?>">1</div>
      <div class="step <?= $emailVerificado ? 'active' : '' ?>">2</div>
    </div>

    <!-- Mensagens -->
    <?php if (!empty($mensagem)): ?>
    <div class="alert-custom alert-<?= $tipoMensagem ?>-custom">
      <i class="fas fa-<?= $tipoMensagem === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
      <span><?= htmlspecialchars($mensagem) ?></span>
    </div>
    <?php endif; ?>

    <!-- ETAPA 1: Verificar Email -->
    <?php if (!$emailVerificado): ?>
    <form action="" method="POST">
      <input type="hidden" name="etapa" value="1">
      
      <div class="form-group">
        <label for="email" class="form-label">
          <i class="fas fa-envelope"></i> Email cadastrado
        </label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          class="form-control-custom" 
          placeholder="seu@email.com"
          required
        >
      </div>

      <button type="submit" class="btn-recovery">
        <i class="fas fa-arrow-right me-2"></i> Próximo
      </button>
    </form>

    <!-- ETAPA 2: Nova Senha -->
    <?php else: ?>
    <form action="" method="POST">
      <input type="hidden" name="etapa" value="2">
      
      <div class="form-group">
        <label for="nova_senha" class="form-label">
          <i class="fas fa-lock"></i> Nova Senha
        </label>
        <input 
          type="password" 
          id="nova_senha" 
          name="nova_senha" 
          class="form-control-custom" 
          placeholder="Digite uma nova senha"
          minlength="6"
          required
        >
        <small class="text-muted">Mínimo 6 caracteres</small>
      </div>

      <div class="form-group">
        <label for="confirmar_senha" class="form-label">
          <i class="fas fa-lock"></i> Confirmar Senha
        </label>
        <input 
          type="password" 
          id="confirmar_senha" 
          name="confirmar_senha" 
          class="form-control-custom" 
          placeholder="Confirme a nova senha"
          minlength="6"
          required
        >
      </div>

      <button type="submit" class="btn-recovery">
        <i class="fas fa-check me-2"></i> Redefinir Senha
      </button>

      <div class="divider-line">
        <a href="recuperarSenha.php">← Voltar</a>
      </div>
    </form>
    <?php endif; ?>

    <div class="divider-line mt-3">
      Lembrou a senha? <a href="loginCliente.php">Voltar ao login</a>
    </div>
  </div>

</body>
</html>
