<?php

    require_once __DIR__ .'/../models/Agendamento.php';
    require_once __DIR__ . '/../models/AgendamentoDAO.php';

    class AgendamentoController {

        private $dao;

        public function __construct() {
            $this->dao = new AgendamentoDAO();
        }

        public function ler() {
            return $this->dao->lerAgendamentos();
        }

        public function criar($alunoId, $aulaId) {
            $agendamento = new Agendamento( $alunoId, $aulaId);
            $this->dao->criarAgendamento($agendamento);
        }

        public function excluir($id) {
            $this->dao->excluirAgendamento($id);
        }
    }