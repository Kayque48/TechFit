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
            INSERT INTO ADMINISTRACAO (AUSER, SENHA)
            VALUES (:auser, :senha)
        ");
        $stmt->execute([
            ':auser' => $admin->getAuser(),
            ':senha' => $admin->getSenha()
        ]);
    }

    // READ ALL
    public function lerAdministradores() {
        $stmt = $this->conn->query("SELECT * FROM ADMINISTRACAO ORDER BY AUSER");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Administrador(
                $row['AUSER'],
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
                $row['AUSER'],
                $row['SENHA'],
                $row['ID_ADMINISTRADOR']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarAdministrador($id, $auser, $senha) {
        $stmt = $this->conn->prepare("
            UPDATE ADMINISTRACAO
            SET AUSER = :auser, SENHA = :senha
            WHERE ID_ADMINISTRADOR = :id
        ");
        $stmt->execute([
            ':auser' => $auser,
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
