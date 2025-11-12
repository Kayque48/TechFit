<?php

    require_once '../models/Aula.php';
    require_once '../models/AulaDAO.php';

    class AulaController {

        private $dao;

        public function __construct() {
            $this->dao = new AulaDAO();
        }

        public function ler() {
            return $this->dao->lerAula();
        }

        public function criar($id, $nome, $idade, $endereco, $telefone, $avalicao) {
            $bebidas = new Aula($id, $nome, $idade, $endereco, $telefone, $avalicao);
            $this->dao->criarAula($bebidas);
        }

        public function excluir($nome) {
            $this->dao->excluirAula($nome);
        }
    }
?>