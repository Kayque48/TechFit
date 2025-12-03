<?php

session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: ../../public/loginCliente.php');
    exit;
}

// Verificar se o plano foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedPlan'])) {
    $email = $_SESSION['email'];
    $novoPlano = trim($_POST['selectedPlan']);

    // Validar o plano
    $planosValidos = ['basico', 'intermediario', 'premium'];
    if (!in_array($novoPlano, $planosValidos)) {
        echo json_encode(['success' => false, 'message' => 'Plano inválido.']);
        exit;
    }

    // Atualizar o plano no banco de dados
    require_once __DIR__ . '/../models/AlunoDAO.php';
    $alunoDAO = new AlunoDAO();

    try {
        $alunoDAO->atualizarPlano($email, $novoPlano);
        echo json_encode(['success' => true, 'message' => 'Plano atualizado com sucesso!', 'data' => ['plano' => $novoPlano]]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o plano: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}