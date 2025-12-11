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

    public function criar($user, $senha) {
        $admin = new Administrador($user, $senha);
        $this->dao->criarAdministrador($admin);
    }

    public function excluir($id) {
        $this->dao->excluirAdministrador($id);
    }

    public function atualizar($id, $userNova, $senhaNova) {
        $this->dao->atualizarAdministrador($id, $userNova, $senhaNova);
    }

    public function buscarPorUsuario($user) {
        return $this->dao->buscarPorUsuario($user);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
