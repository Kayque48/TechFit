<?php

require_once '../src/controllers/PlanoController.php';
$controller = new PlanoController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? null;
    if ($acao == 'criar') {
        $controller->criar(
            $_POST['tipoPlano'],
            $_POST['duracaoMes'],
            $_POST['preco']
        );
    } elseif ($acao === 'deletar') {
        $controller->excluir($_POST['nome']);
    } elseif ($acao === 'editar') {
        $controller->atualizar(
            $_POST['id'],
            $_POST['tipoPlano'],
            $_POST['duracaoMes'],
            $_POST['preco']
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug CRUD Planos</title>
</head>
<body>

    <h1>Cadastrar Plano</h1>
    <form action="" method="post">
        <input type="text" name="acao" value="criar">

        <label for="Tipo do Plano">Nome Plano</label>
        <input type="text" name="tipoPlano" required>

        <label for="Duração em Meses"></label>
        <input type="number" name="duracaoMes" required>

        <label for="Preço"></label>
        <input type="number" step="0.01" name="preco" required>
        <button type="submit">Cadastrar Plano</button>
    </form>

    <table>
        <th>
            <tr>
                <td>ID</td>
                <td>Tipo do Plano</td>
                <td>Duração em Meses</td>
                <td>Preço</td>
            </tr>
        </th>
        <tbody>
            <?php
                $planos = $controller->ler();
                foreach ($planos as $plano) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($plano->getId()) . "</td>";
                    echo "<td>" . htmlspecialchars($plano->getTipoPlano()) . "</td>";
                    echo "<td>" . htmlspecialchars($plano->getDuracaoMes()) . "</td>";
                    echo "<td>" . htmlspecialchars($plano->getPreco()) . "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>


    
</body>
</html>