<?php

require_once __DIR__ .'/../models/Plano.php';
require_once __DIR__ . '/../models/PlanoDAO.php';

class PlanoController {

    private $dao;

    public function __construct() {
        $this->dao = new PlanoDAO();
    }

    public function ler() {
        return $this->dao->lerPlanos();
    }

    public function criar($tipoPlano, $duracaoMes, $preco) {
        $plano = new Plano($tipoPlano, $duracaoMes, $preco);
        $this->dao->criarPlano($plano);
    }

    public function excluir($id) {
        $this->dao->excluirPlano($id);
    }

    public function atualizar($id, $tipoPlano, $duracaoMes, $preco) {
        $this->dao->atualizarPlano($id, $tipoPlano, $duracaoMes, $preco);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
