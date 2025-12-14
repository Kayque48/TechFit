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

        public function lerPorId($id) {
            return $this->dao->buscarPorId($id);
        }

        public function criar($nome, $dataNasc, $endereco, $telefone, $email, $plano, $senhaHash = null) {
            $aluno = new Aluno( $nome, $dataNasc, $endereco, $telefone, $email, $plano, $senhaHash);
            $this->dao->criarAluno($aluno);
        }

        public function excluir($id) {
            $this->dao->excluirAluno($id);
        }
        public function atualizar($id, $nome, $dataNasc, $endereco, $telefone, $email) {
            $this->dao->atualizarAlunoPorId($id, $nome, $dataNasc, $endereco, $telefone, $email);
        }

        public function buscarPorEmail($email) {
            return $this->dao->buscarPorEmail($email);
        }

        public function buscarPorId($id) {
            return $this->dao->buscarPorId($id);
        }

        public function getDAO() {
            return $this->dao;
        }

        public function contar() {
            return $this->dao->contarAlunos();
        }

        public function contarPorPlano($planoId) {
            return $this->dao->contarAlunosPorPlano($planoId);
        }

        public function planoComMaisAlunos() {
            return $this->dao->planoComMaisAlunos();
        }

        public function planoComMenosAlunos() {
            return $this->dao->planoComMenosAlunos();
        }

}

?>