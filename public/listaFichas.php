<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();


    require_once __DIR__ . '/../src/controllers/FisicoController.php';
    require_once __DIR__ . '/../src/controllers/AlunoController.php';

    $controllerFisico = new FisicoController();
    $controllerAluno = new AlunoController();

    // Buscar dados do aluno logado
    $aluno = $controllerAluno->buscarPorEmail($_SESSION['email']);
    $idAluno = $aluno['ID_ALUNO'] ?? $_SESSION['aluno'];

    $erro = '';
    $sucesso = '';
    $fichaEditando = null;

    // Processar ações
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $acao = $_POST['acao'] ?? '';

        // DELETE
        if ($acao == 'deletar' && isset($_POST['idAvaliacao'])) {
            try {
                $controllerFisico->excluir($_POST['idAvaliacao']);
                $sucesso = "Ficha de avaliação deletada com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao deletar ficha: " . $e->getMessage();
            }
        }

        // UPDATE
        if ($acao == 'atualizar' && isset($_POST['idAvaliacao'])) {
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
                    $controllerFisico->atualizar(
                        $_POST['idAvaliacao'],
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
                    $sucesso = "Ficha de avaliação atualizada com sucesso!";
                } catch (Exception $e) {
                    $erro = "Erro ao atualizar ficha: " . $e->getMessage();
                }
            } else {
                $erro = "Por favor, preencha os campos obrigatórios";
            }
        }
    }

    // GET - Buscar ficha para edição
    if (isset($_GET['editar'])) {
        $fichaEditando = $controllerFisico->lerPorId($_GET['editar']);
        if (!$fichaEditando) {
            $erro = "Ficha não encontrada!";
        }
    }

    // Listar todas as fichas do aluno
    $fichas = $controllerFisico->lerPorIdAluno($idAluno);

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
  
  <title>Fichas de Avaliação - TechFit</title>

  <style>
    .tabela-fichas tbody tr:hover {
      background-color: #f5f5f5;
      cursor: pointer;
    }
    .badge-status {
      padding: 0.5em 1em;
      border-radius: 20px;
    }
  </style>
</head>
<body>

<?php require_once '../src/views/client/header.php'; ?>

  <main class="container mt-4">
    
    <div class="row mb-4">
      <div class="col-md-8">
        <h2><i class="fas fa-chart-line me-2"></i> Fichas de Avaliação Física</h2>
      </div>
      <div class="col-md-4 text-end">
        <a href="cadastroFicha.php" class="btn btn-success">
          <i class="fas fa-plus me-2"></i> Nova Ficha
        </a>
      </div>
    </div>

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

    <!-- Modo Edição -->
    <?php if ($fichaEditando): ?>
    <div class="card card-warning mb-4">
      <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Ficha de Avaliação</h5>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="acao" value="atualizar">
          <input type="hidden" name="idAvaliacao" value="<?= htmlspecialchars($fichaEditando->getId()) ?>>
          
          <div class="row g-3">
            <!-- Data -->
            <div class="col-md-6">
              <label for="data" class="form-label">Data da Avaliação *</label>
              <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($fichaEditando->getData()) ?>" required>
            </div>

            <!-- Peso -->
            <div class="col-md-6">
              <label for="peso" class="form-label">Peso (kg) *</label>
              <input type="number" class="form-control" id="peso" name="peso" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getPeso()) ?>" required>
            </div>

            <!-- Altura -->
            <div class="col-md-6">
              <label for="altura" class="form-label">Altura (m) *</label>
              <input type="number" class="form-control" id="altura" name="altura" step="0.01" min="0" max="3" value="<?= htmlspecialchars($fichaEditando->getAltura()) ?>" required>
            </div>

            <!-- IMC -->
            <div class="col-md-6">
              <label for="imc" class="form-label">IMC</label>
              <input type="number" class="form-control" id="imc" name="imc" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getImc()) ?>" readonly>
            </div>

            <hr class="my-3">

            <!-- Medidas -->
            <div class="col-12">
              <h6 class="text-secondary"><i class="fas fa-ruler me-2"></i> Medidas Corporais</h6>
            </div>

            <div class="col-md-6">
              <label for="peitoral" class="form-label">Peitoral (cm)</label>
              <input type="number" class="form-control" id="peitoral" name="peitoral" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getPeitoral()) ?>">
            </div>

            <div class="col-md-6">
              <label for="cintura" class="form-label">Cintura (cm)</label>
              <input type="number" class="form-control" id="cintura" name="cintura" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getCintura()) ?>">
            </div>

            <div class="col-md-6">
              <label for="quadril" class="form-label">Quadril (cm)</label>
              <input type="number" class="form-control" id="quadril" name="quadril" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getQuadril()) ?>">
            </div>

            <div class="col-md-6">
              <label for="coxa" class="form-label">Coxa (cm)</label>
              <input type="number" class="form-control" id="coxa" name="coxa" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getCoxa()) ?>">
            </div>

            <div class="col-md-6">
              <label for="braEsquerdo" class="form-label">Braço Esquerdo (cm)</label>
              <input type="number" class="form-control" id="braEsquerdo" name="braEsquerdo" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getBraEsquerdo()) ?>">
            </div>

            <div class="col-md-6">
              <label for="braDireito" class="form-label">Braço Direito (cm)</label>
              <input type="number" class="form-control" id="braDireito" name="braDireito" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getBraDireito()) ?>">
            </div>

            <hr class="my-3">

            <!-- Composição Corporal -->
            <div class="col-12">
              <h6 class="text-secondary"><i class="fas fa-heartbeat me-2"></i> Composição Corporal</h6>
            </div>

            <div class="col-md-6">
              <label for="gordura" class="form-label">Gordura Corporal (%)</label>
              <input type="number" class="form-control" id="gordura" name="gordura" step="0.1" min="0" max="100" value="<?= htmlspecialchars($fichaEditando->getGordura()) ?>">
            </div>

            <div class="col-md-6">
              <label for="masMagra" class="form-label">Massa Magra (kg)</label>
              <input type="number" class="form-control" id="masMagra" name="masMagra" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getMasMagra()) ?>">
            </div>

            <div class="col-md-6">
              <label for="tmb" class="form-label">TMB - Taxa Metabólica Basal (kcal)</label>
              <input type="number" class="form-control" id="tmb" name="tmb" step="0.1" min="0" value="<?= htmlspecialchars($fichaEditando->getTmb()) ?>">
            </div>

            <!-- Botões -->
            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-warning btn-lg">
                <i class="fas fa-save me-2"></i> Atualizar Ficha
              </button>
              <a href="listaFichas.php" class="btn btn-secondary btn-lg ms-2">
                <i class="fas fa-times me-2"></i> Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Lista de Fichas -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Histórico de Fichas (<?= count($fichas) ?>)</h5>
      </div>
      <div class="card-body p-0">
        <?php if (empty($fichas)): ?>
        <div class="alert alert-info m-3">
          <i class="fas fa-info-circle me-2"></i> Nenhuma ficha de avaliação cadastrada. 
          <a href="cadastroFicha.php" class="alert-link">Criar uma nova</a>
        </div>
        <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover mb-0 tabela-fichas">
            <thead class="table-light">
              <tr>
                <th>Data</th>
                <th>Peso (kg)</th>
                <th>Altura (m)</th>
                <th>IMC</th>
                <th>Gordura (%)</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($fichas as $ficha): ?>
              <tr>
                <td>
                  <strong><?= date('d/m/Y', strtotime($ficha->getData())) ?></strong>
                </td>
                <td><?= htmlspecialchars($ficha->getPeso()) ?></td>
                <td><?= htmlspecialchars($ficha->getAltura()) ?></td>
                <td>
                  <span class="badge bg-info">
                    <?= htmlspecialchars($ficha->getImc()) ?>
                  </span>
                </td>
                <td>
                  <?php if ($ficha->getGordura() > 0): ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($ficha->getGordura()) ?>%</span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="?editar=<?= $ficha->getId() ?>" class="btn btn-sm btn-warning" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $ficha->getId() ?>" title="Deletar">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              <!-- Modal de Confirmação DELETE -->
              <div class="modal fade" id="deleteModal<?= $ficha->getId() ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                      <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Confirmar Exclusão</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <p>Tem certeza que deseja deletar a ficha de avaliação de <strong><?= date('d/m/Y', strtotime($ficha->getData())) ?></strong>?</p>
                      <p class="text-muted">Esta ação não pode ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="idAvaliacao" value="<?= $ficha->getId() ?>">
                        <button type="submit" class="btn btn-danger">
                          <i class="fas fa-trash me-2"></i> Deletar
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Botão Voltar -->
    <div class="mt-4 mb-4">
      <a href="telaCliente.php" class="btn btn-secondary btn-lg">
        <i class="fas fa-arrow-left me-2"></i> Voltar para Tela Inicial
      </a>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Calcular IMC automaticamente no modo edição
    const pesoInput = document.getElementById('peso');
    const alturaInput = document.getElementById('altura');
    const imcInput = document.getElementById('imc');

    if (pesoInput && alturaInput && imcInput) {
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
    }
  </script>
</body>
</html>
