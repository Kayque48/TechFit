<?php

    require_once __DIR__ .'/../models/Fisico.php';
    require_once __DIR__ . '/../models/FisicoDAO.php';

    class FisicoController {

        private $dao;

        public function __construct() {
            $this->dao = new FisicoDAO();
        }

        // READ - Todas as avaliações
        public function ler() {
            return $this->dao->lerAvaliacoes();
        }

        // READ - Avaliações de um aluno específico
        public function lerPorIdAluno($idAluno) {
            return $this->dao->buscarPorIdAluno($idAluno);
        }

        // READ - Uma avaliação específica
        public function lerPorId($idAvaliacao) {
            return $this->dao->buscarPorId($idAvaliacao);
        }

        // CREATE
        public function criar($data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc, $idAluno) {
            $fisico = new Fisico($data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc, $idAluno);
            $this->dao->criarAvaliacao($fisico);
        }

        // UPDATE
        public function atualizar($id, $data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc, $aluno) {
            $fisico = new Fisico($data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc, $aluno,);
            $this->dao->atualizarAvaliacao($fisico);
        }

        // DELETE
        public function excluir($idAvaliacao) {
            $this->dao->excluirAvaliacao($idAvaliacao);
        }
    }
?>