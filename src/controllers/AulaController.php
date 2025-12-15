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

    public function criar($nomeAula, $tipo, $tempo, $data, $professor) {
        $aula = new Aula($nomeAula, $tipo, $tempo, $data, $professor);
        $this->dao->criarAula($aula);
    }

    public function excluir($id) {
        $this->dao->excluirAula($id);
    }

    public function atualizar($id, $nomeAula, $tipo, $tempo, $data, $professor) {
        $this->dao->atualizarAula($id, $nomeAula, $tipo, $tempo, $data, $professor);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
