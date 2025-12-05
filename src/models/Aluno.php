<?php

    class Aluno {
        private $id;
        private $nome;
        private $idade;
        private $endereco;
        private $telefone;
        private $email;
        private $plano;
        private $senha;

        public function __construct ($nome, $idade, $endereco, $telefone, $email, $plano = '', $senha = null, $id  = '') {
            $this->setNome($nome);
            $this->setIdade($idade);
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

        public function setIdade ($idade) {
            $this->idade = $idade;
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

        public function getIdade () {
            return $this->idade;
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