<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$idade = $_SESSION['idade'];

// Verificar se o usuário está logado
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: loginCliente.php');
    exit;
}

// Importar os controllers
require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/FisicoController.php';
require_once __DIR__ . '/../src/controllers/PlanoController.php';
require_once __DIR__ . '/../src/controllers/AulaController.php';
require_once __DIR__ . '/../src/controllers/AgendamentoController.php';

$controllerAluno = new AlunoController();
$controllerFisico = new FisicoController();
$controllerPlano = new PlanoController();
$controllerAula = new AulaController();
$controllerAgendamento = new AgendamentoController();


// Buscar dados do aluno logado
$aluno = $controllerAluno->buscarPorEmail($_SESSION['email']);

if (!$aluno) {
    // Se não encontrar no banco, redirecionar para login
    header('Location: loginCliente.php');
    exit;
}

// Definir o ID do aluno
$id = $aluno['ID_ALUNO'] ?? null;

// Usar o email do aluno
$Alunoemail = $_SESSION['email'];

// Buscar TODOS os planos disponíveis
$plano = $controllerPlano->ler();

$aulas = $controllerAula->ler();

$aulasAgendadas = $controllerAgendamento->ler();

// Buscar o plano ESPECÍFICO do aluno (se tiver)
$planoDoAluno = null;
if (!empty($aluno['FK_PLANO'])) {
    $planoDoAluno = $controllerPlano->buscarPorId($aluno['FK_PLANO']);
}

// Processar atualização do plano
$mensagemPlano = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar_plano'])) {
    $idPlanoSelecionado = trim($_POST['plano_selecionado'] ?? '');
    $senhaConfirmacao = trim($_POST['senha_confirmacao'] ?? '');

    if (!empty($idPlanoSelecionado) && !empty($senhaConfirmacao)) {
        try {
            // Verificar senha
            if (password_verify($senhaConfirmacao, $aluno['SENHA'])) {
                $controllerAluno->getDAO()->atualizarPlano($_SESSION['email'], $idPlanoSelecionado);
                $mensagemPlano = 'Plano atualizado com sucesso!';

                // Recarregar dados do aluno
                $aluno = $controllerAluno->buscarPorEmail($_SESSION['email']);
                $planoDoAluno = $controllerPlano->buscarPorId($aluno['FK_PLANO']);
            } else {
                $mensagemPlano = 'Senha incorreta!';
            }
        } catch (Exception $e) {
            $mensagemPlano = 'Erro ao atualizar plano: ' . $e->getMessage();
        }
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
    <link rel="stylesheet" href="css/styleClient.css">
    <link rel="stylesheet" href="css/hidden.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/ajuste.css">
    <link rel="stylesheet" href="css/secTreino.css">
    <link rel="stylesheet" href="css/secPlano.css">
    <title> Perfil - TechFit</title>

</head>

<body>
    <!-- Header -->
    <?php
    require_once __DIR__ . '/../src/views/client/header.php'
        ?>
    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php
        require_once '../src/views/client/sidebars.php';
        ?>

        <!-- Sessão Visão Geral -->
        <main class="main-content">
            <div id="geral" class="hidden">
                <div class="content-header">
                    <h1 class="page-title">Seu Perfil</h1>
                    <p class="page-subtitle">Gerencie suas informações aqui</p>
                </div>

                <div class="product-form-container">
                    <form id="productForm">
                        <!-- Informações Básicas -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informações Básicas
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="clientName">Nome:</label>
                                    <p id="nome-cliente"><?php echo htmlspecialchars($aluno['NOME_ALUNO'] ?? 'N/A'); ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientYear">Idade:</label>
                                    <p id="idade-cliente"><?php echo htmlspecialchars($idade ?? 'N/A'); ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientOld">Endereço:</label>
                                    <p id="endereco-cliente">
                                        <?php echo htmlspecialchars($aluno['ENDERECO_ALUNO'] ?? 'N/A'); ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPlan">Plano:</label>
                                    <p id="Plano-cliente">
                                        <?php
                                        if ($planoDoAluno) {
                                            echo htmlspecialchars($planoDoAluno->getTipoPlano());
                                        } else {
                                            echo 'Nenhum plano selecionado';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPhone">Telefone:</label>
                                    <p id="telefone-cliente">
                                        <?php echo htmlspecialchars($aluno['TELEFONE'] ?? 'N/A'); ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientEmail">Email:</label>
                                    <p id="email-cliente"><?php echo htmlspecialchars($aluno['EMAIL'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="exercise-details container px-4 py-5" id="custom-cards">
                            <h3 class="section-title pb-2 border-bottom">
                                <i class="fas fa-dumbbell me-2"></i>
                                Agendar Excercícios
                            </h3>

                            

                        </div>
                    </form>
                </div>
            </div>

            <!-- Seção Plano -->
            <section id="plano" class="plans container py-5 hidden">
                <div class="content-header">
                    <h1 class="page-title">Nossos Planos</h1>
                    <p class="page-subtitle">Escolha o plano que melhor se adapta a você</p>
                </div>

                <div class="product-form-container">
                    <div class="pricing-header text-center mb-4">
                        <h1 class="display-4 fw-normal text-body-emphasis">Planos de Academia</h1>
                        <p class="fs-5 text-body-secondary">
                            Encontre o plano ideal para alcançar seus objetivos de fitness com nossa variedade de
                            opções.
                        </p>
                    </div>

                    <?php if (!empty($mensagemPlano)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($mensagemPlano) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Cards dos Planos - GRID CORRIGIDO -->
                    <div class="planos-container">
                        <?php if (empty($plano)): ?>
                            <div class="alert alert-info w-100" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                Nenhum plano disponível no momento. Entre em contato conosco para mais informações.
                            </div>
                        <?php else: ?>
                            <?php foreach ($plano as $p): ?>
                                <div class="card-plan">
                                    <div class="card-plan-header">
                                        <h4><?= htmlspecialchars($p->getTipoPlano()) ?></h4>
                                        <div class="card-plan-price">
                                            <span class="price-amount">R$
                                                <?= number_format($p->getPreco(), 2, ',', '.') ?></span>
                                            <span class="price-period">/mês</span>
                                        </div>
                                    </div>

                                    <div class="card-plan-body">
                                        <?php if (!empty($p->getDescricao())): ?>
                                            <p class="card-plan-description"><?= htmlspecialchars($p->getDescricao()) ?></p>
                                        <?php endif; ?>

                                        <ul class="card-plan-features">
                                            <?php if (!empty($p->getMaquinas())): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Máquinas: <?= htmlspecialchars($p->getMaquinas()) ?>
                                                </li>
                                            <?php endif; ?>

                                            <?php if (!empty($p->getAulasGrupo())): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Aulas: <?= htmlspecialchars($p->getAulasGrupo()) ?>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($p->getTreinamentos()): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Treinamento personalizado
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($p->getConsultoria()): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Consultoria nutricional
                                                </li>
                                            <?php endif; ?>

                                            <?php if (!empty($p->getAvaliacao())): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Avaliação: <?= htmlspecialchars($p->getAvaliacao()) ?>
                                                </li>
                                            <?php endif; ?>

                                            <?php if (!empty($p->getAcesso())): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    Acesso: <?= htmlspecialchars($p->getAcesso()) ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>

                                    <div class="card-plan-footer">
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="plano_selecionado"
                                                value="<?= htmlspecialchars($p->getId()) ?>">

                                            <input type="password" name="senha_confirmacao"
                                                class="form-control form-control-sm mb-2"
                                                placeholder="Digite sua senha para confirmar" required>

                                            <button type="submit" name="confirmar_plano" class="btn-inscrever">
                                                <i class="fas fa-check-circle"></i>
                                                <?php
                                                if ($planoDoAluno && $planoDoAluno->getId() == $p->getId()) {
                                                    echo 'Plano Atual';
                                                } else {
                                                    echo 'Selecionar Plano';
                                                }
                                                ?>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Tabela Comparativa -->
                    <?php if (!empty($plano) && count($plano) > 1): ?>
                        <div class="comparison-section">
                            <h2 class="comparison-title">Compare os planos</h2>

                            <div class="table-responsive">
                                <table class="table table-comparison">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Benefícios</th>
                                            <?php foreach ($plano as $p): ?>
                                                <th class="text-center"><?= htmlspecialchars($p->getTipoPlano()) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-start"><strong>Preço Mensal</strong></td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center">
                                                    <strong class="text-success">R$
                                                        <?= number_format($p->getPreco(), 2, ',', '.') ?></strong>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Acesso a máquinas</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center"><?= htmlspecialchars($p->getMaquinas()) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Aulas de grupo</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center"><?= htmlspecialchars($p->getAulasGrupo()) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Treinamento personalizado</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center">
                                                    <?= $p->getTreinamentos() ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Consultoria nutricional</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center">
                                                    <?= $p->getConsultoria() ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Avaliação física</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center"><?= htmlspecialchars($p->getAvaliacao()) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Horário de acesso</td>
                                            <?php foreach ($plano as $p): ?>
                                                <td class="text-center"><?= htmlspecialchars($p->getAcesso()) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>


            <!-- ===================== SEÇÃO TREINO ===================== -->
            <div id="treino" class="hidden">

                <div class="content-header">
                    <h1 class="page-title">Histórico de Treinos</h1>
                    <p class="page-subtitle">Consulte os treinos realizados e o total de horas treinadas</p>
                </div>

                <div class="product-form-container">

                    <!-- Busca -->
                    <div class="form-section">
                        <h2 class="section-title">Buscar Treinos</h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Pesquisar por nome do treino</label>
                                <input type="text" class="form-control-custom"
                                    placeholder="Ex: Peito, Costas, Pernas...">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Filtrar por data</label>
                                <input type="date" class="form-control-custom">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Filtrar por duração</label>
                                <select class="form-control-custom">
                                    <option value="">Selecione</option>
                                    <option>Menos de 30 min</option>
                                    <option>30 min - 1h</option>
                                    <option>1h - 2h</option>
                                    <option>Mais de 2h</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Histórico -->
                    <div class="form-section">
                        <h2 class="section-title">Treinos Realizados</h2>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Treino</th>
                                        <th>Duração</th>
                                        <th>Calorias</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>

                                <tbody id="tabela-treinos">
                                    <tr>
                                        <td>20/11/2025</td>
                                        <td>Peito e Tríceps</td>
                                        <td>01:12h</td>
                                        <td>430 kcal</td>
                                        <td><button class="btn-techfit btn-primary">Ver</button></td>
                                    </tr>
                                    <tr>
                                        <td>18/11/2025</td>
                                        <td>Pernas e Ombros</td>
                                        <td>01:45h</td>
                                        <td>520 kcal</td>
                                        <td><button class="btn-techfit btn-primary">Ver</button></td>
                                    </tr>
                                    <tr>
                                        <td>16/11/2025</td>
                                        <td>Costas e Bíceps</td>
                                        <td>00:58h</td>
                                        <td>390 kcal</td>
                                        <td><button class="btn-techfit btn-primary">Ver</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="form-section">
                        <h2 class="section-title">Estatísticas Gerais</h2>

                        <div class="form-grid">

                            <div class="form-group">
                                <label cla ss="form-label">Total de treinos realizados</label>
                                <input type="text" class="form-control-custom" value="34 treinos" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Total de horas treinadas</label>
                                <input type="text" class="form-control-custom" value="41h e 22min" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Média semanal</label>
                                <input type="text" class="form-control-custom" value="4 treinos/semana" disabled>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== SEÇÃO FICHA ===================== -->
            <div id="ficha" class="hidden">

                <div class="content-header">
                    <h1 class="page-title">Ficha de Avaliação Física</h1>
                    <p class="page-subtitle">Acompanhe suas medidas, evolução e composição corporal</p>
                </div>

                <div class="product-form-container">
                    <?php
                    // Buscar ficha de avaliação física (mais recente)
                    $fichas = !empty($id) ? $controllerFisico->lerPorIdAluno($id) : [];
                    $fichaRecente = !empty($fichas) ? $fichas[0] : null;
                    ?>

                    <!-- Tabela com dados do banco -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-chart-line me-2"></i> Avaliação Física Mais Recente
                        </h2>


                        <?php if ($fichaRecente): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Campo</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Data da Avaliação</strong></td>
                                            <td><?= !empty($fichaRecente->getData()) ? date('d/m/Y', strtotime($fichaRecente->getData())) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Peso (kg)</strong></td>
                                            <td><?= !empty($fichaRecente->getPeso()) ? htmlspecialchars($fichaRecente->getPeso()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Altura (m)</strong></td>
                                            <td><?= !empty($fichaRecente->getAltura()) ? htmlspecialchars($fichaRecente->getAltura()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>IMC</strong></td>
                                            <td><?= !empty($fichaRecente->getImc()) ? htmlspecialchars($fichaRecente->getImc()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Peitoral (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getPeitoral()) ? htmlspecialchars($fichaRecente->getPeitoral()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cintura (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getCintura()) ? htmlspecialchars($fichaRecente->getCintura()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Quadril (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getQuadril()) ? htmlspecialchars($fichaRecente->getQuadril()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Braço Esquerdo (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getBraEsquerdo()) ? htmlspecialchars($fichaRecente->getBraEsquerdo()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Braço Direito (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getBraDireito()) ? htmlspecialchars($fichaRecente->getBraDireito()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Coxa (cm)</strong></td>
                                            <td><?= !empty($fichaRecente->getCoxa()) ? htmlspecialchars($fichaRecente->getCoxa()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gordura Corporal (%)</strong></td>
                                            <td><?= !empty($fichaRecente->getGordura()) ? htmlspecialchars($fichaRecente->getGordura()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Massa Magra (kg)</strong></td>
                                            <td><?= !empty($fichaRecente->getMasMagra()) ? htmlspecialchars($fichaRecente->getMasMagra()) : 'null' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>TMB (kcal)</strong></td>
                                            <td><?= !empty($fichaRecente->getTmb()) ? htmlspecialchars($fichaRecente->getTmb()) : 'null' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Sem dados registrados</strong>
                                <p>Você ainda não tem nenhuma ficha de avaliação. <a href="cadastrarFicha.php"
                                        class="alert-link">Clique aqui para criar uma</a></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Histórico de Avaliações -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-history me-2"></i> Histórico de Avaliações</h2>

                        <?php if (!empty($fichas) && count($fichas) > 1): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Data</th>
                                            <th>Peso (kg)</th>
                                            <th>Altura (m)</th>
                                            <th>IMC</th>
                                            <th>% Gordura</th>
                                            <th>Cintura (cm)</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fichas as $ficha): ?>
                                            <tr>
                                                <td><?= !empty($ficha->getData()) ? date('d/m/Y', strtotime($ficha->getData())) : 'null' ?>
                                                </td>
                                                <td><?= !empty($ficha->getPeso()) ? htmlspecialchars($ficha->getPeso()) : 'null' ?>
                                                </td>
                                                <td><?= !empty($ficha->getAltura()) ? htmlspecialchars($ficha->getAltura()) : 'null' ?>
                                                </td>
                                                <td><?= !empty($ficha->getImc()) ? htmlspecialchars($ficha->getImc()) : 'null' ?>
                                                </td>
                                                <td><?= !empty($ficha->getGordura()) ? htmlspecialchars($ficha->getGordura()) . '%' : 'null' ?>
                                                </td>
                                                <td><?= !empty($ficha->getCintura()) ? htmlspecialchars($ficha->getCintura()) : 'null' ?>
                                                </td>
                                                <td>
                                                    <a href="listaFichas.php?editar=<?= $ficha->getId() ?>"
                                                        class="btn btn-sm btn-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-secondary">
                                <i class="fas fa-calendar me-2"></i>
                                Você tem apenas 1 avaliação registrada. Crie mais fichas para acompanhar sua evolução.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="action-buttons">
                        <a href="cadastrarFicha.php" class="btn-techfit btn-primary">
                            <i class="fas fa-plus me-2"></i> Nova Avaliação
                        </a>
                        <a href="listaFichas.php" class="btn-techfit btn-success">
                            <i class="fas fa-list me-2"></i> Ver Todas as Fichas
                        </a>
                    </div>
                </div>
                <!-- Mensagem de sucesso da ficha -->
                <?php if (isset($_GET['ficha']) && $_GET['ficha'] === 'sucesso'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Ficha de avaliação cadastrada com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <?php
    require_once '../src/views/client/footer.php';
    ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/hidden.js"></script>
<script src="js/modal.js"></script>
<script src="js/treino.js"></script>
<script src="js/config.js"></script>

</html>



// No telaCliente.php, adicione debug temporário (remova depois):
<?php
echo "<!-- DEBUG: ";
echo "ID do Aluno: " . ($aluno['ID_ALUNO'] ?? 'null') . " | ";
echo "FK_PLANO: " . ($aluno['FK_PLANO'] ?? 'null') . " | ";
if ($planoDoAluno) {
    echo "Tipo Plano: " . $planoDoAluno->getTipoPlano();
}
echo " -->";
?>