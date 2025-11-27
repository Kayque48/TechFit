<?php

    class Filial {
        private $id;
        private $endereco;
        private $cargaMax;
        private $numColaboradores;
        private $cep;

        public function __construct ($endereco, $cep, $cargaMax = 50, $numColaboradores = 0, $id = null) {
            $this->id = $id;
            $this->endereco = $endereco;
            $this->cargaMax = $cargaMax;
            $this->numColaboradores = $numColaboradores;
            $this->cep = $cep;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getEndereco () {
            return $this->endereco;
        }

        public function setEndereco ($endereco) {
            $this->endereco = $endereco;
        }

        public function getCargaMax () {
            return $this->cargaMax;
        }

        public function setCargaMax ($cargaMax) {
            $this->cargaMax = $cargaMax;
        }

        public function getNumColaboradores () {
            return $this->numColaboradores;
        }

        public function setNumColaboradores ($numColaboradores) {
            $this->numColaboradores = $numColaboradores;
        }

        public function getCep () {
            return $this->cep;
        }

        public function setCep ($cep) {
            $this->cep = $cep;
        }
    }
