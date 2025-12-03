<?php

    session_start();

    // Verificar se o usuário está logado
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header('Location: loginCliente.php');
        exit;
    }

    require_once __DIR__ . '/../src/controllers/FisicoController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>>Ficha de Avalição - TechFit</title>
</head>
<body>

<form action="" method="post">
    <input type="hidden" name="acao" value="criar">

    <!-- Data da Avaliação -->
    <label for="data">Data da Avaliação:</label>
    <input type="date" id="data" name="data" required>

    <!-- Peso -->
    <label for="peso">Peso (kg):</label>
    <input type="number" id="peso" name="peso" step="0.1" required>

    <!-- Altura -->
    <label for="altura">Altura (m):</label>
    <input type="number" id="altura" name="altura" step="0.01" required>

    <!-- Peitoral -->
    <label for="peitoral">Peitoral (cm):</label>
    <input type="number" id="peitoral" name="peitoral" step="0.1" required>

    <!-- Cintura -->
    <label for="cintura">Cintura (cm):</label>
    <input type="number" id="cintura" name="cintura" step="0.1" required>

    <!-- Quadril -->
    <label for="quadril">Quadril (cm):</label>
    <input type="number" id="quadril" name="quadril" step="0.1" required>

    <!-- Braço Esquerdo -->
    <label for="braEsquerdo">Braço Esquerdo (cm):</label>
    <input type="number" id="braEsquerdo" name="braEsquerdo" step="0.1" required>

    <!-- Braço Direito -->
    <label for="braDireito">Braço Direito (cm):</label>
    <input type="number" id="braDireito" name="braDireito" step="0.1" required>

    <!-- Coxa -->
    <label for="coxa">Coxa (cm):</label>
    <input type="number" id="coxa" name="coxa" step="0.1" required>

    <!-- Gordura Corporal -->
    <label for="gordura">Gordura Corporal (%):</label>
    <input type="number" id="gordura" name="gordura" step="0.1" required>

    <!-- Massa Magra -->
    <label for="masMagra">Massa Magra (kg):</label>
    <input type="number" id="masMagra" name="masMagra" step="0.1" required>

    <!-- TMB -->
    <label for="tmb">Taxa Metabólica Basal (kcal):</label>
    <input type="number" id="tmb" name="tmb" step="1" required>

    <!-- IMC -->
    <label for="imc">Índice de Massa Corporal (IMC):</label>
    <input type="number" id="imc" name="imc" step="0.1" required>

    <button type="submit">Cadastrar Ficha</button>
</form>
    
</body>
</html>