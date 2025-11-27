<?php

require_once 'Fisico.php';
require_once __DIR__ . '/../../config/Connection.php';


class FisicoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }
    

    // CREATE
    public function criarAvaliacao(Fisico $fisico) {
        $stmt = $this->conn->prepare("
            INSERT INTO AVALIACOES_FISICAS (DATA_AVALIACAO, PESO, ALTURA, PEITORAL, CINTURA, QUADRIL, BRAÇO_ESQUERDO, BRAÇO_DIREITO, COXA, GORDURA_CORPORAL, MASSA_MEGRA, TMB, IMC, FK_ALUNO)
            VALUES (:data, :peso, :altura, :peitoral, :cintura, :quadril, :braEsquerdo, :braDireito, :coxa, :gordura, :masMagra, :tmb, :imc, :fkAluno)
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
            ':fkAluno' => $fisico->getFkAluno(),
        ]);
    }

    // READ - Todas as avaliações
    public function lerAvaliacoes() {
        $stmt = $this->conn->query("SELECT * FROM AVALIACOES_FISICAS ORDER BY DATA_AVALIACAO DESC");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Fisico(
                $row['DATA_AVALIACAO'],
                $row['PESO'],
                $row['ALTURA'],
                $row['PEITORAL'],
                $row['CINTURA'],
                $row['QUADRIL'],
                $row['BRAÇO_ESQUERDO'],
                $row['BRAÇO_DIREITO'],
                $row['COXA'],
                $row['GORDURA_CORPORAL'],
                $row['MASSA_MEGRA'],
                $row['TMB'],
                $row['IMC'],
                $row['FK_ALUNO'],
                $row['ID_AVALIACAO']
            );
        }
        return $result;
    }

    // READ - Avaliações por ID do aluno
    public function buscarPorIdAluno($idAluno) {
        $stmt = $this->conn->prepare("SELECT * FROM AVALIACOES_FISICAS WHERE FK_ALUNO = :fkAluno ORDER BY DATA_AVALIACAO DESC");
        $stmt->execute([':fkAluno' => $idAluno]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Fisico(
                $row['DATA_AVALIACAO'],
                $row['PESO'],
                $row['ALTURA'],
                $row['PEITORAL'],
                $row['CINTURA'],
                $row['QUADRIL'],
                $row['BRAÇO_ESQUERDO'],
                $row['BRAÇO_DIREITO'],
                $row['COXA'],
                $row['GORDURA_CORPORAL'],
                $row['MASSA_MEGRA'],
                $row['TMB'],
                $row['IMC'],
                $row['FK_ALUNO'],
                $row['ID_AVALIACAO']
            );
        }
        return $result;
    }

    // READ - Buscar uma avaliação por ID
    public function buscarPorId($idAvaliacao) {
        $stmt = $this->conn->prepare("SELECT * FROM AVALIACOES_FISICAS WHERE ID_AVALIACAO = :id LIMIT 1");
        $stmt->execute([':id' => $idAvaliacao]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Fisico(
                $row['DATA_AVALIACAO'],
                $row['PESO'],
                $row['ALTURA'],
                $row['PEITORAL'],
                $row['CINTURA'],
                $row['QUADRIL'],
                $row['BRAÇO_ESQUERDO'],
                $row['BRAÇO_DIREITO'],
                $row['COXA'],
                $row['GORDURA_CORPORAL'],
                $row['MASSA_MEGRA'],
                $row['TMB'],
                $row['IMC'],
                $row['FK_ALUNO'],
                $row['ID_AVALIACAO']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarAvaliacao(Fisico $fisico) {
        $stmt = $this->conn->prepare("
            UPDATE AVALIACOES_FISICAS 
            SET DATA_AVALIACAO = :data, 
                PESO = :peso, 
                ALTURA = :altura, 
                PEITORAL = :peitoral, 
                CINTURA = :cintura, 
                QUADRIL = :quadril, 
                BRAÇO_ESQUERDO = :braEsquerdo, 
                BRAÇO_DIREITO = :braDireito, 
                COXA = :coxa, 
                GORDURA_CORPORAL = :gordura, 
                MASSA_MEGRA = :masMagra, 
                TMB = :tmb, 
                IMC = :imc
            WHERE ID_AVALIACAO = :id
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
            ':id' => $fisico->getId(),
        ]);
    }

    // DELETE
    public function excluirAvaliacao($idAvaliacao) {
        $stmt = $this->conn->prepare("DELETE FROM AVALIACOES_FISICAS WHERE ID_AVALIACAO = :id");
        $stmt->execute([':id' => $idAvaliacao]);
    }

    // BUSCAR POR DATA E ID_ALUNO (alternativa)
    public function buscarPorDataEAluno($data, $idAluno) {
        $stmt = $this->conn->prepare("SELECT * FROM AVALIACOES_FISICAS WHERE DATA_AVALIACAO = :data AND FK_ALUNO = :fkAluno LIMIT 1");
        $stmt->execute([':data' => $data, ':fkAluno' => $idAluno]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Fisico(
                $row['DATA_AVALIACAO'],
                $row['PESO'],
                $row['ALTURA'],
                $row['PEITORAL'],
                $row['CINTURA'],
                $row['QUADRIL'],
                $row['BRAÇO_ESQUERDO'],
                $row['BRAÇO_DIREITO'],
                $row['COXA'],
                $row['GORDURA_CORPORAL'],
                $row['MASSA_MEGRA'],
                $row['TMB'],
                $row['IMC'],
                $row['FK_ALUNO'],
                $row['ID_AVALIACAO']
            );
        }
        return null;
    }
}