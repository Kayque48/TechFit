<?php

require_once 'Filial.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class FilialDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }

    // CREATE
    public function criarFilial(Filial $filial) {
        $stmt = $this->conn->prepare("
            INSERT INTO FILIAS (ENDERECO, CEP, CARGA_MAX, NUM_COLABORADORES)
            VALUES (:endereco, :cep, :cargaMax, :numCol)
        ");
        $stmt->execute([
            ':endereco' => $filial->getEndereco(),
            ':cep' => $filial->getCep(),
            ':cargaMax' => $filial->getCargaMax(),
            ':numCol' => $filial->getNumColaboradores()
        ]);
    }

    // READ ALL
    public function lerFiliais() {
        $stmt = $this->conn->query("SELECT * FROM FILIAS ORDER BY ENDERECO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Filial(
                $row['ENDERECO'],
                $row['CEP'],
                $row['CARGA_MAX'],
                $row['NUM_COLABORADORES'],
                $row['ID_FILIAL']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM FILIAS WHERE ID_FILIAL = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Filial(
                $row['ENDERECO'],
                $row['CEP'],
                $row['CARGA_MAX'],
                $row['NUM_COLABORADORES'],
                $row['ID_FILIAL']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarFilial($id, $endereco, $cep, $cargaMax, $numColaboradores) {
        $stmt = $this->conn->prepare("
            UPDATE FILIAS
            SET ENDERECO = :endereco, CEP = :cep, CARGA_MAX = :cargaMax, NUM_COLABORADORES = :numCol
            WHERE ID_FILIAL = :id
        ");
        $stmt->execute([
            ':endereco' => $endereco,
            ':cep' => $cep,
            ':cargaMax' => $cargaMax,
            ':numCol' => $numColaboradores,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirFilial($id) {
        $stmt = $this->conn->prepare("DELETE FROM FILIAS WHERE ID_FILIAL = :id");
        $stmt->execute([':id' => $id]);
    }
}
