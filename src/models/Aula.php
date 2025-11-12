<?php

    class Aula {
        private $id;
        private $nome;
        private $idade;
        private $endereco;
        private $telefone;
        private $avalicao;

        public function __construct ($id, $nome, $idade, $endereco, $telefone, $avalicao) {
            $this->setId($id);
            $this->setNome($nome);
            $this->setIdade($idade);
            $this->setEnder($endereco);
            $this->setTelef($telefone);
            $this->setAvali($avalicao);
        }

        public function setId ($id) {
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

        public function setAvali ($avalicao) {
            $this->avalicao = $avalicao;
        }

    }