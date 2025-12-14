<?php

session_start();

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
    $dataNasc = trim($_POST['dataNasc'] ?? '');

    $dataObj = DateTime::createFromFormat('d/m/Y', $dataNasc);

    if ($dataObj && $dataObj->format('d/m/Y') === $dataNasc) {

      // Salvar a data no banco em formato Y-m-d:
      $dataNasc = $dataObj->format('Y-m-d');

      // Calcular a idade em anos:
      $idadeEmAnos = $dataObj->diff(new DateTime())->y;

      $_SESSION['idade'] = $idadeEmAnos;

    } else {
      // data inválida
      $erro = "Data de nascimento inválida. Use dd/mm/aaaa.";
    }

    $senha = $_POST['senha'] ?? '';

    // Validação de email e telefone duplicados
    $erroValidacao = '';

    if ($controller->getDAO()->emailExiste($email)) {
      $erroValidacao = 'Email já cadastrado no sistema';
    } elseif (!empty($telefone) && $controller->getDAO()->telefoneExiste($telefone)) {
      $erroValidacao = 'Telefone já cadastrado no sistema';
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    if (!empty($nome) && !empty($email) && !empty($endereco) && !empty($senha)) {
      if (!empty($erroValidacao)) {
        $erro = $erroValidacao;
      } else {
        try {
          $controller->criar(
            $nome,
            $dataNasc,
            $endereco,
            $telefone,
            $email,
            null, // plano será escolhido após login
            $senhaHash
          );

          // Redirecionar para login com sucesso
          header('Location: loginCliente.php?cadastro=sucesso');
          exit;
        } catch (Exception $e) {
          $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
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

  <!-- Flatpickr -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

  <!-- Estilos do Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Estilos customizados -->
  <link rel="stylesheet" href="css/CadUser.css">

  <title>Cadastro de Clientes - TechFit</title>
</head>

<body>
  <main class="container mt-4">

    <div class="d-flex align-items-center mb-4">
      <!-- Voltar -->
      <a href="javascript:history.back()" class="text-decoration-none d-flex align-items-center"
        style="color: var(--verde-escuro); font-weight: 600;">
        <i class="fas fa-arrow-left me-2"></i>
        Voltar
      </a>
    </div>

    <h2 class="text-center mb-4" style="color: var(--verde-escuro); font-weight: 700;">
      Cadastro de Clientes
    </h2>

    <?php if (isset($erro)): ?>
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <div class="row g-3">
      <form action="" method="post">
        <input type="hidden" name="cadastro" value="criar">

        <!-- Nome -->
        <div class="col-sm-12">
          <label for="name" class="form-label">Nome Completo *</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Idade -->
        <div class="col-sm-6">
          <label for="dataNasc" class="form-label">Data de Nascimento *</label>
          <div style="position: relative;">
            <input type="text" class="form-control" id="dataNasc" name="dataNasc" placeholder="00/00/0000"
              autocomplete="off" maxlength="10" required>
            <i class="fas fa-calendar-alt" id="calendar-icon"
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6c757d;"></i>
          </div>
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
          <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000"
            maxlength="15">
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



  <script>
    const input = document.getElementById('dataNasc');
    const icon = document.getElementById('calendar-icon');

    // Formatação automática com "/"
    input.addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove não-dígitos

      if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
      }
      if (value.length >= 5) {
        value = value.substring(0, 5) + '/' + value.substring(5, 9);
      }

      e.target.value = value;
    });

    // Inicializa flatpickr
    const picker = flatpickr("#dataNasc", {
      dateFormat: "d/m/Y",
      allowInput: true,
      locale: "pt",
      minDate: "01/01/1900",
      maxDate: new Date(),
    });

    // Abre calendário ao clicar no ícone
    icon.addEventListener('click', function () {
      picker.open();
    });

    // Formatação automática de telefone
    const telefoneInput = document.getElementById('telefone');

    telefoneInput.addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove não-dígitos

      if (value.length <= 10) {
        // Formato: (00) 0000-0000
        if (value.length >= 2) {
          value = '(' + value.substring(0, 2) + ') ' + value.substring(2);
        }
        if (value.length >= 10) {
          value = value.substring(0, 10) + '-' + value.substring(10, 14);
        }
      } else {
        // Formato: (00) 00000-0000
        value = '(' + value.substring(0, 2) + ') ' + value.substring(2, 7) + '-' + value.substring(7, 11);
      }

      e.target.value = value;
    });

  </script>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>