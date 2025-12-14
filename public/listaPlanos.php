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

require_once __DIR__ . '/../src/controllers/PlanoController.php';
$controllerPlano = new PlanoController();

$erro = '';
$sucesso = '';
$planoEditando = null;

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';

    // DELETE
    if ($acao == 'deletar' && isset($_POST['idPlano'])) {
        try {
            $controllerPlano->excluir($_POST['idPlano']);
            $sucesso = "Plano deletado com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao deletar plano: " . $e->getMessage();
        }
    }

    // UPDATE
    if ($acao == 'atualizar' && isset($_POST['idPlano'])) {
        $idPlano = $_POST['idPlano'];
        $tipoPlano = trim($_POST['tipoPlano'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $maquinas = trim($_POST['maquinas'] ?? '');
        $aulasGrupo = trim($_POST['aulasGrupo'] ?? '');
        $treinamentos = trim($_POST['treinamentos'] ?? '');
        $consultoria = trim($_POST['consultoria'] ?? '');
        $avaliacao = trim($_POST['avaliacao'] ?? '');
        $acesso = trim($_POST['acesso'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);

        if (!empty($tipoPlano) && $preco > 0) {
            try {
                $controllerPlano->atualizar(
                    $idPlano,
                    $tipoPlano,
                    $descricao,
                    $maquinas,
                    $aulasGrupo,
                    $treinamentos,
                    $consultoria,
                    $avaliacao,
                    $acesso,
                    $preco
                );
                $sucesso = "Plano atualizado com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao atualizar plano: " . $e->getMessage();
            }
        } else {
            $erro = "Por favor, preencha os campos obrigatórios";
        }
    }
}

// GET - Buscar plano para edição
if (isset($_GET['editar'])) {
    $planoEditando = $controllerPlano->buscarPorId($_GET['editar']);
    if (!$planoEditando) {
        $erro = "Plano não encontrado!";
    }
}

$planos = $controllerPlano->ler();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Planos - TechFit</title>

    <style>
        :root {
            --verde-escuro: #1E5332;
            --verde-claro: #68A842;
            --amarelo: #FBC70B;
            --laranja: #E95D29;
            --azul: #0093D1;
            --gray-light: #f8f9fa;
        }

        .tabela-planos tbody tr:hover {
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
                <h2><i class="fas fa-calendar-alt me-2"></i> Planos Cadastrados na TechFit</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="PlanoCRUD.php" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i> Novo Plano
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
        <?php if ($planoEditando): ?>
            <div class="card card-warning mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Editar Plano
                    </h5>
                </div>

                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="acao" value="atualizar">
                        <input type="hidden" name="idPlano" value="<?= htmlspecialchars($planoEditando->getId()) ?>">

                        <div class="row g-3">

                            <!-- Tipo do Plano -->
                            <div class="col-md-6">
                                <label for="tipoPlano" class="form-label">Tipo do Plano *</label>
                                <input type="text" class="form-control" id="tipoPlano" name="tipoPlano"
                                    value="<?= htmlspecialchars($planoEditando->getTipoPlano()) ?>" required>
                            </div>

                            <!-- Preço -->
                            <div class="col-md-6">
                                <label for="preco" class="form-label">Preço (R$) *</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco"
                                    value="<?= htmlspecialchars($planoEditando->getPreco()) ?>" required>
                            </div>

                            <!-- Descrição -->
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($planoEditando->getDescricao()) ?></textarea>
                            </div>

                            <!-- Recursos -->
                            <div class="col-md-6">
                                <label for="maquinas" class="form-label">Acesso às Máquinas</label>
                                <select name="maquinas" id="maquinas" class="form-select">
                                    <option value="Limitado" <?= $planoEditando->getMaquinas() == "Limitado" ? "selected" : "" ?>>Limitado</option>
                                    <option value="Total" <?= $planoEditando->getMaquinas() == "Total" ? "selected" : "" ?>>Total</option>
                                    <option value="Total 24/7" <?= $planoEditando->getMaquinas() == "Total 24/7" ? "selected" : "" ?>>Total 24/7</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="aulasGrupo" class="form-label">Aulas em Grupo</label>
                                <select name="aulasGrupo" id="aulasGrupo" class="form-select">
                                    <option value="1 aula por semana" <?= $planoEditando->getAulasGrupo() == "1 aula por semana" ? "selected" : "" ?>>1 aula por semana</option>
                                    <option value="3 aulas por semana" <?= $planoEditando->getAulasGrupo() == "3 aulas por semana" ? "selected" : "" ?>>3 aulas por semana</option>
                                    <option value="Ilimitado" <?= $planoEditando->getAulasGrupo() == "Ilimitado" ? "selected" : "" ?>>Ilimitado</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="treinamentos" class="form-label">Treinamento Personalizado</label>
                                <select name="treinamentos" id="treinamentos" class="form-select">
                                    <option value="Não incluso" <?= $planoEditando->getTreinamentos() == "Não incluso" ? "selected" : "" ?>>Não incluso</option>
                                    <option value="2x por mês" <?= $planoEditando->getTreinamentos() == "2x por mês" ? "selected" : "" ?>>2x por mês</option>
                                    <option value="Ilimitado" <?= $planoEditando->getTreinamentos() == "Ilimitado" ? "selected" : "" ?>>Ilimitado</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="consultoria" class="form-label">Consultoria Nutricional</label>
                                <select name="consultoria" id="consultoria" class="form-select">
                                    <option value="Não incluso" <?= $planoEditando->getConsultoria() == "Não incluso" ? "selected" : "" ?>>Não incluso</option>
                                    <option value="1x por mês" <?= $planoEditando->getConsultoria() == "1x por mês" ? "selected" : "" ?>>1x por mês</option>
                                    <option value="Quinzenal" <?= $planoEditando->getConsultoria() == "Quinzenal" ? "selected" : "" ?>>Quinzenal</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="avaliacao" class="form-label">Avaliação Física</label>
                                <select name="avaliacao" id="avaliacao" class="form-select">
                                    <option value="Trimestral" <?= $planoEditando->getAvaliacao() == "Trimestral" ? "selected" : "" ?>>Trimestral</option>
                                    <option value="Bimestral" <?= $planoEditando->getAvaliacao() == "Bimestral" ? "selected" : "" ?>>Bimestral</option>
                                    <option value="Mensal" <?= $planoEditando->getAvaliacao() == "Mensal" ? "selected" : "" ?>>Mensal</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="acesso" class="form-label">Horário de Acesso</label>
                                <select name="acesso" id="acesso" class="form-select">
                                    <option value="Comercial" <?= $planoEditando->getAcesso() == "Comercial" ? "selected" : "" ?>>Comercial</option>
                                    <option value="Estendido" <?= $planoEditando->getAcesso() == "Estendido" ? "selected" : "" ?>>Estendido</option>
                                    <option value="24h" <?= $planoEditando->getAcesso() == "24h" ? "selected" : "" ?>>24h</option>
                                </select>
                            </div>

                            <!-- Botões -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i> Atualizar Plano
                                </button>

                                <a href="listaPlanos.php" class="btn btn-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Lista de Planos -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lista de Planos (<?= count($planos) ?>)
                </h5>
            </div>

            <div class="card-body p-0">
                <?php if (empty($planos)): ?>
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Nenhum plano cadastrado.
                        <a href="PlanoCRUD.php" class="alert-link">Cadastrar um novo</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 tabela-planos">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th>Recursos</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($planos as $plano): ?>
                                    <tr>
                                        <td><strong>#<?= htmlspecialchars($plano->getId()) ?></strong></td>
                                        <td><strong><?= htmlspecialchars($plano->getTipoPlano()) ?></strong></td>
                                        <td style="max-width: 250px;"><?= htmlspecialchars($plano->getDescricao()) ?></td>
                                        <td>
                                            <small>
                                                <strong>Máquinas:</strong> <?= htmlspecialchars($plano->getMaquinas()) ?><br>
                                                <strong>Aulas:</strong> <?= htmlspecialchars($plano->getAulasGrupo()) ?><br>
                                                <strong>Acesso:</strong> <?= htmlspecialchars($plano->getAcesso()) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success badge-preco">
                                                R$ <?= number_format($plano->getPreco(), 2, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?editar=<?= $plano->getId() ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $plano->getId() ?>" title="Deletar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal de Confirmação DELETE -->
                                    <div class="modal fade" id="deleteModal<?= $plano->getId() ?>" tabindex="-1">
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
                                                        Tem certeza que deseja deletar o plano
                                                        <strong><?= htmlspecialchars($plano->getTipoPlano()) ?></strong>?
                                                    </p>
                                                    <p class="text-muted">
                                                        Esta ação não pode ser desfeita e pode afetar alunos que utilizam este plano.
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>

                                                    <form action="" method="post" style="display:inline;">
                                                        <input type="hidden" name="acao" value="deletar">
                                                        <input type="hidden" name="idPlano" value="<?= $plano->getId() ?>">
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