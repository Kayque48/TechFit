<?php

require_once 'Aula.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class AulaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }

    // CREATE
    public function criarAula(Aula $aula) {
        $stmt = $this->conn->prepare("
            INSERT INTO AULAS (NOME_AULA, AVALIACAO)
            VALUES (:nome, :avaliacao)
        ");
        $stmt->execute([
            ':nome' => $aula->getNomeAula(),
            ':avaliacao' => $aula->getAvaliacao()
        ]);
    }

    // READ ALL
    public function lerAulas() {
        $stmt = $this->conn->query("SELECT * FROM AULAS ORDER BY NOME_AULA");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aula(
                $row['NOME_AULA'],
                $row['AVALIACAO'],
                $row['ID_AULA']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM AULAS WHERE ID_AULA = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Aula(
                $row['NOME_AULA'],
                $row['AVALIACAO'],
                $row['ID_AULA']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarAula($id, $nomeAula, $avaliacao) {
        $stmt = $this->conn->prepare("
            UPDATE AULAS
            SET NOME_AULA = :nome, AVALIACAO = :avaliacao
            WHERE ID_AULA = :id
        ");
        $stmt->execute([
            ':nome' => $nomeAula,
            ':avaliacao' => $avaliacao,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirAula($id) {
        $stmt = $this->conn->prepare("DELETE FROM AULAS WHERE ID_AULA = :id");
        $stmt->execute([':id' => $id]);
    }
}
