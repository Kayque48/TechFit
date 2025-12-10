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
            $mensagem = '✓ Plano criado com sucesso!';
            $tipoMensagem = 'sucesso';
        } elseif ($acao === 'deletar') {
            $controller->excluir($_POST['id']);
            $mensagem = '✓ Plano excluído com sucesso!';
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
            $mensagem = '✓ Plano atualizado com sucesso!';
            $tipoMensagem = 'sucesso';
        }
    } catch (Exception $e) {
        $mensagem = '✗ Erro: ' . $e->getMessage();
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
    <title>Debug CRUD Planos</title>
</head>

<body>
    <h1>🏋️ Debug CRUD - Gestão de Planos</h1>

    <p><strong>ℹ️ Informação:</strong> Esta é uma página de debug para testar todas as operações CRUD dos planos da
        academia.</p>

    <?php if ($mensagem): ?>
        <p
            style="padding: 10px; background-color: <?php echo $tipoMensagem === 'sucesso' ? '#d4edda' : '#f8d7da'; ?>; border: 1px solid <?php echo $tipoMensagem === 'sucesso' ? '#c3e6cb' : '#f5c6cb'; ?>;">
            <?php echo $mensagem; ?>
        </p>
    <?php endif; ?>

    <hr>

    <h2><?php echo $planoEditar ? '✏️ Editar Plano' : '➕ Cadastrar Novo Plano'; ?></h2>
    <form action="" method="post">
        <input type="hidden" name="acao" value="<?php echo $planoEditar ? 'editar' : 'criar'; ?>">
        <?php if ($planoEditar): ?>
            <input type="hidden" name="id" value="<?php echo $planoEditar->getId(); ?>">
        <?php endif; ?>

        <p>
            <label for="tipoPlano"><strong>Tipo do Plano *</strong></label><br>
            <input type="text" name="tipoPlano" id="tipoPlano" size="50"
                value="<?php echo $planoEditar ? htmlspecialchars($planoEditar->getTipoPlano()) : ''; ?>" required>
        </p>

        <p>
            <label for="descricao"><strong>Descrição</strong></label><br>
            <textarea name="descricao" id="descricao" rows="3"
                cols="50"><?php echo $planoEditar ? htmlspecialchars($planoEditar->getDescricao()) : ''; ?></textarea>
        </p>

        <p>
            <label for="preco"><strong>Preço (R$) *</strong></label><br>
            <input type="number" step="0.01" name="preco" id="preco"
                value="<?php echo $planoEditar ? htmlspecialchars($planoEditar->getPreco()) : ''; ?>" required>
        </p>

        <p>
            <label for="acesso"><strong>Horário de Acesso</strong></label><br>
            <select name="acesso" id="acesso">
                <option value="Comercial" <?php echo ($planoEditar && $planoEditar->getAcesso() == "Comercial") ? "selected" : ""; ?>>Comercial</option>

                <option value="Estendido" <?php echo ($planoEditar && $planoEditar->getAcesso() == "Estendido") ? "selected" : ""; ?>>Estendido</option>

                <option value="24h" <?php echo ($planoEditar && $planoEditar->getAcesso() == "24h") ? "selected" : ""; ?>>
                    24h</option>
            </select>
        </p>

        <p><strong>Recursos Inclusos:</strong></p>
        <p>
            <label for="maquinas" id="maquinas"><strong>Nível de Acesso às Máquinas</strong></label>
            <select name="maquinas" id="maquinas">
                <option value="Limitado" <?php echo ($planoEditar && $planoEditar->getMaquinas() == "Limitado") ? "selected" : ""; ?>>Limitado</option>

                <option value="Total" <?php echo ($planoEditar && $planoEditar->getMaquinas() == "Total") ? "selected" : ""; ?>>Total</option>

                <option value="Total 24/7" <?php echo ($planoEditar && $planoEditar->getMaquinas() == "Total 24/7") ? "selected" : ""; ?>>Total 24/7</option>
            </select>
        </p>

        <p>
            <label><strong>Aluas em Grupo</strong></label>
            <select name="aulasGrupo" id="aulasGrupo">
                <option value="1 aula por semana" <?php echo ($planoEditar && $planoEditar->getAulasGrupo() == "1 aula por semana") ? "selected" : ""; ?>>1 aula por semana</option>

                <option value="3 aulas por semana" <?php echo ($planoEditar && $planoEditar->getAulasGrupo() == "3 aulas por semana") ? "selected" : ""; ?>>3 aulas por semana</option>

                <option value="Ilimitado" <?php echo ($planoEditar && $planoEditar->getAulasGrupo() == "Ilimitado") ? "selected" : ""; ?>>Ilimitado</option>
            </select>
        </p>

        <p>
            <label for="treinamentos"><strong>Treinamento personalizado</strong></label>
            <select name="treinamentos" id="treinamentos" class="form-select">
                <option value="nao_incluso" <?php echo ($planoEditar && $planoEditar->getTreinamentos() == "Não incluso") ? "selected" : ""; ?>>Não incluso</option>
                <option value="2x_mes" <?php echo ($planoEditar && $planoEditar->getTreinamentos() == "2x por mês") ? "selected" : ""; ?>>2x por mês</option>
                <option value="ilimitado" <?php echo ($planoEditar && $planoEditar->getTreinamentos() == "Ilimitado") ? "selected" : ""; ?>>Ilimitado</option>
            </select>

        </p>

        <p>
            <label for="consultorial"><strong>Consultoria nutricional</strong></label>
            <select name="consultoria" id="consultoria" class="form-select">
                <option value="nao_incluso" <?php echo ($planoEditar && $planoEditar->getConsultoria() == "Não incluso") ? "selected" : ""; ?>>Não incluso</option>
                <option value="1x_mes" <?php echo ($planoEditar && $planoEditar->getConsultoria() == "1x por mês") ? "selected" : ""; ?>>1x por mês</option>
                <option value="quinzenal" <?php echo ($planoEditar && $planoEditar->getConsultoria() == "Quinzenal") ? "selected" : ""; ?>>Quinzenal</option>
            </select>
        </p>

        <p>
            <label for="avaliacao"><strong>Avaliação física</strong></label>
            <select name="avaliacao" id="avaliacao" class="form-select">
                <option value="trimestral" <?php echo ($planoEditar && $planoEditar->getAvaliacao() == "Trimestral") ? "selected" : ""; ?>>Trimestral</option>
                <option value="bimestral" <?php echo ($planoEditar && $planoEditar->getAvaliacao() == "Bimestral") ? "selected" : ""; ?>>Bimestral</option>
                <option value="mensal" <?php echo ($planoEditar && $planoEditar->getAvaliacao() == "Mensal") ? "selected" : ""; ?>>Mensal</option>
            </select>
        </p>

        <p>
            <button type="submit"><?php echo $planoEditar ? 'Atualizar Plano' : 'Cadastrar Plano'; ?></button>
            <?php if ($planoEditar): ?>
                <a href="?">Cancelar</a>
            <?php endif; ?>
        </p>
    </form>

    <hr>

    <h2>📋 Lista de Planos Cadastrados</h2>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>ID</th>
                <th>Tipo do Plano</th>
                <th>Descrição</th>
                <th>Máquinas</th>
                <th>Aulas Grupo</th>
                <th>Treinamentos</th>
                <th>Consultoria</th>
                <th>Avaliação</th>
                <th>Acesso</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $planos = $controller->ler();
            if (empty($planos)) {
                echo "<tr><td colspan='11' style='text-align: center;'>Nenhum plano cadastrado ainda.</td></tr>";
            } else {
                foreach ($planos as $plano) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($plano->getId()) . "</td>";
                    echo "<td><strong>" . htmlspecialchars($plano->getTipoPlano()) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($plano->getDescricao()) . "</td>";
                    echo "<td>" . ($plano->getMaquinas()) . "</td>";
                    echo "<td>" . ($plano->getAulasGrupo()) . "</td>";
                    echo "<td>" . ($plano->getTreinamentos()) . "</td>";
                    echo "<td>" . ($plano->getConsultoria()) . "</td>";
                    echo "<td>" . ($plano->getAvaliacao()) . "</td>";
                    echo "<td>" . htmlspecialchars($plano->getAcesso()) . "</td>";
                    echo "<td>R$ " . number_format($plano->getPreco(), 2, ',', '.') . "</td>";
                    echo "<td>";
                    echo "<a href='?editar=" . $plano->getId() . "'>Editar</a> | ";
                    echo "<form action='' method='post' style='display: inline;' onsubmit='return confirm(\"Tem certeza que deseja excluir este plano?\")'>";
                    echo "<input type='hidden' name='acao' value='deletar'>";
                    echo "<input type='hidden' name='id' value='" . $plano->getId() . "'>";
                    echo "<button type='submit' style='color: red; background: none; border: none; cursor: pointer; text-decoration: underline;'>Excluir</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <hr>
    <p><small>Debug CRUD - Versão 1.0 | Total de planos: <?php echo count($planos ?? []); ?></small></p>

</body>

</html>