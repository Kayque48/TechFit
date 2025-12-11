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

    public function criar($user, $emailAdm, $senha) {
        $admin = new Administrador($user, $emailAdm, $senha);
        $this->dao->criarAdministrador($admin);
    }

    public function excluir($id) {
        $this->dao->excluirAdministrador($id);
    }

    public function atualizar($id, $user, $emailAdm, $senha) {
        $this->dao->atualizarAdministrador($id, $user, $emailAdm, $senha);
    }

    public function buscarPorEmail($email) {
        return $this->dao->buscarPorEmail($email);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
