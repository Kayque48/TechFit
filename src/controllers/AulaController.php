<?php

require_once __DIR__ .'/../models/Aula.php';
require_once __DIR__ . '/../models/AulaDAO.php';

class AulaController {

    private $dao;

    public function __construct() {
        $this->dao = new AulaDAO();
    }

    public function ler() {
        return $this->dao->lerAulas();
    }

    public function criar($nomeAula, $avaliacao) {
        $aula = new Aula($nomeAula, $avaliacao);
        $this->dao->criarAula($aula);
    }

    public function excluir($id) {
        $this->dao->excluirAula($id);
    }

    public function atualizar($id, $nomeAula, $avaliacao) {
        $this->dao->atualizarAula($id, $nomeAula, $avaliacao);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
