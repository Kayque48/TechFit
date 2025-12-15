<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se está logado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: loginAdm.php?erro=2');
    exit;
}

require_once __DIR__ . '/../src/controllers/ProfessorController.php';

$controllerProfessor = new ProfessorController();

$professores = $controllerProfessor->ler();


$erro = '';
$sucesso = '';
$professorEditando = null;

$Admin = ['USER' => $_SESSION['usuario']];

// Action de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: loginAdm.php');
    exit;
}

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';

    // DELETE
    if ($acao == 'deletar' && isset($_POST['idProfessor'])) {
        try {
            $controllerProfessor->excluir($_POST['idProfessor']);
            $sucesso = "Professor deletado com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao deletar professor: " . $e->getMessage();
        }
    }

    // UPDATE
    if ($acao == 'atualizar' && isset($_POST['idProfessor'])) {
        $idProfessor = $_POST['idProfessor'];
        $nome = trim($_POST['nome'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $especialidade = trim($_POST['especialidade'] ?? '');
        if (!empty($nome) && !empty($cpf)) {
            try {
                $controllerProfessor->atualizar(
                    $_POST['idProfessor'],
                    $nome,
                    $cpf,
                    $especialidade
                );
                $sucesso = "Professor atualizado com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao atualizar professor: " . $e->getMessage();
            }
        } else {
            $erro = "Por favor, preencha os campos obrigatórios";
        }
    }
}

// GET - Buscar ficha para edição
if (isset($_GET['editar'])) {
    $professorEditando = $controllerProfessor->buscarPorId($_GET['editar']);
    if (!$professorEditando) {
        $erro = "Ficha não encontrada!";
    }
}

$professores = $controllerProfessor->ler();

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

    <title>Alunos - TechFit</title>

    <style>
        .tabela-fichas tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .badge-status {
            padding: 0.5em 1em;
            border-radius: 20px;
        }

        /* Header Aprimorado */
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

        /* Layout */
        .main-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar Aprimorada */
        .techfit-sidebar {
            width: 280px;
            background: white;
            padding: 2rem 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 80px;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .sidebar-section {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
        }

        .sidebar-section-title {
            color: var(--verde-escuro);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .nav-pills .nav-link {
            border-radius: 10px;
            margin-bottom: 0.5rem;
            padding: 0.85rem 1.25rem;
            color: #495057;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover {
            background: rgba(104, 168, 66, 0.1);
            color: var(--verde-escuro);
            transform: translateX(5px);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--verde-claro), #5a9438);
            color: white;
            box-shadow: 0 4px 12px rgba(104, 168, 66, 0.3);
        }

        .nav-icon {
            width: 22px;
            font-size: 1.1rem;
            text-align: center;
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

        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-chart-line me-2"></i> Professores Cadastrados na TechFit</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="cadastroProfessor.php" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i> Novo Professor
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
        <?php if ($professorEditando): ?>
            <div class="card card-warning mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i> Editar Cadastro do Professor
                    </h5>
                </div>

                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="acao" value="atualizar">
                        <input type="hidden" name="idProfessor" value="<?= htmlspecialchars($professorEditando->getId()) ?>">

                        <div class="row g-3">

                            <!-- Nome -->
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome *</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    value="<?= htmlspecialchars($professorEditando->getNomeProfessor()) ?>" required>
                            </div>

                            <!-- CPF -->
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" name="cpf"
                                    value="<?= htmlspecialchars($professorEditando->getCpf()) ?>" required>
                            </div>

                            <!-- Especialidade -->
                            <div class="col-md-12">
                                <label for="especialidade" class="form-label">Especialidade</label>
                                <input type="text" class="form-control" id="especialidade" name="especialidade"
                                    value="<?= htmlspecialchars($professorEditando->getEspecialidade()) ?>">
                            </div>

                            <!-- Botões -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i> Atualizar Professor
                                </button>

                                <a href="listaProfessores.php" class="btn btn-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Lista de Professores -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Lista de Professores (<?= count($professores) ?>)
                </h5>
            </div>

            <div class="card-body p-0">
                <?php if (empty($professores)): ?>
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Nenhum professor cadastrado.
                        <a href="cadastroProfessor.php" class="alert-link">Cadastrar um novo</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 tabela-alunos">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Especialidade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($professores as $professor): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($professor->getId()) ?></strong>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($professor->getNomeProfessor()) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($professor->getCpf()) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($professor->getEspecialidade()) ?>
                                        </td>

                                        <td>
                                            <a href="?editar=<?= $professor->getId() ?>" class="btn btn-sm btn-warning"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $professor->getId() ?>" title="Deletar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal de Confirmação DELETE -->
                                    <div class="modal fade" id="deleteModal<?= $professor->getId() ?>" tabindex="-1">
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
                                                        Tem certeza que deseja deletar o professor
                                                        <strong><?= htmlspecialchars($professor->getNomeProfessor()) ?></strong>?
                                                    </p>
                                                    <p class="text-muted">
                                                        Esta ação não pode ser desfeita.
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>

                                                    <form action="" method="post" style="display:inline;">
                                                        <input type="hidden" name="acao" value="deletar">
                                                        <input type="hidden" name="idProfessor" value="<?= $professor->getId() ?>">
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>