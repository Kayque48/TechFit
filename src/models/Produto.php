<?php

    class Produto {
        private $id;
        private $nomeProduto;
        private $quantidade;
        private $status;
        private $preco;

        public function __construct ($nomeProduto, $preco, $quantidade = 20, $status = 'DISPONÍVEL', $id = null) {
            $this->id = $id;
            $this->nomeProduto = $nomeProduto;
            $this->quantidade = $quantidade;
            $this->status = $status;
            $this->preco = $preco;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getNomeProduto () {
            return $this->nomeProduto;
        }

        public function setNomeProduto ($nomeProduto) {
            $this->nomeProduto = $nomeProduto;
        }

        public function getQuantidade () {
            return $this->quantidade;
        }

        public function setQuantidade ($quantidade) {
            $this->quantidade = $quantidade;
        }

        public function getStatus () {
            return $this->status;
        }

        public function setStatus ($status) {
            $this->status = $status;
        }

        public function getPreco () {
            return $this->preco;
        }

        public function setPreco ($preco) {
            $this->preco = $preco;
        }
    }
