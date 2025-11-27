<?php

require_once 'FisicoController.php';
$controller = new FisicoController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? null;
    if ($acao == 'criar') {
        $controller->criar(
            $_POST['data'],
            $_POST['peso'],
            $_POST['altura'],
            $_POST['peitoral'],
            $_POST['cintura'],
            $_POST['quadril'],
            $_POST['braEsquerdo'],
            $_POST['braDireito'],
            $_POST['coxa'],
            $_POST['gordura'],
            $_POST['masMagra'],
            $_POST['tmb'],
            $_POST['imc'],
            $_POST['aluno']
        );
    } elseif ($acao === 'deletar') {
        $controller->excluir($_POST['data']);
    }
}
?>