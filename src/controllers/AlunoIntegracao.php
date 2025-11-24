<?php

require_once 'AlunoController.php';
$controller = new AlunoController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? null;
    if ($acao == 'criar') {
        $controller->criar(
            $_POST['nome'],
            $_POST['idade'],
            $_POST['endereco'],
            $_POST['telefone'],
            $_POST['email'],
            $_POST['avaliacao']
        );
    } elseif ($acao === 'deletar') {
        $controller->excluir($_POST['nome']);
    } elseif ($acao === 'editar') {
        $controller->atualizar(
            $_POST['nome'],
            $_POST['novoNome'],
            $_POST['novaIdade'],
            $_POST['novoEndereco'],
            $_POST['novoTelefone'],
            $_POST['novoEmail'],
            $_POST['novaAvaliacao']
        );
    }
}
?>