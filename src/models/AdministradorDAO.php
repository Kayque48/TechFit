<?php

use Dba\Connection;

require_once 'Administrador.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class AdministradorDAO
{
    private $conn;


    // CREATE
    public function criarAdministrador(Administrador $admin)
    {


        $stmt = $this->conn->prepare("
            INSERT INTO ADMINISTRACAO (USER, SENHA)
            VALUES (:user, :senha)
        ");
        $stmt->execute([
            ':user' => $admin->getUser(),
            ':senha' => $admin->getSenha()
        ]);
    }

    // READ ALL
    public function lerAdministradores()
    {
        $stmt = $this->conn->query("SELECT * FROM ADMINISTRACAO ORDER BY USER");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Administrador(
                $row['USER'],
                $row['SENHA'],
                $row['ID_ADMINISTRADOR']
            );
        }
        return $result;
    }

    // READ BY USER
    public function buscarPorUsuario($user)
    {
        $stmt = $this->conn->prepare("SELECT * FROM ADMINISTRACAO WHERE USER = :user LIMIT 1");
        $stmt->execute([':user' => $user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Administrador(
                $row['USER'],
                $row['SENHA'],
                $row['ID_ADMINISTRADOR']
            );
        }
        return null;
    }

    // UPDATE (com hash)
    public function atualizarAdministrador($id, $userNova, $senhaNova)
    {


        $stmt = $this->conn->prepare("
            UPDATE ADMINISTRACAO
            SET USER = :user, SENHA = :senha
            WHERE ID_ADMINISTRADOR = :id
        ");
        $stmt->execute([
            ':user' => $userNova,
            ':senha' => $senhaNova,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirAdministrador($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM ADMINISTRACAO WHERE ID_ADMINISTRADOR = :id");
        $stmt->execute([':id' => $id]);
    }
}
