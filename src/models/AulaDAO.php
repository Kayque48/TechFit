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
            INSERT INTO AULAS (NOME_AULA, TIPO_AULA, TEMPO_AULA, DATA_AULA, FK_PROFESSOR)
            VALUES (:nome, :tipo, :tempo, :data, :professor)
        ");
        $stmt->execute([
            ':nome' => $aula->getNomeAula(),
            ':tipo' => $aula->getTipo(),
            ':tempo' => $aula->getTempo(),
            ':data' => $aula->getData(),
            ':professor' => $aula->getProfessor()
        ]);
    }

    // READ ALL
    public function lerAulas() {
        $stmt = $this->conn->query("SELECT * FROM AULAS ORDER BY NOME_AULA");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aula(
                $row['NOME_AULA'],
                $row['TIPO_AULA'],
                $row['TEMPO_AULA'],
                $row['DATA_AULA'],
                $row['FK_PROFESSOR'],
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
                $row['TIPO_AULA'],
                $row['TEMPO_AULA'],
                $row['DATA_AULA'],
                $row['FK_PROFESSOR'],
                $row['ID_AULA']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarAula($id, $nome, $tipo, $tempo, $data, $professor) {
        $stmt = $this->conn->prepare("
            UPDATE AULAS
            SET NOME_AULA = :nome, TIPO_AULA = :tipo, TEMPO_AULA = :tempo, DATA_AULA = :data, FK_PROFESSOR = :professor
            WHERE ID_AULA = :id
        ");
        $stmt->execute([
            ':nome' => $nome,
            ':tipo' => $tipo,
            ':tempo' => $tempo,
            ':data' => $data,
            ':professor' => $professor,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirAula($id) {
        $stmt = $this->conn->prepare("DELETE FROM AULAS WHERE ID_AULA = :id");
        $stmt->execute([':id' => $id]);
    }

    public function contarAulas() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM AULAS");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['total'];
    }

    public function contarAulasPorTipo($tipo) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM AULAS WHERE TIPO_AULA = :tipo");
        $stmt->execute([':tipo' => $tipo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['total'];
    }

    public function tipoComMaisAulas() {
        $stmt = $this->conn->query("
            SELECT TIPO_AULA, COUNT(*) AS total
            FROM AULAS
            GROUP BY TIPO_AULA
            ORDER BY total DESC
            LIMIT 1;
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['TIPO_AULA'] : null;
    }

    public function tipoComMenosAulas() {
        $stmt = $this->conn->query("
            SELECT TIPO_AULA, COUNT(*) AS total
            FROM AULAS
            GROUP BY TIPO_AULA
            ORDER BY total ASC
            LIMIT 1;
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['TIPO_AULA'] : null;
    }

    public function nomeProfessor($professorId)
    {
        $stmt = $this->conn->prepare("SELECT NOME_PROFESSOR FROM PROFESSORES WHERE ID_PROFESSOR = :professorId LIMIT 1");
        $stmt->execute([':professorId' => $professorId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['NOME_PROFESSOR'] : null;
    }
    

}
