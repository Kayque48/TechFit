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

$Admin = ['USER' => $_SESSION['usuario']];

// Action de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: loginAdm.php');
    exit;
}

require_once __DIR__ . '/../src/controllers/AulaController.php';
$controllerAula = new AulaController();

$erro = '';
$sucesso = '';
$aulaEditando = null;

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';

    // DELETE
    if ($acao == 'deletar' && isset($_POST['id'])) {
        try {
            $controllerAula->excluir($_POST['id']);
            $sucesso = "Aula deletada com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao deletar aula: " . $e->getMessage();
        }
    }

    // UPDATE
    if ($acao == 'atualizar' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $nome = $_POST['nomeAula'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $tempo = $_POST['tempo'] ?? '';
        $data = $_POST['data'] ?? '';
        $professor = $_POST['professor'] ?? '';


        if (!empty($nome) && !empty($tipo) && !empty($tempo) && !empty($data) && !empty($professor)) {
            try {
                $controllerAula->atualizar(
                    $id,
                    $nome,
                    $tipo,
                    $tempo,
                    $data,
                    $professor
                );
                $sucesso = "Aula atualizada com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao atualizar aula: " . $e->getMessage();
            }
        } else {
            $erro = "Por favor, preencha os campos obrigatórios";
        }
    }
}

// GET - Buscar aula para edição
if (isset($_GET['editar'])) {
    $aulaEditando = $controllerAula->buscarPorId($_GET['editar']);
    if (!$aulaEditando) {
        $erro = "Aula não encontrado!";
    }
}

$aulas = $controllerAula->ler();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Aulas - TechFit</title>

    <style>
        :root {
            --verde-escuro: #1E5332;
            --verde-claro: #68A842;
            --amarelo: #FBC70B;
            --laranja: #E95D29;
            --azul: #0093D1;
            --gray-light: #f8f9fa;
        }

        .tabela-aulas tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .badge-preco {
            padding: 0.5em 1em;
            border-radius: 20px;
            font-size: 1.1rem;
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
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
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

        .admin-greeting {
            font-size: 1.1rem;
            font-weight: 500;
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background: var(--laranja);
            border-color: var(--laranja);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(233, 93, 41, 0.4);
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

    <main class="container mt-4">

        <div class="d-flex align-items-center mb-4">
            <a href="telaAdministrador.php" class="text-decoration-none d-flex align-items-center"
                style="color: var(--verde-escuro); font-weight: 600;">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-calendar-alt me-2"></i> Aulas Cadastradas na TechFit</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="cadastroAula.php" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i> Nova Aula
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
        <?php if ($aulaEditando): ?>
            <div class="card card-warning mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Editar Aula
                    </h5>
                </div>

                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="acao" value="atualizar">

                        <div class="row g-3">

                            <input type="hidden" name="id" value="<?= $aulaEditando->getId() ?>">

                         <!-- Nome da Aula -->
                            <div class="col-md-6">
                                <label for="nomeAula" class="form-label">Nome do Aula *</label>
                                <input type="text" class="form-control" id="nomeAula" name="nomeAula"
                                    value="<?= htmlspecialchars($aulaEditando->getNomeAula()) ?>" required>
                            </div>

                            <!-- Tipo do Aula -->
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo do Aula *</label>
                                <input type="text" class="form-control" id="tipo" name="tipo"
                                    value="<?= htmlspecialchars($aulaEditando->getTipo()) ?>" required>
                            </div>

                            <!-- Preço -->
                            <div class="col-md-6">
                                <label for="tempo" class="form-label">Duração (minutos) *</label>
                                <input type="number" step="0.01" class="form-control" id="tempo" name="tempo"
                                    value="<?= htmlspecialchars($aulaEditando->getTempo()) ?>" required>
                            </div>

                            <!-- Data -->
                            <div class="col-12">
                                <label for="data" class="form-label">Data</label>
                                <textarea class="form-control" id="data" name="data" rows="3"><?= htmlspecialchars($aulaEditando->getData()) ?></textarea>
                            </div>

                            <!-- Professor -->
                            <div class="col-md-6">
                                <label for="professor" class="form-label">Professor *</label>
                                <input type="text" class="form-control" id="professor" name="professor"
                                    value="<?= htmlspecialchars($aulaEditando->getProfessor()) ?>" required>
                            </div>

                            <!-- Botões -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i> Atualizar Aula
                                </button>

                                <a href="listaAulas.php" class="btn btn-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Lista de Aulas -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lista de Aulas (<?= count($aulas) ?>)
                </h5>
            </div>

            <div class="card-body p-0">
                <?php if (empty($aulas)): ?>
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Nenhuma aula cadastrada.
                        <a href="cadastroAula.php" class="alert-link">Cadastrar uma nova</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 tabela-aulas">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Duração</th>
                                    <th>Data e Hora</th>
                                    <th>Professor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($aulas as $aula): ?>
                                    <tr>
                                        <td><strong>#<?= htmlspecialchars($aula->getId()) ?></strong></td>
                                        <td><strong><?= htmlspecialchars($aula->getNomeAula()) ?></strong></td>
                                        <td style="max-width: 250px;"><?= htmlspecialchars($aula->getTipo()) ?></td>
                                        <td><?= htmlspecialchars($aula->getTempo()) ?></td>
                                        <td><?= htmlspecialchars($aula->getData()) ?></td>
                                        <td><?= htmlspecialchars($aula->getProfessor()) ?></td>
                                        <td>
                                            <a href="?editar=<?= $aula->getId() ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $aula->getId() ?>" title="Deletar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal de Confirmação DELETE -->
                                    <div class="modal fade" id="deleteModal<?= $aula->getId() ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Confirmar Exclusão
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p>
                                                        Tem certeza que deseja deletar essa aula?
                                                        <strong><?= htmlspecialchars($aula->getNomeAula()) ?></strong>?
                                                    </p>
                                                    <p class="text-muted">
                                                        Esta ação não pode ser desfeita e pode afetar alunos que utilizam esta aula.
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>

                                                    <form action="" method="post" style="display:inline;">
                                                        <input type="hidden" name="acao" value="deletar">
                                                        <input type="hidden" name="id" value="<?= $aula->getId() ?>">
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
            <a href="telaAdministrador.php" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Voltar para Tela Inicial
            </a>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>