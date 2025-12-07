<?php

    class Aluno {
        private $id;
        private $nome;
        private $dataNasc;
        private $endereco;
        private $telefone;
        private $email;
        private $plano;
        private $senha;

        public function __construct ($nome, $dataNasc, $endereco, $telefone, $email, $plano = '', $senha = null, $id  = '') {
            $this->setNome($nome);
            $this->setDataNasc($dataNasc);
            $this->setEnder($endereco);
            $this->setTelef($telefone);
            $this->setEmail($email);
            $this->setPlano($plano);
            $this->setSenha($senha);
            $this->setId($id);
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNome ($nome) {
            $this->nome = $nome;
        }

        public function setdataNasc ($dataNasc) {
            $this->dataNasc = $dataNasc;
        }

        public function setEnder ($endereco) {
            $this->endereco = $endereco;
        }

        public function setTelef ($telefone) {
            $this->telefone = $telefone;
        }

        public function setEmail ($email) {
            $this->email = $email;
        }

        public function setPlano ($plano) {
            $this->plano = $plano;
        }

        public function setSenha ($senha) {
            $this->senha = $senha;
        }

        public function getId() {
            return $this->id;
        }

        public function getNome () {
            return $this->nome;
        }

        public function getDataNasc () {
            return $this->dataNasc;
        }

        public function getEndereco () {
            return $this->endereco;
        }

        public function getTelefone () {
            return $this->telefone;
        }

        public function getEmail () {
            return $this->email;
        }

        public function getPlano () {
            return $this->plano;
        }

        public function getSenha () {
            return $this->senha;
        }
    }