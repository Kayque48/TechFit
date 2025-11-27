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

        try {
            // Try direct ALTER with IF NOT EXISTS (MySQL 8.0+, MariaDB 10.0.2+, etc.)
            $this->conn->query("ALTER TABLE Alunos ADD COLUMN IF NOT EXISTS senha VARCHAR(255) DEFAULT NULL");
        } catch (PDOException $e) {
            // Fallback for drivers that don't support IF NOT EXISTS
            $driver = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
            $hasSenha = false;

            if ($driver === 'sqlite') {
                $stmt = $this->conn->query("PRAGMA table_info(Alunos)");
                $cols = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($cols as $col) {
                    if (isset($col['name']) && strtolower($col['name']) === 'senha') { $hasSenha = true; break; }
                }
            } elseif ($driver === 'mysql') {
                $stmt = $this->conn->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'Alunos' AND COLUMN_NAME = 'senha'");
                $stmt->execute();
                $hasSenha = (bool) $stmt->fetchColumn();
            } else {
                // Generic attempt: try to add and ignore error if it already exists
                try {
                    $this->conn->query("ALTER TABLE Alunos ADD COLUMN senha VARCHAR(255) DEFAULT NULL");
                    $hasSenha = true;
                } catch (PDOException $ignore) {
                    $hasSenha = false;
                }
            }

            if (!$hasSenha) {
                $this->conn->query("ALTER TABLE Alunos ADD COLUMN senha VARCHAR(255) DEFAULT NULL");
            }
        }

        $stmt = $this->conn->prepare("
            INSERT INTO Alunos (NOME_ALUNO, IDADE, ENDERECO_ALUNO, TELEFONE, EMAIL, FK_AVALIACAO_FISICA, plano, senha)
            VALUES (:nome, :idade, :endereco, :telefone, :email, :avaliacao, :plano, :senha)
        ");
        $stmt->execute([
            ':nome' => $Aluno->getNome(),
            ':idade' => $Aluno->getIdade(),
            ':endereco' => $Aluno->getEndereco(),
            ':telefone' => $Aluno->getTelefone(),
            ':email' => $Aluno->getEmail(),
            ':avaliacao' => $Aluno->getAvaliacao(),
            ':plano' => $Aluno->getPlano(),
            ':senha' => $Aluno->getSenha(),
        ]);
    }

    // READ
    public function lerAlunos() {
        $stmt = $this->conn->query("SELECT * FROM Alunos ORDER BY NOME_ALUNO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aluno(
                $row['NOME_ALUNO'],
                $row['IDADE'],
                $row['ENDERECO_ALUNO'],
                $row['TELEFONE'],
                $row['EMAIL'],
                $row['FK_AVALIACAO_FISICA'],
                $row['plano'],
                $row['senha'] ?? null
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarAluno($nomeOriginal, $novoNome, $idade, $endereco, $telefone, $email, $avaliacao, $plano) {
        $stmt = $this->conn->prepare("
            UPDATE Alunos
            SET NOME_ALUNO = :novoNome, IDADE = :idade, ENDERECO_ALUNO = :endereco, TELEFONE = :telefone, EMAIL = :email, FK_AVALIACAO_FISICA = :avaliacao, plano = :plano
            WHERE NOME_ALUNO = :nomeOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':idade' => $idade,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email,
            ':avaliacao' => $avaliacao,
            ':plano' => $plano,
            ':nomeOriginal' => $nomeOriginal
        ]);
    }

    // DELETE
    public function excluirAluno($nome) {
        $stmt = $this->conn->prepare("DELETE FROM Alunos WHERE NOME_ALUNO = :nome");
        $stmt->execute([':nome' => $nome]);
    }

    // BUSCAR POR NOME
    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM Alunos WHERE NOME_ALUNO = :nome LIMIT 1");
        $stmt->execute([':nome' => $nome]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Aluno(
                $row['NOME_ALUNO'],
                $row['IDADE'],
                $row['ENDERECO_ALUNO'],
                $row['TELEFONE'],
                $row['EMAIL'],
                $row['FK_AVALIACAO_FISICA'],
                $row['plano']
            );
        }
        return null;
    }

    // BUSCAR POR EMAIL
    public function buscarPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM Alunos WHERE EMAIL = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // VERIFICAR SE EMAIL EXISTE
    public function emailExiste($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Alunos WHERE EMAIL = :email");
        $stmt->execute([':email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // VERIFICAR SE TELEFONE EXISTE
    public function telefoneExiste($telefone) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Alunos WHERE TELEFONE = :telefone");
        $stmt->execute([':telefone' => $telefone]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // ATUALIZAR SENHA
    public function atualizarSenha($email, $senhaHash) {
        $stmt = $this->conn->prepare("UPDATE Alunos SET senha = :senha WHERE EMAIL = :email");
        $stmt->execute([
            ':senha' => $senhaHash,
            ':email' => $email
        ]);
    }
}