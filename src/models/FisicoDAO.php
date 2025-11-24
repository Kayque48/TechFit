<?php

require_once 'Fisico.php';
require_once __DIR__ . '\..\..\config\Connection.php';


class FisicoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }
    

    // CREATE
    public function criarAvaliacao(Fisico $fisico) {
        $stmt = $this->conn->prepare("
            INSERT INTO AVALIACOES_FISICAS (data, peso, altura, peitoral, cintura, quadril, braEsquerdo, braDireito, coxa, gordura, masMagra, tmb, imc)
            VALUES (:data, :peso, :altura, :peitoral, :cintura, :quadril, :braEsquerdo, :braDireito, :coxa, :gordura, :masMagra, :tmb, :imc)
        ");
        $stmt->execute([
            ':data' => $fisico->getData(),
            ':peso' => $fisico->getPeso(),
            ':altura' => $fisico->getAltura(),
            ':peitoral' => $fisico->getPeitoral(),
            ':cintura' => $fisico->getCintura(),
            ':quadril' => $fisico->getQuadril(),
            ':braEsquerdo' => $fisico->getBraEsquerdo(),
            ':braDireito' => $fisico->getBraDireito(),
            ':coxa' => $fisico->getCoxa(),
            ':gordura' => $fisico->getGordura(),
            ':masMagra' => $fisico->getMasMagra(),
            ':tmb' => $fisico->getTmb(),
            ':imc' => $fisico->getImc(),
        ]);
    }

    // READ
    public function lerAvaliacoes() {
        $stmt = $this->conn->query("SELECT * FROM AVALIACOES_FISICAS ORDER BY data");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Fisico(
                $row['data'],
                $row['peso'],
                $row['altura'],
                $row['peitoral'],
                $row['cintura'],
                $row['quadril'],
                $row['braEsquerdo'],
                $row['braDireito'],
                $row['coxa'],
                $row['gordura'],
                $row['masMagra'],
                $row['tmb'],
                $row['imc']
            );
        }
        return $result;
    }

    // DELETE
    public function excluirAvaliacao($data) {
        $stmt = $this->conn->prepare("DELETE FROM AVALIACOES_FISICAS WHERE data = :data");
        $stmt->execute([':data' => $data]);
    }

    // BUSCAR POR NOME
    public function buscarPorNome($data) {
        $stmt = $this->conn->prepare("SELECT * FROM avaliacoes_fisicas WHERE data_avaliacao = :data LIMIT 1");
        $stmt->execute([':data' => $data]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Fisico(
                $row['data'],
                $row['peso'],
                $row['altura'],
                $row['peitoral'],
                $row['cintura'],
                $row['quadril'],
                $row['braEsquerdo'],
                $row['braDireito'],
                $row['coxa'],
                $row['gordura'],
                $row['masMagra'],
                $row['tmb'],
                $row['imc']
            );
        }
        return null;
    }
}