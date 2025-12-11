<?php

require_once __DIR__ .'/../models/Treino.php';
require_once __DIR__ . '/../models/TreinoDAO.php';

class TreinoController {

    private $dao;

    public function __construct() {
        $this->dao = new TreinoDAO();
    }

    public function ler() {
        return $this->dao->lerTreinos();
    }

    public function lerPorAluno($idAluno) {
        return $this->dao->buscarPorIdAluno($idAluno);
    }

    public function criar($nome, $diaSemana, $horarioInicio, $horarioFim, $instrutor, $descricao, $calorias, $idAluno) {
        $treino = new Treino(
            null,
            $nome,
            $diaSemana,
            $horarioInicio,
            $horarioFim,
            $instrutor,
            $descricao,
            $calorias,
            $idAluno,
            date('Y-m-d')
        );
        $this->dao->criarTreino($treino);
    }

    public function excluir($id) {
        $this->dao->excluirTreino($id);
    }

    public function atualizar($id, $nome, $diaSemana, $horarioInicio, $horarioFim, $instrutor, $descricao, $calorias) {
        $this->dao->atualizarTreino($id, $nome, $diaSemana, $horarioInicio, $horarioFim, $instrutor, $descricao, $calorias);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}