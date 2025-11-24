<?php

require_once 'Aluno.php';
require_once __DIR__ . '\..\..\config\Connection.php';


class AlunoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }
    

    // CREATE
    public function criarAluno(Aluno $Aluno) {
        $stmt = $this->conn->prepare("
            INSERT INTO Alunos (nome_aluno, idade, endereco_aluno, telefone, email, avalicao_fisica)
            VALUES (:nome, :idade, :endereco, :telefone, :email, :avaliacao)
        ");
        $stmt->execute([
            ':nome' => $Aluno->getNome(),
            ':idade' => $Aluno->getIdade(),
            ':endereco' => $Aluno->getEndereco(),
            ':telefone' => $Aluno->getTelefone(),
            ':email' => $Aluno->getEmail(),
            ':avaliacao' => $Aluno->getAvaliacao()
        ]);
    }

    // READ
    public function lerAlunos() {
        $stmt = $this->conn->query("SELECT * FROM Alunos ORDER BY nome_aluno");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aluno(
                $row['nome_aluno'],
                $row['idade'],
                $row['endereco_aluno'],
                $row['telefone'],
                $row['email'],
                $row['avaliacao_fisica']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarAluno($nomeOriginal, $novoNome, $idade, $endereco, $telefone, $email, $avaliacao) {
        $stmt = $this->conn->prepare("
            UPDATE Alunos
            SET nome_aluno = :novoNome, idade = :idade, endereco_aluno = :endereco, telefone = :telefone, email = :email, avaliacao_fisica = :avaliacao
            WHERE nome_aluno = :nomeOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':idade' => $idade,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email,
            ':avaliacao' => $avaliacao,
            ':nomeOriginal' => $nomeOriginal
        ]);
    }

    // DELETE
    public function excluirAluno($nome) {
        $stmt = $this->conn->prepare("DELETE FROM Alunos WHERE nome_aluno = :nome");
        $stmt->execute([':nome' => $nome]);
    }

    // BUSCAR POR NOME
    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM Alunos WHERE nome_aluno = :nome LIMIT 1");
        $stmt->execute([':nome' => $nome]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Aluno(
                $row['nome_aluno'],
                $row['idade'],
                $row['endereco_aluno'],
                $row['telefone'],
                $row['email'],
                $row['avaliacao_fisica']
            );
        }
        return null;
    }
}