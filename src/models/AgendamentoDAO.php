<?php

require_once 'Agendamento.php';
require_once __DIR__ . '/../../config/Connection.php';

class AgendamentoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    // CREATE
    public function criarAgendamento(Agendamento $agendamento)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO AGENDAMENTOS (FK_ALUNO, FK_AULA)
            VALUES (:alunoId, :aulaId)
        ");
        $stmt->execute([
            ':alunoId' => $agendamento->getAlunoId(),
            ':aulaId' => $agendamento->getAulaId(),
        ]);
    }

    // READ ALL
    public function lerAgendamentos()
    {
        $stmt = $this->conn->query("SELECT * FROM AGENDAMENTOS ORDER BY ID_AGENDAMENTO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Agendamento(
                $row['FK_ALUNO'],
                $row['FK_AULA'],
                $row['ID_AGENDAMENTO']
            );
        }
        return $result;
    }

    // DELETE
    public function excluirAgendamento($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM AGENDAMENTOS WHERE ID_AGENDAMENTO = :id");
        $stmt->execute([':id' => $id]);
    }
}