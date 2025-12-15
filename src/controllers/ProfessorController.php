<?php

require_once __DIR__ .'/../models/Professor.php';
require_once __DIR__ . '/../models/ProfessorDAO.php';

class ProfessorController {

    private $dao;

    public function __construct() {
        $this->dao = new ProfessorDAO();
    }

    public function ler() {
        return $this->dao->lerProfessores();
    }

    public function criar($nomeProfessor, $cpf, $especialidade) {
        $professor = new Professor($nomeProfessor, $cpf, $especialidade);
        $this->dao->criarProfessor($professor);
    }

    public function excluir($id) {
        $this->dao->excluirProfessor($id);
    }

    public function atualizar($id, $nomeProfessor, $cpf, $especialidade) {
        $this->dao->atualizarProfessor($id, $nomeProfessor, $cpf, $especialidade);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }

   public function contar() {
        return $this->dao->contarProfessores();
    }

    public function especialidadeComMaisProfessores() {
        return $this->dao->especialidadeComMaisProfessores();
    }

    public function especialidadeComMenosProfessores() {
        return $this->dao->especialidadeComMenosProfessores();
    }
}
?>
