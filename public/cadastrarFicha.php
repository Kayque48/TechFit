<?php

    session_start();

    // Verificar se o usuário está logado
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header('Location: loginCliente.php');
        exit;
    }

    require_once __DIR__ . '/../src/controllers/FisicoController.php';