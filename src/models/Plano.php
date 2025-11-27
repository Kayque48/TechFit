<?php

    class Plano {
        private $id;
        private $tipoPlano;
        private $duracaoMes;
        private $preco;

        public function __construct ($tipoPlano, $duracaoMes, $preco, $id = null) {
            $this->id = $id;
            $this->tipoPlano = $tipoPlano;
            $this->duracaoMes = $duracaoMes;
            $this->preco = $preco;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getTipoPlano () {
            return $this->tipoPlano;
        }

        public function setTipoPlano ($tipoPlano) {
            $this->tipoPlano = $tipoPlano;
        }

        public function getDuracaoMes () {
            return $this->duracaoMes;
        }

        public function setDuracaoMes ($duracaoMes) {
            $this->duracaoMes = $duracaoMes;
        }

        public function getPreco () {
            return $this->preco;
        }

        public function setPreco ($preco) {
            $this->preco = $preco;
        }
    }