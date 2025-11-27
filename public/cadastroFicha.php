<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    // Validar se usuário está logado
    if (!isset($_SESSION['aluno_id'])) {
        header('Location: loginCliente.php');
        exit;
    }

    require_once __DIR__ . '/../src/controllers/FisicoController.php';
    require_once __DIR__ . '/../src/controllers/AlunoController.php';

    $controllerFisico = new FisicoController();
    $controllerAluno = new AlunoController();

    // Buscar dados do aluno logado
    $aluno = $controllerAluno->buscarPorEmail($_SESSION['aluno_email']);
    $idAluno = $aluno['ID_ALUNO'] ?? $_SESSION['aluno_id'];

    $erro = '';
    $sucesso = '';

    // Processar cadastro de ficha
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        // Validação básica
        $data = trim($_POST['data'] ?? '');
        $peso = floatval($_POST['peso'] ?? 0);
        $altura = floatval($_POST['altura'] ?? 0);
        $peitoral = floatval($_POST['peitoral'] ?? 0);
        $cintura = floatval($_POST['cintura'] ?? 0);
        $quadril = floatval($_POST['quadril'] ?? 0);
        $braEsquerdo = floatval($_POST['braEsquerdo'] ?? 0);
        $braDireito = floatval($_POST['braDireito'] ?? 0);
        $coxa = floatval($_POST['coxa'] ?? 0);
        $gordura = floatval($_POST['gordura'] ?? 0);
        $masMagra = floatval($_POST['masMagra'] ?? 0);
        $tmb = floatval($_POST['tmb'] ?? 0);
        $imc = floatval($_POST['imc'] ?? 0);

        if (!empty($data) && $peso > 0 && $altura > 0) {
            try {
                $controllerFisico->criar(
                    $data,
                    $peso,
                    $altura,
                    $peitoral,
                    $cintura,
                    $quadril,
                    $braEsquerdo,
                    $braDireito,
                    $coxa,
                    $gordura,
                    $masMagra,
                    $tmb,
                    $imc,
                    $idAluno
                );
                
                $sucesso = "Ficha de avaliação criada com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao criar ficha: " . $e->getMessage();
            }
        } else {
            $erro = "Por favor, preencha os campos obrigatórios (data, peso, altura)";
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
  
  <title>Cadastro Ficha de Avaliação - TechFit</title>
</head>
<body>

<?php require_once('../src/views/header.php'); ?>

  <main class="container mt-4">
    
    <h2 class="mb-4">
      <i class="fas fa-chart-line me-2"></i> Cadastro de Ficha de Avaliação Física
    </h2>

    <?php if (!empty($erro)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($erro) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($sucesso) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Aluno</h5>
      </div>
      <div class="card-body">
        <p class="mb-0"><strong>Nome:</strong> <?= htmlspecialchars($aluno['NOME_ALUNO'] ?? 'N/A') ?></p>
        <p class="mb-0"><strong>Email:</strong> <?= htmlspecialchars($aluno['EMAIL'] ?? 'N/A') ?></p>
        <p class="mb-0"><strong>ID:</strong> <?= htmlspecialchars($idAluno) ?></p>
      </div>
    </div>

    <div class="card">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Preencha os Dados da Avaliação</h5>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="acao" value="criar">
          
          <div class="row g-3">
            <!-- Data -->
            <div class="col-md-6">
              <label for="data" class="form-label">Data da Avaliação *</label>
              <input type="date" class="form-control" id="data" name="data" required>
            </div>

            <!-- Peso -->
            <div class="col-md-6">
              <label for="peso" class="form-label">Peso (kg) *</label>
              <input type="number" class="form-control" id="peso" name="peso" step="0.1" min="0" required>
            </div>

            <!-- Altura -->
            <div class="col-md-6">
              <label for="altura" class="form-label">Altura (m) *</label>
              <input type="number" class="form-control" id="altura" name="altura" step="0.01" min="0" max="3" required>
              <small class="text-muted">Ex: 1.75</small>
            </div>

            <!-- IMC -->
            <div class="col-md-6">
              <label for="imc" class="form-label">IMC</label>
              <input type="number" class="form-control" id="imc" name="imc" step="0.1" min="0" readonly>
              <small class="text-muted">Calculado automaticamente</small>
            </div>

            <hr class="my-4">

            <!-- Medidas -->
            <div class="col-12">
              <h6 class="text-secondary"><i class="fas fa-ruler me-2"></i> Medidas Corporais</h6>
            </div>

            <div class="col-md-6">
              <label for="peitoral" class="form-label">Peitoral (cm)</label>
              <input type="number" class="form-control" id="peitoral" name="peitoral" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="cintura" class="form-label">Cintura (cm)</label>
              <input type="number" class="form-control" id="cintura" name="cintura" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="quadril" class="form-label">Quadril (cm)</label>
              <input type="number" class="form-control" id="quadril" name="quadril" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="coxa" class="form-label">Coxa (cm)</label>
              <input type="number" class="form-control" id="coxa" name="coxa" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="braEsquerdo" class="form-label">Braço Esquerdo (cm)</label>
              <input type="number" class="form-control" id="braEsquerdo" name="braEsquerdo" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="braDireito" class="form-label">Braço Direito (cm)</label>
              <input type="number" class="form-control" id="braDireito" name="braDireito" step="0.1" min="0">
            </div>

            <hr class="my-4">

            <!-- Composição Corporal -->
            <div class="col-12">
              <h6 class="text-secondary"><i class="fas fa-heartbeat me-2"></i> Composição Corporal</h6>
            </div>

            <div class="col-md-6">
              <label for="gordura" class="form-label">Gordura Corporal (%)</label>
              <input type="number" class="form-control" id="gordura" name="gordura" step="0.1" min="0" max="100">
            </div>

            <div class="col-md-6">
              <label for="masMagra" class="form-label">Massa Magra (kg)</label>
              <input type="number" class="form-control" id="masMagra" name="masMagra" step="0.1" min="0">
            </div>

            <div class="col-md-6">
              <label for="tmb" class="form-label">TMB - Taxa Metabólica Basal (kcal)</label>
              <input type="number" class="form-control" id="tmb" name="tmb" step="0.1" min="0">
            </div>

            <!-- Botões -->
            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save me-2"></i> Salvar Ficha de Avaliação
              </button>
              <a href="telaCliente.php" class="btn btn-secondary btn-lg ms-2">
                <i class="fas fa-arrow-left me-2"></i> Voltar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Calcular IMC automaticamente
    const pesoInput = document.getElementById('peso');
    const alturaInput = document.getElementById('altura');
    const imcInput = document.getElementById('imc');

    function calcularIMC() {
      const peso = parseFloat(pesoInput.value) || 0;
      const altura = parseFloat(alturaInput.value) || 0;

      if (peso > 0 && altura > 0) {
        const imc = peso / (altura * altura);
        imcInput.value = imc.toFixed(2);
      } else {
        imcInput.value = '';
      }
    }

    pesoInput.addEventListener('input', calcularIMC);
    alturaInput.addEventListener('input', calcularIMC);
  </script>
</body>
</html>
