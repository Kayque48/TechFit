<?php

require_once 'Aluno.php';
require_once __DIR__ . '\..\..\config\Connection.php';


class AlunoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }
    
    // helper: garante colunas ID e senha
    private function ensureColumnExists($column, $definitionSql = 'VARCHAR(255) DEFAULT NULL') {
        try {
            // Try generic IF NOT EXISTS (MySQL 8+/MariaDB)
            $this->conn->query("ALTER TABLE Alunos ADD COLUMN IF NOT EXISTS $column $definitionSql");
            return;
        } catch (PDOException $e) {
            // Fallbacks per driver
            $driver = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
            $has = false;

            if ($driver === 'sqlite') {
                $stmt = $this->conn->query("PRAGMA table_info(Alunos)");
                $cols = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($cols as $col) {
                    if (isset($col['name']) && strtolower($col['name']) === strtolower($column)) { $has = true; break; }
                }
            } elseif ($driver === 'mysql') {
                $stmt = $this->conn->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'Alunos' AND COLUMN_NAME = :col");
                $stmt->execute([':col' => $column]);
                $has = (bool) $stmt->fetchColumn();
            } else {
                // generic try
                try {
                    $this->conn->query("ALTER TABLE Alunos ADD COLUMN $column $definitionSql");
                    $has = true;
                } catch (PDOException $ignore) {
                    $has = false;
                }
            }

            if (!$has) {
                // Try driver-specific add for ID to allow autoincrement where possible
                try {
                    if (strtolower($column) === 'id') {
                        if ($driver === 'sqlite') {
                            // SQLite requires INTEGER PRIMARY KEY for autoincrement behaviour on rowid
                            $this->conn->query("ALTER TABLE Alunos ADD COLUMN ID INTEGER");
                            // Note: converting existing table to add PK in SQLite is non-trivial; leave as column.
                        } elseif ($driver === 'mysql') {
                            // Try add auto_increment primary key
                            $this->conn->query("ALTER TABLE Alunos ADD COLUMN ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
                        } else {
                            $this->conn->query("ALTER TABLE Alunos ADD COLUMN ID INT DEFAULT NULL");
                        }
                    } else {
                        $this->conn->query("ALTER TABLE Alunos ADD COLUMN $column $definitionSql");
                    }
                } catch (PDOException $ignore) {
                    // ignore failures
                }
            }
        }
    }

    // CREATE
    public function criarAluno(Aluno $Aluno) {

        // Ensure columns exist
        $this->ensureColumnExists('ID_ALUNO');
        $this->ensureColumnExists('SENHA', 'VARCHAR(255) DEFAULT NULL');

        $stmt = $this->conn->prepare("
            INSERT INTO Alunos (NOME_ALUNO, IDADE, ENDERECO_ALUNO, TELEFONE, EMAIL, FK_PLANO, senha)
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

        // Retornar ID inserido (se disponível)
        try {
            $lastId = $this->conn->lastInsertId();
            return $lastId !== '0' ? $lastId : null;
        } catch (Exception $e) {
            return null;
        }
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
                $row['FK_PLANO'] ?? $row['plano'] ?? null,
                $row['SENHA'] ?? null,
                $row['ID_ALUNO'] ?? null,
            );
        }
        return $result;
    }

    // UPDATE by nome (mantido por compatibilidade)
    public function atualizarAluno($nomeOriginal, $novoNome, $dataNasc, $endereco, $telefone, $email, $plano) {
        $stmt = $this->conn->prepare("
            UPDATE Alunos
            SET NOME_ALUNO = :novoNome, IDADE = :dataNasc, ENDERECO_ALUNO = :endereco, TELEFONE = :telefone, EMAIL = :email, fk_plano = :plano
            WHERE NOME_ALUNO = :nomeOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':dataNasc' => $dataNasc,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email,
            ':plano' => $plano,
            ':nomeOriginal' => $nomeOriginal
        ]);
    }

    // UPDATE by ID (recomendado)
    public function atualizarAlunoPorId($id, $novoNome, $dataNasc, $endereco, $telefone, $email, $plano) {
        $stmt = $this->conn->prepare("
            UPDATE Alunos
            SET NOME_ALUNO = :novoNome, IDADE = :dataNasc, ENDERECO_ALUNO = :endereco, TELEFONE = :telefone, EMAIL = :email, FK_PLANO = :plano
            WHERE ID = :id
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':dataNasc' => $dataNasc,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email,
            ':plano' => $plano,
            ':id' => $id
        ]);
    }

    // DELETE by nome (mantido)
    public function excluirAluno($nome) {
        $stmt = $this->conn->prepare("DELETE FROM Alunos WHERE NOME_ALUNO = :nome");
        $stmt->execute([':nome' => $nome]);
    }

    // DELETE by ID (recomendado)
    public function excluirAlunoPorId($id) {
        $stmt = $this->conn->prepare("DELETE FROM Alunos WHERE ID = :id");
        $stmt->execute([':id' => $id]);
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
                $row['FK_PLANO'] ?? null,
                $row['SENHA'] ?? null,
                $row['ID_ALUNO'] ?? null
            );
        }
        return null;
    }

    // BUSCAR POR EMAIL
    public function buscarPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM Alunos WHERE EMAIL = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return [
                'ID_ALUNO' => $row['ID_ALUNO'],
                'NOME_ALUNO' => $row['NOME_ALUNO'],
                'IDADE' => $row['IDADE'],
                'ENDERECO_ALUNO' => $row['ENDERECO_ALUNO'],
                'TELEFONE' => $row['TELEFONE'],
                'EMAIL' => $row['EMAIL'],
                'FK_PLANO' => $row['FK_PLANO'] ?? null,
                'SENHA' => $row['SENHA'] ?? null
            ];
        }
        return null;
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

    // ATUALIZAR PLANO
    public function atualizarPlano($email, $plano) {
        $stmt = $this->conn->prepare("UPDATE Alunos SET fk_plano = :plano WHERE EMAIL = :email");
        $stmt->execute([
            ':plano' => $plano,
            ':email' => $email
        ]);
    }
}