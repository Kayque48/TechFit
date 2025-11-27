<?php

require_once 'Plano.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class PlanoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }

    // CREATE
    public function criarPlano(Plano $plano) {
        $stmt = $this->conn->prepare("
            INSERT INTO PLANOS (TIPO_PLANO, DURACAO_MES, PRECO)
            VALUES (:tipo, :duracao, :preco)
        ");
        $stmt->execute([
            ':tipo' => $plano->getTipoPlano(),
            ':duracao' => $plano->getDuracaoMes(),
            ':preco' => $plano->getPreco()
        ]);
    }

    // READ ALL
    public function lerPlanos() {
        $stmt = $this->conn->query("SELECT * FROM PLANOS ORDER BY TIPO_PLANO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Plano(
                $row['TIPO_PLANO'],
                $row['DURACAO_MES'],
                $row['PRECO'],
                $row['ID_PLANO']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM PLANOS WHERE ID_PLANO = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Plano(
                $row['TIPO_PLANO'],
                $row['DURACAO_MES'],
                $row['PRECO'],
                $row['ID_PLANO']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarPlano($id, $tipoPlano, $duracaoMes, $preco) {
        $stmt = $this->conn->prepare("
            UPDATE PLANOS
            SET TIPO_PLANO = :tipo, DURACAO_MES = :duracao, PRECO = :preco
            WHERE ID_PLANO = :id
        ");
        $stmt->execute([
            ':tipo' => $tipoPlano,
            ':duracao' => $duracaoMes,
            ':preco' => $preco,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirPlano($id) {
        $stmt = $this->conn->prepare("DELETE FROM PLANOS WHERE ID_PLANO = :id");
        $stmt->execute([':id' => $id]);
    }
}
