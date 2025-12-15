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
require_once __DIR__ . '/../src/controllers/AulaController.php';

$controllerProfessor = new ProfessorController();
$controllerAula = new AulaController();

$mensagem = '';
$tipoMensagem = '';

// Processar cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] == 'criar') {
        $nome = trim($_POST['nome'] ?? '');
        $tipo = trim($_POST['tipo'] ?? '');
        $tempo = trim($_POST['tempo'] ?? '');
        $data = trim($_POST['data'] ?? '');
        $professor = trim($_POST['professor'] ?? '');

        if (!empty($nome) && !empty($tipo) && !empty($data)) {
            try {
                $controllerAula->criar($nome, $tipo, $tempo, $data, $professor);
                $mensagem = 'Aula criada com sucesso!';
                $tipoMensagem = 'sucesso';
            } catch (Exception $e) {
                $mensagem = 'Erro ao criar: ' . $e->getMessage();
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
                    Criar Nova Aula
                </h3>
            </div>

            <div class="info-box">
                <p>
                    <i class="fas fa-info-circle me-2"></i>
                    Preencha os dados da nova aula.
                </p>
            </div>

            <form action="" method="post">
                <input type="hidden" name="acao" value="criar">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Ex: João Silva" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="Musculação">Musculação</option>
                            <option value="Yoga">Yoga</option>
                            <option value="CrossFit">CrossFit</option>
                            <option value="Pilates">Pilates</option>
                            <option value="Zumba">Zumba</option>
                            <option value="Spinning">Spinning</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Duração</label>
                        <select name="tempo" id="tempo">
                            <option value="00:30:00">30 minutos</option>
                            <option value="00:45:00">45 minutos</option>
                            <option value="00:60:00">60 minutos</option>
                            <option value="00:90:00">90 minutos</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Data</label>
                        <input type="datetime-local" class="form-control" id="data" name="data" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Professor</label>
                        <select name="professor" id="professor">
                            <?php
                            $professores = $controllerProfessor->ler();
                            foreach ($professores as $professor) {
                                echo '<option value="' . htmlspecialchars($professor->getId()) . '">'
                                    . htmlspecialchars($professor->getNomeProfessor()) . '</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <div class="btn-group-custom">
                        <button type="submit" class="btn-custom btn-primary-custom">
                            <i class="fas fa-save"></i>
                            Criar Aula
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        function definirDataMinima() {
            // 1. Obter a data/hora atual (em milissegundos)
            const agora = new Date();

            // 2. Calcular o tempo daqui a 24 horas (em milissegundos)
            // 24 horas * 60 minutos * 60 segundos * 1000 milissegundos
            const vinteEQuatroHorasEmMs = 24 * 60 * 60 * 1000;
            const dataMinima = new Date(agora.getTime() + vinteEQuatroHorasEmMs);

            // 3. Formatar a data/hora para o padrão exigido pelo input 'datetime-local': YYYY-MM-DDTHH:mm
            // O JS toISOString() retorna YYYY-MM-DDTHH:mm:ss.sssZ, então precisamos ajustá-lo.

            const isoString = dataMinima.toISOString(); // Exemplo: 2025-12-15T03:01:38.900Z

            // Pegar apenas a parte necessária: YYYY-MM-DDTHH:mm
            // O método 'slice(0, 16)' pega os primeiros 16 caracteres.
            const valorMin = isoString.slice(0, 16); // Exemplo: 2025-12-15T03:01

            // 4. Aplicar o valor formatado ao atributo 'min' do input
            document.getElementById('data').min = valorMin;
        }

        // Chame a função quando o DOM estiver pronto
        document.addEventListener('DOMContentLoaded', definirDataMinima);

        // Opcional: Se a página puder ficar aberta por muito tempo, você pode querer
        // rodar a função periodicamente para manter a restrição de 24h atualizada.
        // setInterval(definirDataMinima, 60000); // Atualiza a cada 1 minuto (60000ms)

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
    </script>
</body>

</html>