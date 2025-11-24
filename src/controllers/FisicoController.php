<?php

    require_once __DIR__ .'/../models/Aluno.php';
    require_once __DIR__ . '/../models/FisicoDAO.php';

    class FisicoController {

        private $dao;

        public function __construct() {
            $this->dao = new FisicoDAO();
        }

        public function ler() {
            return $this->dao->lerAvaliacoes();
        }

        public function criar($data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc) {
            $fisico = new Fisico( $data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc);
            $this->dao->criarAvaliacao($fisico);
        }

        public function excluir($data) {
            $this->dao->excluirAvaliacao($data);
        }
    }
?>