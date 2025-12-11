<?php

require_once 'Aluno.php';
require_once __DIR__ . '/../../config/Connection.php';
echo "Connection carregado: " . __DIR__ . '/../../config/Connection.php';

class AlunoDAO {
    private $conn;

    public function __construct() {
        Connection::getInstance()->teste();
        $this->conn = Connection::getInstance()->getConnection();
    }

    

    // CREATE
   public function criarAluno(Aluno $Aluno) {
    try {
        $stmt = $this->conn->prepare("
            INSERT INTO ALUNOS (NOME_ALUNO, IDADE, ENDERECO_ALUNO, TELEFONE, EMAIL, FK_PLANO, SENHA)
            VALUES (:nome, :dataNasc, :endereco, :telefone, :email, :plano, :senha)
        ");
        $stmt->execute([
            ':nome' => $Aluno->getNome(),
            ':dataNasc' => $Aluno->getDataNasc(),
            ':endereco' => $Aluno->getEndereco(),
            ':telefone' => $Aluno->getTelefone(),
            ':email' => $Aluno->getEmail(),
            ':plano' => $Aluno->getPlano(),
            ':senha' => $Aluno->getSenha(),
        ]);

        return $this->conn->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Erro ao criar aluno: " . $e->getMessage());
    }
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
