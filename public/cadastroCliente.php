<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../src/controllers/AlunoController.php';
    $controller = new AlunoController();

    // Processar cadastro
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastro'])) {
        if ($_POST['cadastro'] == 'criar') {
            // Validação básica
            $nome = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $endereco = trim($_POST['endereco'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $idade = intval($_POST['idade'] ?? 0);
            $plano = $_POST['plano'] ?? '';
            $senha = $_POST['senha'] ?? '';
            
            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            
            if (!empty($nome) && !empty($email) && !empty($endereco) && !empty($senha)) {
                try {
                    $controller->criar(
                        $nome,
                        $idade,
                        $endereco,
                        $telefone,
                        $email,
                        $avaliacao, // avaliacao vazia inicialmente
                        $plano,
                        $senhaHash
                    );
                    
                    // Redirecionar para login com sucesso
                    header('Location: loginCliente.php?cadastro=sucesso');
                    exit;
                } catch (Exception $e) {
                    $erro = "Erro ao cadastrar: " . $e->getMessage();
                }
            } else {
                $erro = "Preencha todos os campos obrigatórios";
            }
        }
    }
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
  <link rel="stylesheet" href="css/CadUser.css">
  
  <title>Cadastro de Clientes - TechFit</title>
</head>
<body>

<?php require_once('../src/views/header.php'); ?>

  <main class="container mt-4">
    
    <?php if (isset($erro)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($erro) ?>
    </div>
    <?php endif; ?>

    <div class="row g-3">
      <form action="" method="post">
        <input type="hidden" name="cadastro" value="criar">
        
        <!-- Nome -->
        <div class="col-sm-6">
          <label for="name" class="form-label">Primeiro nome *</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Idade -->
        <div class="col-sm-6">
          <label for="idade" class="form-label">Idade *</label>
          <input type="number" class="form-control" id="idade" name="idade" min="14" max="120" required>
        </div>

        <!-- Email -->
        <div class="col-12">
          <label for="email" class="form-label">Email *</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Senha -->
        <div class="col-12">
          <label for="senha" class="form-label">Senha *</label>
          <input type="password" class="form-control" id="senha" name="senha" required>
        </div>

        <!-- Telefone -->
        <div class="col-12">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000">
        </div>

        <!-- Endereço -->
        <div class="col-12">
          <label for="endereco" class="form-label">Endereço *</label>
          <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>

        <!-- CEP -->
        <div class="col-md-3">
          <label for="cep" class="form-label">CEP</label>
          <input type="text" class="form-control" id="cep" name="cep">
        </div>

        <!-- Plano -->
        <div class="col-md-9">
          <label for="plano" class="form-label">Assinatura *</label>
          <select class="form-select" id="plano" name="plano">
              <option value="">Selecione seu plano</option>
              <option value="mensal">Plano Mensal - R$ 99,90</option>
              <option value="trimestral">Plano Trimestral - R$ 269,90 (economia de 10%)</option>
              <option value="semestral">Plano Semestral - R$ 499,90 (economia de 15%)</option>
              <option value="anual">Plano Anual - R$ 899,90 (economia de 25%)</option>
              <option value="vip">Plano VIP - R$ 1.299,90 (acesso ilimitado + personal trainer)</option>
          </select>
        </div>

        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary btn-lg w-100">
            <i class="fas fa-user-plus me-2"></i> Cadastrar
          </button>
        </div>
      </form>

      <div class="mt-3">
        <ul>
          <li>Já tem uma conta? <a href="loginCliente.php">Logar</a></li>
        </ul>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>