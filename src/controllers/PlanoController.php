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

    public function criar($tipoPlano, $descricao, $maquinas, $aulasGrupo, $treinamentos, $consultoria, $avaliacao, $acesso, $preco) {
        $plano = new Plano(
            null, // ID será gerado pelo banco
            $tipoPlano,
            $descricao,
            $maquinas,
            $aulasGrupo,
            $treinamentos,
            $consultoria,
            $avaliacao,
            $acesso,
            $preco
        );
        $this->dao->criarPlano($plano);
    }

    public function excluir($id) {
        $this->dao->excluirPlano($id);
    }

    public function atualizar($id, $tipoPlano, $descricao, $maquinas, $aulasGrupo, $treinamentos, $consultoria, $avaliacao, $acesso, $preco) {
        $this->dao->atualizarPlano(
            $id,
            $tipoPlano,
            $descricao,
            $maquinas,
            $aulasGrupo,
            $treinamentos,
            $consultoria,
            $avaliacao,
            $acesso,
            $preco
        );
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>