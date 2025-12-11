<?php

require_once 'Treino.php';
require_once __DIR__ . '/../../config/Connection.php';

class TreinoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
        $this->criarTabelaTreinos();
    }

    // Criar tabela se não existir
    private function criarTabelaTreinos() {
        $sql = "CREATE TABLE IF NOT EXISTS TREINOS (
            ID_TREINO INT AUTO_INCREMENT PRIMARY KEY,
            NOME_TREINO VARCHAR(100) NOT NULL,
            DIA_SEMANA VARCHAR(20) NOT NULL,
            HORARIO_INICIO TIME NOT NULL,
            HORARIO_FIM TIME NOT NULL,
            INSTRUTOR VARCHAR(80) NOT NULL,
            DESCRICAO TEXT,
            CALORIAS INT DEFAULT 0,
            FK_ALUNO INT,
            DATA_REALIZACAO DATE NOT NULL,
            FOREIGN KEY (FK_ALUNO) REFERENCES ALUNOS(ID_ALUNO) ON DELETE CASCADE
        )";
        $this->conn->exec($sql);
    }

    // CREATE
    public function criarTreino(Treino $treino) {
        $stmt = $this->conn->prepare("
            INSERT INTO TREINOS (
                NOME_TREINO, DIA_SEMANA, HORARIO_INICIO, HORARIO_FIM, 
                INSTRUTOR, DESCRICAO, CALORIAS, FK_ALUNO, DATA_REALIZACAO
            )
            VALUES (:nome, :dia, :inicio, :fim, :instrutor, :descricao, :calorias, :aluno, :data)
        ");
        $stmt->execute([
            ':nome' => $treino->getNome(),
            ':dia' => $treino->getDiaSemana(),
            ':inicio' => $treino->getHorarioInicio(),
            ':fim' => $treino->getHorarioFim(),
            ':instrutor' => $treino->getInstrutor(),
            ':descricao' => $treino->getDescricao(),
            ':calorias' => $treino->getCalorias(),
            ':aluno' => $treino->getIdAluno(),
            ':data' => $treino->getDataRealizacao()
        ]);
    }

    // READ - Todos os treinos
    public function lerTreinos() {
        $stmt = $this->conn->query("SELECT * FROM TREINOS ORDER BY DATA_REALIZACAO DESC");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Treino(
                $row['ID_TREINO'],
                $row['NOME_TREINO'],
                $row['DIA_SEMANA'],
                $row['HORARIO_INICIO'],
                $row['HORARIO_FIM'],
                $row['INSTRUTOR'],
                $row['DESCRICAO'],
                $row['CALORIAS'],
                $row['FK_ALUNO'],
                $row['DATA_REALIZACAO']
            );
        }
        return $result;
    }

    // READ - Treinos por aluno
    public function buscarPorIdAluno($idAluno) {
        $stmt = $this->conn->prepare("
            SELECT * FROM TREINOS 
            WHERE FK_ALUNO = :aluno 
            ORDER BY DATA_REALIZACAO DESC
        ");
        $stmt->execute([':aluno' => $idAluno]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Treino(
                $row['ID_TREINO'],
                $row['NOME_TREINO'],
                $row['DIA_SEMANA'],
                $row['HORARIO_INICIO'],
                $row['HORARIO_FIM'],
                $row['INSTRUTOR'],
                $row['DESCRICAO'],
                $row['CALORIAS'],
                $row['FK_ALUNO'],
                $row['DATA_REALIZACAO']
            );
        }
        return $result;
    }

    // READ - Buscar treino por ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM TREINOS WHERE ID_TREINO = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Treino(
                $row['ID_TREINO'],
                $row['NOME_TREINO'],
                $row['DIA_SEMANA'],
                $row['HORARIO_INICIO'],
                $row['HORARIO_FIM'],
                $row['INSTRUTOR'],
                $row['DESCRICAO'],
                $row['CALORIAS'],
                $row['FK_ALUNO'],
                $row['DATA_REALIZACAO']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarTreino($id, $nome, $diaSemana, $horarioInicio, $horarioFim, $instrutor, $descricao, $calorias) {
        $stmt = $this->conn->prepare("
            UPDATE TREINOS 
            SET NOME_TREINO = :nome,
                DIA_SEMANA = :dia,
                HORARIO_INICIO = :inicio,
                HORARIO_FIM = :fim,
                INSTRUTOR = :instrutor,
                DESCRICAO = :descricao,
                CALORIAS = :calorias
            WHERE ID_TREINO = :id
        ");
        $stmt->execute([
            ':nome' => $nome,
            ':dia' => $diaSemana,
            ':inicio' => $horarioInicio,
            ':fim' => $horarioFim,
            ':instrutor' => $instrutor,
            ':descricao' => $descricao,
            ':calorias' => $calorias,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirTreino($id) {
        $stmt = $this->conn->prepare("DELETE FROM TREINOS WHERE ID_TREINO = :id");
        $stmt->execute([':id' => $id]);
    }

    // Estatísticas
    public function obterEstatisticas($idAluno) {
        $stmt = $this->conn->prepare("
            SELECT 
                COUNT(*) as total_treinos,
                SUM(CALORIAS) as total_calorias,
                SUM(TIMESTAMPDIFF(MINUTE, HORARIO_INICIO, HORARIO_FIM)) as total_minutos
            FROM TREINOS 
            WHERE FK_ALUNO = :aluno
        ");
        $stmt->execute([':aluno' => $idAluno]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}