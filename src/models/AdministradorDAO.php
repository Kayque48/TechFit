<?php

require_once 'Administrador.php';
require_once __DIR__ . '/../../config/Connection.php';

class AdministradorDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance()->getConnection();
    }

    // CREATE
    public function criarAdministrador(Administrador $admin) {
        $stmt = $this->conn->prepare("
            INSERT INTO ADMINISTRACAO (AUSER, SENHA)
            VALUES (:user, :senha)
        ");
        $stmt->execute([
            ':user' => $admin->getUser(),
            ':senha' => password_hash($admin->getSenha(), PASSWORD_DEFAULT)
        ]);
    }

    // READ ALL
    public function lerAdministradores() {
        $stmt = $this->conn->query("SELECT * FROM ADMINISTRACAO ORDER BY AUSER");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Administrador(
                $row['AUSER'],
                '', // Não retornar senha
                $row['ID_ADMINISTRADOR']
            );
        }
        return $result;
    }

    // READ BY USUARIO
    public function buscarPorUsuario($usuario) {
        $stmt = $this->conn->prepare("
            SELECT * FROM ADMINISTRACAO WHERE AUSER = :usuario LIMIT 1
        ");
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function atualizarAdministrador($id, $user, $senha = null) {
        if ($senha) {
            $stmt = $this->conn->prepare("
                UPDATE ADMINISTRACAO
                SET AUSER = :user, SENHA = :senha
                WHERE ID_ADMINISTRADOR = :id
            ");
            $stmt->execute([
                ':user' => $user,
                ':senha' => password_hash($senha, PASSWORD_DEFAULT),
                ':id' => $id
            ]);
        } else {
            $stmt = $this->conn->prepare("
                UPDATE ADMINISTRACAO
                SET AUSER = :user
                WHERE ID_ADMINISTRADOR = :id
            ");
            $stmt->execute([
                ':user' => $user,
                ':id' => $id
            ]);
        }
    }

    // DELETE
    public function excluirAdministrador($id) {
        $stmt = $this->conn->prepare("DELETE FROM ADMINISTRACAO WHERE ID_ADMINISTRADOR = :id");
        $stmt->execute([':id' => $id]);
    }
}
?>
