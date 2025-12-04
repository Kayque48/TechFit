<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: loginCliente.php');
    exit;
}

require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/FisicoController.php';

$controllerAluno = new AlunoController();
$controllerFisico = new FisicoController();

// Buscar dados do aluno logado
$aluno = $controllerAluno->buscarPorEmail($_SESSION['email']);

if (!$aluno) {
    // Se não encontrar no banco, redirecionar para login
    header('Location: telaCliente.php');
    exit;
}

// Definir o ID do aluno
$id = $aluno['ID_ALUNO'] ?? null;

// Usar o email do aluno
$Alunoemail = $_SESSION['aluno_email'];

// Processar atualização do plano
$mensagemPlano = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_plano'])) {
    $novoPlano = trim($_POST['plano_selecionado'] ?? '');
    if (!empty($novoPlano)) {
        try {
            $controllerAluno->getDAO()->atualizarPlano($email, $novoPlano);
            $mensagemPlano = 'Plano atualizado com sucesso!';
        } catch (Exception $e) {
            $mensagemPlano = 'Erro ao atualizar plano: ' . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastro'])) {
    if ($_POST['cadastro'] == 'criar') {
        // Validação básica
        $data         = trim($_POST['data'] ?? '');
        $peso         = trim($_POST['peso'] ?? '');
        $altura       = trim($_POST['altura'] ?? '');
        $peitoral     = trim($_POST['peitoral'] ?? '');
        $cintura      = trim($_POST['cintura'] ?? '');
        $quadril      = trim($_POST['quadril'] ?? '');
        $braEsquerdo  = trim($_POST['braEsquerdo'] ?? '');
        $braDireito   = trim($_POST['braDireito'] ?? '');
        $coxa         = trim($_POST['coxa'] ?? '');
        $gordura      = trim($_POST['gordura'] ?? '');
        $masMagra     = trim($_POST['masMagra'] ?? '');
        $tmb          = trim($_POST['tmb'] ?? '');
        $imc          = trim($_POST['imc'] ?? '');

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Cadastro de Ficha - TechFit</title>
  
  <style>
    /* Variáveis do TechFit */
    :root {
      --verde-escuro: #1E5332;
      --verde-claro: #68A842;
      --amarelo: #FBC70B;
      --laranja: #E95D29;
      --azul: #0093D1;
      --gray-light: #f8f9fa;
      --gray-medium: #e9ecef;
    }

    body {
      background: linear-gradient(135deg, var(--gray-light) 0%, #e8f4f8 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Container principal */
    .ficha-container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 0 1.5rem;
    }

    /* Card do aluno */
    .aluno-card {
      background: linear-gradient(135deg, var(--verde-claro), #5a9438);
      border-radius: 16px;
      padding: 2rem;
      color: white;
      box-shadow: 0 8px 24px rgba(104, 168, 66, 0.3);
      margin-bottom: 2rem;
      animation: slideDown 0.5s ease-out;
    }

    .aluno-card .icon-box {
      width: 70px;
      height: 70px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      backdrop-filter: blur(10px);
    }

    /* Card do formulário */
    .form-card {
      background: white;
      border-radius: 16px;
      padding: 2.5rem;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.6s ease-out;
    }

    .form-section-title {
      color: var(--verde-escuro);
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 3px solid var(--verde-claro);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    /* Inputs estilizados */
    .form-control-ficha {
      border: 2px solid var(--gray-medium);
      border-radius: 10px;
      padding: 0.85rem 1rem;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: var(--gray-light);
    }

    .form-control-ficha:focus {
      border-color: var(--azul);
      background: white;
      box-shadow: 0 0 0 0.2rem rgba(0, 147, 209, 0.15);
      transform: translateY(-2px);
      outline: none;
    }

    .form-control-ficha:disabled,
    .form-control-ficha[readonly] {
      background: #e9ecef;
      border-color: #dee2e6;
      cursor: not-allowed;
    }

    .form-label-ficha {
      font-weight: 600;
      color: var(--verde-escuro);
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* IMC Badge */
    .imc-badge {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      font-weight: 700;
      font-size: 1.1rem;
      margin-top: 0.5rem;
    }

    .imc-normal {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
    }

    .imc-warning {
      background: linear-gradient(135deg, #ffc107, #fd7e14);
      color: white;
    }

    .imc-danger {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
    }

    /* Botões */
    .btn-ficha {
      padding: 0.9rem 2rem;
      border-radius: 10px;
      font-weight: 600;
      font-size: 1rem;
      border: none;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-ficha:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-ficha-primary {
      background: linear-gradient(135deg, var(--verde-claro), #5a9438);
      color: white;
    }

    .btn-ficha-secondary {
      background: linear-gradient(135deg, #6c757d, #545b62);
      color: white;
    }

    /* Divider entre seções */
    .section-divider {
      height: 3px;
      background: linear-gradient(90deg, var(--verde-claro), var(--azul));
      border-radius: 10px;
      margin: 2rem 0;
    }

    /* Animações */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

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

    /* Alertas customizados */
    .alert-ficha {
      border-radius: 12px;
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      border: none;
      display: flex;
      align-items: center;
      gap: 1rem;
      animation: slideDown 0.4s ease-out;
    }

    .alert-ficha-success {
      background: linear-gradient(135deg, #d4edda, #c3e6cb);
      color: #155724;
    }

    .alert-ficha-danger {
      background: linear-gradient(135deg, #f8d7da, #f5c6cb);
      color: #721c24;
    }

    /* Small helper text */
    .helper-text {
      font-size: 0.85rem;
      color: #6c757d;
      margin-top: 0.25rem;
      display: block;
    }

    /* Grid responsivo para os campos */
    .fields-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    /* Efeito hover nos campos */
    .form-group-animated {
      position: relative;
      transition: transform 0.2s ease;
    }

    .form-group-animated:hover {
      transform: translateY(-2px);
    }

    /* Responsivo */
    @media (max-width: 768px) {
      .ficha-container {
        padding: 0 1rem;
      }

      .form-card {
        padding: 1.5rem;
      }

      .aluno-card {
        padding: 1.5rem;
      }

      .fields-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <!-- Simulação do conteúdo (substitua pelo PHP real) -->
  <div class="ficha-container">
    
    <!-- Card do Aluno -->
    <div class="aluno-card">
      <div class="d-flex align-items-center gap-4">
        <div class="icon-box">
          <i class="fas fa-user-circle"></i>
        </div>
        <div>
          <h3 class="mb-1 fw-bold" id="nome-cliente" ><?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?></h3>
          <p class="mb-1 opacity-90" id="email-cliente"><?php echo htmlspecialchars($aluno['EMAIL'] ?? 'N/A'); ?></p>
          <small class="opacity-75" id="id-cliente">ID:<?php echo htmlspecialchars($aluno['ID_ALUNO'] ?? 'N/A'); ?></small>
        </div>
      </div>
    </div>

    

    <!-- Alertas (exemplo) -->
    <div class="alert-ficha alert-ficha-success">
      <i class="fas fa-check-circle fa-lg"></i>
      <span>Ficha de avaliação criada com sucesso!</span>
    </div>

    <!-- Card do Formulário -->
    <div class="form-card">
      <form id="fichaForm" method="post">
        <input type="hidden" name="cadastro" value="criar">
        
        <!-- Dados Principais -->
        <h4 class="form-section-title">
          <i class="fas fa-calendar-check"></i>
          Dados Principais
        </h4>

        <div class="fields-grid">
          <div class="form-group-animated">
            <label class="form-label-ficha">
              <i class="fas fa-calendar"></i>
              Data da Avaliação *
            </label>
            <input type="date" class="form-control-ficha" name="data" required>
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">
              <i class="fas fa-weight"></i>
              Peso (kg) *
            </label>
            <input type="number" class="form-control-ficha" id="peso" name="peso" step="0.1" min="0" required>
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">
              <i class="fas fa-ruler-vertical"></i>
              Altura (m) *
            </label>
            <input type="number" class="form-control-ficha" id="altura" name="altura" step="0.01" min="0" max="3" required>
            <small class="helper-text">Ex: 1.75</small>
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">
              <i class="fas fa-calculator"></i>
              IMC
            </label>
            <input type="number" class="form-control-ficha" id="imc" name="imc" step="0.1" readonly>
            <span id="imcClassificacao" class="imc-badge d-none"></span>
          </div>
        </div>

        <div class="section-divider"></div>

        <!-- Medidas Corporais -->
        <h4 class="form-section-title">
          <i class="fas fa-ruler"></i>
          Medidas Corporais
        </h4>

        <div class="fields-grid">
          <div class="form-group-animated">
            <label class="form-label-ficha">Peitoral (cm)</label>
            <input type="number" class="form-control-ficha" name="peitoral" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Cintura (cm)</label>
            <input type="number" class="form-control-ficha" name="cintura" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Quadril (cm)</label>
            <input type="number" class="form-control-ficha" name="quadril" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Coxa (cm)</label>
            <input type="number" class="form-control-ficha" name="coxa" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Braço Esquerdo (cm)</label>
            <input type="number" class="form-control-ficha" name="braEsquerdo" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Braço Direito (cm)</label>
            <input type="number" class="form-control-ficha" name="braDireito" step="0.1" min="0">
          </div>
        </div>

        <div class="section-divider"></div>

        <!-- Composição Corporal -->
        <h4 class="form-section-title">
          <i class="fas fa-heartbeat"></i>
          Composição Corporal
        </h4>

        <div class="fields-grid">
          <div class="form-group-animated">
            <label class="form-label-ficha">Gordura Corporal (%)</label>
            <input type="number" class="form-control-ficha" name="gordura" step="0.1" min="0" max="100">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">Massa Magra (kg)</label>
            <input type="number" class="form-control-ficha" name="masMagra" step="0.1" min="0">
          </div>

          <div class="form-group-animated">
            <label class="form-label-ficha">TMB (kcal)</label>
            <input type="number" class="form-control-ficha" name="tmb" step="0.1" min="0">
            <small class="helper-text" >Taxa Metabólica Basal</small>
          </div>
        </div>

        <!-- Botões -->
        <div class="d-flex gap-3 mt-4">
          <button type="submit" class="btn-ficha btn-ficha-primary">
            <i class="fas fa-save"></i>
            Salvar Ficha de Avaliação
          </button>
          <a href="telaCliente.php" class="btn-ficha btn-ficha-secondary">
            <i class="fas fa-arrow-left"></i>
            Voltar
          </a>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Calcular IMC automaticamente
    const pesoInput = document.getElementById('peso');
    const alturaInput = document.getElementById('altura');
    const imcInput = document.getElementById('imc');
    const imcClassificacao = document.getElementById('imcClassificacao');

    function calcularIMC() {
      const peso = parseFloat(pesoInput.value) || 0;
      const altura = parseFloat(alturaInput.value) || 0;

      if (peso > 0 && altura > 0) {
        const imc = (peso / (altura * altura)).toFixed(2);
        imcInput.value = imc;
        
        // Classificar IMC
        let classe = '';
        let texto = '';
        
        if (imc < 18.5) {
          classe = 'imc-warning';
          texto = 'Abaixo do peso';
        } else if (imc < 25) {
          classe = 'imc-normal';
          texto = 'Peso normal';
        } else if (imc < 30) {
          classe = 'imc-warning';
          texto = 'Sobrepeso';
        } else {
          classe = 'imc-danger';
          texto = 'Obesidade';
        }
        
        imcClassificacao.className = `imc-badge ${classe}`;
        imcClassificacao.textContent = texto;
        imcClassificacao.classList.remove('d-none');
      } else {
        imcInput.value = '';
        imcClassificacao.classList.add('d-none');
      }
    }

    pesoInput.addEventListener('input', calcularIMC);
    alturaInput.addEventListener('input', calcularIMC);

    // Validação do formulário
    document.getElementById('fichaForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const peso = pesoInput.value;
      const altura = alturaInput.value;
      
      if (!peso || !altura || peso <= 0 || altura <= 0) {
        alert('Por favor, preencha peso e altura corretamente!');
        return;
      }
      
      // Aqui você enviaria os dados via AJAX ou submeteria o formulário
      console.log('Formulário validado e pronto para envio!');
      // this.submit(); // Descomente para enviar de verdade
    });

    // Animação suave ao focar nos campos
    document.querySelectorAll('.form-control-ficha').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>