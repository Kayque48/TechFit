<?php

    class Aula {
        private $id;
        private $nomeAula;
        private $avaliacao;

        public function __construct ($nomeAula, $avaliacao, $id = null) {
            $this->id = $id;
            $this->nomeAula = $nomeAula;
            $this->avaliacao = $avaliacao;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getNomeAula () {
            return $this->nomeAula;
        }

        public function setNomeAula ($nomeAula) {
            $this->nomeAula = $nomeAula;
        }

        public function getAvaliacao () {
            return $this->avaliacao;
        }

        public function setAvaliacao ($avaliacao) {
            $this->avaliacao = $avaliacao;
        }
    }
