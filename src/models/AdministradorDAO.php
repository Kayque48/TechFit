<?php

require_once 'Administrador.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class AdministradorDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }

    // CREATE
    public function criarAdministrador(Administrador $admin) {
        $stmt = $this->conn->prepare("
            INSERT INTO ADMINISTRACAO (USER, EMAIL_ADM, SENHA)
            VALUES (:user, :emailAdm, :senha)
        ");
        $stmt->execute([
            ':user' => $admin->getUser(),
            ':emailAdm' => $admin->getEmailAdm(),
            ':senha' => $admin->getSenha()
        ]);
    }

    // READ ALL
    public function lerAdministradores() {
        $stmt = $this->conn->query("SELECT * FROM ADMINISTRACAO ORDER BY USER");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Administrador(
                $row['USER'],
                $row['EMAIL_ADM'],
                $row['SENHA'],
                $row['ID_ADMINISTRADOR']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM ADMINISTRACAO WHERE ID_ADMINISTRADOR = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Administrador(
                $row['USER'],
                $row['EMAIL_ADM'],
                $row['SENHA'],
                $row['ID_ADMINISTRADOR']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarAdministrador($id, $user, $emailAdm, $senha) {
        $stmt = $this->conn->prepare("
            UPDATE ADMINISTRACAO
            SET USER = :user, EMAIL_ADM = :emailAdm, SENHA = :senha
            WHERE ID_ADMINISTRADOR = :id
        ");
        $stmt->execute([
            ':user' => $user,
            ':emailAdm' => $emailAdm,
            ':senha' => $senha,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirAdministrador($id) {
        $stmt = $this->conn->prepare("DELETE FROM ADMINISTRACAO WHERE ID_ADMINISTRADOR = :id");
        $stmt->execute([':id' => $id]);
    }
}
