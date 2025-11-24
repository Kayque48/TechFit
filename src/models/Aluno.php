<?php

    class Aluno {
        private $nome;
        private $idade;
        private $endereco;
        private $telefone;
        private $email;
        private $avalicao;

        public function __construct ($nome, $idade, $endereco, $telefone, $email, $avalicao) {
            $this->setNome($nome);
            $this->setIdade($idade);
            $this->setEnder($endereco);
            $this->setTelef($telefone);
            $this->setEmail($email);
            $this->setAvali($avalicao);
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

        public function setAvali ($avalicao) {
            $this->avalicao = $avalicao;
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

        public function getAvaliacao () {
            return $this->avalicao;
        }



    }