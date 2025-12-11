<?php

require_once 'Professor.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class ProfessorDAO {
    private $conn;

     public function __construct() {
        $this->conn = Connection::getInstance()->getConnection();
    }

    // CREATE
    public function criarProfessor(Professor $professor) {
        $stmt = $this->conn->prepare("
            INSERT INTO PROFESSORES (NOME_PROFESSOR, CPF, ESPECIALIDADE)
            VALUES (:nome, :cpf, :especialidade)
        ");
        $stmt->execute([
            ':nome' => $professor->getNomeProfessor(),
            ':cpf' => $professor->getCpf(),
            ':especialidade' => $professor->getEspecialidade()
        ]);
    }

    // READ ALL
    public function lerProfessores() {
        $stmt = $this->conn->query("SELECT * FROM PROFESSORES ORDER BY NOME_PROFESSOR");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Professor(
                $row['NOME_PROFESSOR'],
                $row['CPF'],
                $row['ESPECIALIDADE'],
                $row['ID_PROFESSOR']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM PROFESSORES WHERE ID_PROFESSOR = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Professor(
                $row['NOME_PROFESSOR'],
                $row['CPF'],
                $row['ESPECIALIDADE'],
                $row['ID_PROFESSOR']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarProfessor($id, $nomeProfessor, $cpf, $especialidade) {
        $stmt = $this->conn->prepare("
            UPDATE PROFESSORES
            SET NOME_PROFESSOR = :nome, CPF = :cpf, ESPECIALIDADE = :especialidade
            WHERE ID_PROFESSOR = :id
        ");
        $stmt->execute([
            ':nome' => $nomeProfessor,
            ':cpf' => $cpf,
            ':especialidade' => $especialidade,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirProfessor($id) {
        $stmt = $this->conn->prepare("DELETE FROM PROFESSORES WHERE ID_PROFESSOR = :id");
        $stmt->execute([':id' => $id]);
    }
}
