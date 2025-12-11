<?php

    require_once __DIR__ .'/../models/Aluno.php';
    require_once __DIR__ . '/../models/AlunoDAO.php';

    class AlunoController {

        private $dao;

        public function __construct() {
            $this->dao = new AlunoDAO();
        }

        public function ler() {
            return $this->dao->lerAlunos();
        }

        public function criar($nome, $dataNasc, $endereco, $telefone, $email, $plano, $senhaHash = null) {
            $aluno = new Aluno( $nome, $dataNasc, $endereco, $telefone, $email, $plano, $senhaHash);
            $this->dao->criarAluno($aluno);
        }

        public function excluir($nome) {
            $this->dao->excluirAluno($nome);
        }
        
        public function atualizar($nome, $novoNome, $novoDataNasc, $novoEndereco, $novoTelefone, $novoEmail, $novoPlano) {
            $this->dao->atualizarAluno($nome, $novoNome, $novoDataNasc, $novoEndereco, $novoTelefone, $novoEmail, $novoPlano);
        }

        public function buscarPorEmail($email) {
            return $this->dao->buscarPorEmail($email);
        }

        public function getDAO() {
            return $this->dao;
        }

        public function contar() {
            return $this->dao->contarAlunos();
        }

}

?>