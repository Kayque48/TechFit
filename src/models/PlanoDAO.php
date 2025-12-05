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
            INSERT INTO PLANOS (
                TIPO_PLANO, DESCRICAO, MAQUINAS, AULAS_GRUPO, 
                TREINAMENTO, CONSULTORIA, T_AVALIACAO, H_ACESSO, PRECO
            )
            VALUES (
                :tipoPlano, :descricao, :maquinas, :aulasGrupo, 
                :treinamentos, :consultoria, :avaliacao, :acesso, :preco
            )
        ");
        $stmt->execute([
            ':tipoPlano' => $plano->getTipoPlano(),
            ':descricao' => $plano->getDescricao(),
            ':maquinas' => $plano->getMaquinas(),
            ':aulasGrupo' => $plano->getAulasGrupo(),
            ':treinamentos' => $plano->getTreinamentos(),
            ':consultoria' => $plano->getConsultoria(),
            ':avaliacao' => $plano->getAvaliacao(),
            ':acesso' => $plano->getAcesso(),
            ':preco' => $plano->getPreco()
        ]);
    }

    // READ ALL
    public function lerPlanos() {
        $stmt = $this->conn->query("SELECT * FROM PLANOS ORDER BY TIPO_PLANO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Plano(
                $row['ID_PLANO'],
                $row['TIPO_PLANO'],
                $row['DESCRICAO'],
                $row['MAQUINAS'],
                $row['AULAS_GRUPO'],
                $row['TREINAMENTO'],
                $row['CONSULTORIA'],
                $row['T_AVALIACAO'],
                $row['H_ACESSO'],
                $row['PRECO']
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
                $row['ID_PLANO'],
                $row['TIPO_PLANO'],
                $row['DESCRICAO'],
                $row['MAQUINAS'],
                $row['AULAS_GRUPO'],
                $row['TREINAMENTO'],
                $row['CONSULTORIA'],
                $row['T_AVALIACAO'],
                $row['H_ACESSO'],
                $row['PRECO']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarPlano($id, $tipoPlano, $descricao, $maquinas, $aulasGrupo, $treinamentos, $consultoria, $avaliacao, $acesso, $preco) {
        $stmt = $this->conn->prepare("
            UPDATE PLANOS
            SET TIPO_PLANO = :tipoPlano,
                DESCRICAO = :descricao,
                MAQUINAS = :maquinas,
                AULAS_GRUPO = :aulasGrupo,
                TREINAMENTO = :treinamentos,
                CONSULTORIA = :consultoria,
                T_AVALIACAO = :avaliacao,
                H_ACESSO = :acesso,
                PRECO = :preco
            WHERE ID_PLANO = :id
        ");
        $stmt->execute([
            ':tipoPlano' => $tipoPlano,
            ':descricao' => $descricao,
            ':maquinas' => $maquinas,
            ':aulasGrupo' => $aulasGrupo,
            ':treinamentos' => $treinamentos,
            ':consultoria' => $consultoria,
            ':avaliacao' => $avaliacao,
            ':acesso' => $acesso,
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
?>