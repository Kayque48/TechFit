<?php

require_once __DIR__ .'/../models/Filial.php';
require_once __DIR__ . '/../models/FilialDAO.php';

class FilialController {

    private $dao;

    public function __construct() {
        $this->dao = new FilialDAO();
    }

    public function ler() {
        return $this->dao->lerFiliais();
    }

    public function criar($endereco, $cep, $cargaMax = 50, $numColaboradores = 0) {
        $filial = new Filial($endereco, $cep, $cargaMax, $numColaboradores);
        $this->dao->criarFilial($filial);
    }

    public function excluir($id) {
        $this->dao->excluirFilial($id);
    }

    public function atualizar($id, $endereco, $cep, $cargaMax, $numColaboradores) {
        $this->dao->atualizarFilial($id, $endereco, $cep, $cargaMax, $numColaboradores);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
