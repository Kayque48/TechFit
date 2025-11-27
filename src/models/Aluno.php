<?php

    class Aluno {
        private $nome;
        private $idade;
        private $endereco;
        private $telefone;
        private $email;
        private $avaliacao;
        private $plano;
        private $senha;

        public function __construct ($nome, $idade, $endereco, $telefone, $email, $avaliacao, $plano, $senha = null) {
            $this->setNome($nome);
            $this->setIdade($idade);
            $this->setEnder($endereco);
            $this->setTelef($telefone);
            $this->setEmail($email);
            $this->setAvali($avaliacao);
            $this->setPlano($plano);
            $this->setSenha($senha);
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

        public function setAvali ($avaliacao) {
            $this->avaliacao = $avaliacao;
        }

        public function setPlano ($plano) {
            $this->plano = $plano;
        }

        public function setSenha ($senha) {
            $this->senha = $senha;
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
            return $this->avaliacao;
        }

        public function getPlano () {
            return $this->plano;
        }

        public function getSenha () {
            return $this->senha;
        }
    }