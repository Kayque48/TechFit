<?php

require_once __DIR__ .'/../models/Produto.php';
require_once __DIR__ . '/../models/ProdutoDAO.php';

class ProdutoController {

    private $dao;

    public function __construct() {
        $this->dao = new ProdutoDAO();
    }

    public function ler() {
        return $this->dao->lerProdutos();
    }

    public function criar($nomeProduto, $preco, $quantidade = 20, $status = 'DISPONÍVEL') {
        $produto = new Produto($nomeProduto, $preco, $quantidade, $status);
        $this->dao->criarProduto($produto);
    }

    public function excluir($id) {
        $this->dao->excluirProduto($id);
    }

    public function atualizar($id, $nomeProduto, $quantidade, $status, $preco) {
        $this->dao->atualizarProduto($id, $nomeProduto, $quantidade, $status, $preco);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function getDAO() {
        return $this->dao;
    }
}
?>
