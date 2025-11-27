<?php

require_once __DIR__ .'/../models/Administrador.php';
require_once __DIR__ . '/../models/AdministradorDAO.php';

class AdministradorController {

    private $dao;

    public function __construct() {
        $this->dao = new AdministradorDAO();
    }

    public function ler() {
        return $this->dao->lerAdministradores();
    }

    public function criar($auser, $senha) {
        $admin = new Administrador($auser, $senha);
        $this->dao->criarAdministrador($admin);
    }

    public function excluir($id) {
        $this->dao->excluirAdministrador($id);
    }

    public function atualizar($id, $auser, $senha) {
        $this->dao->atualizarAdministrador($id, $auser, $senha);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
