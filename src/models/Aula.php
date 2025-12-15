<?php

    class Aula {
        private $id;
        private $nomeAula;
        private $tipo;
        private $tempo;
        private $data;
        private $professor;

        public function __construct ($nomeAula, $tipo, $tempo, $data, $professor, $id = null) {
            $this->setId($id);
            $this->setNomeAula($nomeAula);
            $this->setTipo($tipo);
            $this->setTempo($tempo);
            $this->setData($data);
            $this->setProfessor($professor);
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

        public function getTipo () {
            return $this->tipo;
        }

        public function setTipo ($tipo) {
            $this->tipo = $tipo;
        }

        public function getTempo () {
            return $this->tempo;
        }

        public function setTempo ($tempo) {
            $this->tempo = $tempo;
        }

        public function getData () {
            return $this->data;
        }

        public function setData ($data) {
            $this->data = $data;
        }

        public function getProfessor () {
            return $this->professor;
        }

        public function setProfessor ($professor) {
            $this->professor = $professor;
        }

    }
