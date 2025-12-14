<?php

require_once __DIR__ . '/../src/controllers/PlanoController.php';
$controller = new PlanoController();

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? null;

    try {
        if ($acao == 'criar') {
            $controller->criar(
                $_POST['tipoPlano'],
                $_POST['descricao'],
                $_POST['maquinas'],
                $_POST['aulasGrupo'],
                $_POST['treinamentos'],
                $_POST['consultoria'],
                $_POST['avaliacao'],
                $_POST['acesso'],
                $_POST['preco']
            );
            $mensagem = 'Plano criado com sucesso!';
            $tipoMensagem = 'sucesso';
        } elseif ($acao === 'deletar') {
            $controller->excluir($_POST['id']);
            $mensagem = 'Plano excluído com sucesso!';
            $tipoMensagem = 'sucesso';
        } elseif ($acao === 'editar') {
            $controller->atualizar(
                $_POST['id'],
                $_POST['tipoPlano'],
                $_POST['descricao'],
                $_POST['maquinas'],
                $_POST['aulasGrupo'],
                $_POST['treinamentos'],
                $_POST['consultoria'],
                $_POST['avaliacao'],
                $_POST['acesso'],
                $_POST['preco']
            );
            $mensagem = 'Plano atualizado com sucesso!';
            $tipoMensagem = 'sucesso';
        }
    } catch (Exception $e) {
        $mensagem = 'Erro: ' . $e->getMessage();
        $tipoMensagem = 'erro';
    }
}

$planoEditar = null;
if (isset($_GET['editar'])) {
    $planoEditar = $controller->buscarPorId($_GET['editar']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Planos - TechFit</title>

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
            --gray-medium: #e9ecef;
        }

        body {
            background: linear-gradient(135deg, var(--gray-light) 0%, #e8f4f8 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Header */
        .crud-header {
            background: linear-gradient(135deg, var(--verde-escuro), #2a7a4a);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .crud-header h1 {
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .crud-header .subtitle {
            opacity: 0.9;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Container Principal */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
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

        /* Card do Formulário */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
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

        /* Form Grid */
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

        .form-control,
        .form-select,
        .form-textarea {
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-medium);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--azul);
            box-shadow: 0 0 0 0.2rem rgba(0, 147, 209, 0.15);
            transform: translateY(-2px);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
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

        .btn-danger-custom {
            background: linear-gradient(135deg, var(--laranja), #d35400);
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, var(--amarelo), #e6b400);
            color: var(--verde-escuro);
        }

        /* Tabela */
        .table-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease-out 0.2s both;
        }

        .table-header {
            background: linear-gradient(135deg, var(--verde-claro), #5a9438);
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .badge-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-custom {
            width: 100%;
            margin: 0;
        }

        .table-custom thead {
            background: var(--gray-light);
        }

        .table-custom thead th {
            padding: 1.25rem 1rem;
            font-weight: 700;
            color: var(--verde-escuro);
            border-bottom: 3px solid var(--verde-claro);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-custom tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-medium);
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: rgba(104, 168, 66, 0.05);
            transform: scale(1.01);
        }

        /* Badge de Preço */
        .price-badge {
            background: linear-gradient(135deg, var(--azul), #007bb8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Ações da Tabela */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-edit {
            background: linear-gradient(135deg, var(--amarelo), #e6b400);
            color: var(--verde-escuro);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--laranja), #d35400);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-dark);
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.3;
            margin-bottom: 1rem;
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
            .crud-header {
                padding: 1.5rem 0;
            }

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

            .table-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="crud-header">
        <div class="main-container">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                Gestão de Planos
            </h1>
            <p class="subtitle">Gerencie todos os planos da academia TechFit</p>
        </div>
    </div>

    <div class="main-container">
        <a href="telaAdministrador.php" class="text-decoration-none d-flex align-items-center" style="color: var(--verde-escuro); font-weight: 600;">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar
        </a>

        <!-- Mensagens -->
        <?php if ($mensagem): ?>
            <div class="alert-custom alert-<?= $tipoMensagem ?>">
                <i class="fas fa-<?= $tipoMensagem === 'sucesso' ? 'check-circle' : 'exclamation-circle' ?> fa-lg"></i>
                <span><?= htmlspecialchars($mensagem) ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulário -->
        <div class="form-card">
            <div class="form-card-header">
                <h3 class="form-card-title">
                    <i class="fas fa-<?= $planoEditar ? 'edit' : 'plus-circle' ?>"></i>
                    <?= $planoEditar ? 'Editar Plano' : 'Cadastrar Novo Plano' ?>
                </h3>
                <?php if ($planoEditar): ?>
                    <a href="?" class="btn-custom btn-secondary-custom">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                <?php endif; ?>
            </div>

            <form action="" method="post">
                <input type="hidden" name="acao" value="<?= $planoEditar ? 'editar' : 'criar' ?>">
                <?php if ($planoEditar): ?>
                    <input type="hidden" name="id" value="<?= $planoEditar->getId() ?>">
                <?php endif; ?>

                <!-- Informações Básicas -->
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Tipo do Plano</label>
                        <input
                            type="text"
                            class="form-control"
                            name="tipoPlano"
                            value="<?= $planoEditar ? htmlspecialchars($planoEditar->getTipoPlano()) : '' ?>"
                            required
                            placeholder="Ex: Básico, Premium...">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Preço (R$)</label>
                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="preco"
                            value="<?= $planoEditar ? htmlspecialchars($planoEditar->getPreco()) : '' ?>"
                            required
                            placeholder="0.00">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descrição</label>
                    <textarea
                        class="form-textarea"
                        name="descricao"
                        rows="3"
                        placeholder="Descreva os principais benefícios deste plano..."><?= $planoEditar ? htmlspecialchars($planoEditar->getDescricao()) : '' ?></textarea>
                </div>

                <!-- Recursos do Plano -->
                <h4 style="color: var(--verde-escuro); margin: 2rem 0 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-star"></i> Recursos Inclusos
                </h4>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Acesso às Máquinas</label>
                        <select name="maquinas" class="form-select">
                            <option value="Limitado" <?= ($planoEditar && $planoEditar->getMaquinas() == "Limitado") ? "selected" : "" ?>>Limitado</option>
                            <option value="Total" <?= ($planoEditar && $planoEditar->getMaquinas() == "Total") ? "selected" : "" ?>>Total</option>
                            <option value="Total 24/7" <?= ($planoEditar && $planoEditar->getMaquinas() == "Total 24/7") ? "selected" : "" ?>>Total 24/7</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Aulas em Grupo</label>
                        <select name="aulasGrupo" class="form-select">
                            <option value="1 aula por semana" <?= ($planoEditar && $planoEditar->getAulasGrupo() == "1 aula por semana") ? "selected" : "" ?>>1 aula por semana</option>
                            <option value="3 aulas por semana" <?= ($planoEditar && $planoEditar->getAulasGrupo() == "3 aulas por semana") ? "selected" : "" ?>>3 aulas por semana</option>
                            <option value="Ilimitado" <?= ($planoEditar && $planoEditar->getAulasGrupo() == "Ilimitado") ? "selected" : "" ?>>Ilimitado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Treinamento Personalizado</label>
                        <select name="treinamentos" class="form-select">
                            <option value="Não incluso" <?= ($planoEditar && $planoEditar->getTreinamentos() == "Não incluso") ? "selected" : "" ?>>Não incluso</option>
                            <option value="2x por mês" <?= ($planoEditar && $planoEditar->getTreinamentos() == "2x por mês") ? "selected" : "" ?>>2x por mês</option>
                            <option value="Ilimitado" <?= ($planoEditar && $planoEditar->getTreinamentos() == "Ilimitado") ? "selected" : "" ?>>Ilimitado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Consultoria Nutricional</label>
                        <select name="consultoria" class="form-select">
                            <option value="Não incluso" <?= ($planoEditar && $planoEditar->getConsultoria() == "Não incluso") ? "selected" : "" ?>>Não incluso</option>
                            <option value="1x por mês" <?= ($planoEditar && $planoEditar->getConsultoria() == "1x por mês") ? "selected" : "" ?>>1x por mês</option>
                            <option value="Quinzenal" <?= ($planoEditar && $planoEditar->getConsultoria() == "Quinzenal") ? "selected" : "" ?>>Quinzenal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Avaliação Física</label>
                        <select name="avaliacao" class="form-select">
                            <option value="Trimestral" <?= ($planoEditar && $planoEditar->getAvaliacao() == "Trimestral") ? "selected" : "" ?>>Trimestral</option>
                            <option value="Bimestral" <?= ($planoEditar && $planoEditar->getAvaliacao() == "Bimestral") ? "selected" : "" ?>>Bimestral</option>
                            <option value="Mensal" <?= ($planoEditar && $planoEditar->getAvaliacao() == "Mensal") ? "selected" : "" ?>>Mensal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Horário de Acesso</label>
                        <select name="acesso" class="form-select">
                            <option value="Comercial" <?= ($planoEditar && $planoEditar->getAcesso() == "Comercial") ? "selected" : "" ?>>Comercial</option>
                            <option value="Estendido" <?= ($planoEditar && $planoEditar->getAcesso() == "Estendido") ? "selected" : "" ?>>Estendido</option>
                            <option value="24h" <?= ($planoEditar && $planoEditar->getAcesso() == "24h") ? "selected" : "" ?>>24h</option>
                        </select>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="btn-group-custom">
                    <button type="submit" class="btn-custom btn-primary-custom">
                        <i class="fas fa-save"></i>
                        <?= $planoEditar ? 'Atualizar Plano' : 'Cadastrar Plano' ?>
                    </button>
                    <?php if ($planoEditar): ?>
                        <a href="?" class="btn-custom btn-secondary-custom">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script>
        function contarAlunosPorPlano() {
            // Função fictícia para contar alunos por plano
            // Substitua com a lógica real conforme necessário
            const contagem = {
                1: 25,
                2: 10,
                3: 5
            };
            return contagem[planoId] || 0;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>