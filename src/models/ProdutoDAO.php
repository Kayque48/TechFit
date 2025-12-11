<?php

require_once 'Produto.php';
require_once __DIR__ . '\..\..\config\Connection.php';

class ProdutoDAO {
    private $conn;

     public function __construct() {
        $this->conn = Connection::getInstance()->getConnection();
    }

    // CREATE
    public function criarProduto(Produto $produto) {
        $stmt = $this->conn->prepare("
            INSERT INTO PRODUTOS (NOME_PRODUTO, QUANTIDADE, PSTATUS, PRECO)
            VALUES (:nome, :quantidade, :status, :preco)
        ");
        $stmt->execute([
            ':nome' => $produto->getNomeProduto(),
            ':quantidade' => $produto->getQuantidade(),
            ':status' => $produto->getStatus(),
            ':preco' => $produto->getPreco()
        ]);
    }

    // READ ALL
    public function lerProdutos() {
        $stmt = $this->conn->query("SELECT * FROM PRODUTOS ORDER BY NOME_PRODUTO");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Produto(
                $row['NOME_PRODUTO'],
                $row['PRECO'],
                $row['QUANTIDADE'],
                $row['PSTATUS'],
                $row['ID_PRODUTO']
            );
        }
        return $result;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM PRODUTOS WHERE ID_PRODUTO = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Produto(
                $row['NOME_PRODUTO'],
                $row['PRECO'],
                $row['QUANTIDADE'],
                $row['PSTATUS'],
                $row['ID_PRODUTO']
            );
        }
        return null;
    }

    // UPDATE
    public function atualizarProduto($id, $nomeProduto, $quantidade, $status, $preco) {
        $stmt = $this->conn->prepare("
            UPDATE PRODUTOS
            SET NOME_PRODUTO = :nome, QUANTIDADE = :quantidade, PSTATUS = :status, PRECO = :preco
            WHERE ID_PRODUTO = :id
        ");
        $stmt->execute([
            ':nome' => $nomeProduto,
            ':quantidade' => $quantidade,
            ':status' => $status,
            ':preco' => $preco,
            ':id' => $id
        ]);
    }

    // DELETE
    public function excluirProduto($id) {
        $stmt = $this->conn->prepare("DELETE FROM PRODUTOS WHERE ID_PRODUTO = :id");
        $stmt->execute([':id' => $id]);
    }
}
