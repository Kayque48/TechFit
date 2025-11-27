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

        public function criar($nome, $idade, $endereco, $telefone, $email, $avaliacao, $plano, $senhaHash = null) {
            $aluno = new Aluno( $nome, $idade, $endereco, $telefone, $email, $avaliacao, $plano, $senhaHash);
            $this->dao->criarAluno($aluno);
        }

        public function excluir($nome) {
            $this->dao->excluirAluno($nome);
        }

        public function atualizar($nome, $novoNome, $novaIdade, $novoEndereco, $novoTelefone, $novoEmail, $novaAvaliacao, $plano) {
            $this->dao->atualizarAluno($nome, $novoNome, $novaIdade, $novoEndereco, $novoTelefone, $novoEmail, $novaAvaliacao, $plano);
        }

        public function buscarPorEmail($email) {
            return $this->dao->buscarPorEmail($email);
        }

        public function getDAO() {
            return $this->dao;
        }
    }
?>