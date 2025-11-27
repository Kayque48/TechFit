<?php

    class Professor {
        private $id;
        private $nomeProfessor;
        private $cpf;
        private $especialidade;

        public function __construct ($nomeProfessor, $cpf, $especialidade, $id = null) {
            $this->id = $id;
            $this->nomeProfessor = $nomeProfessor;
            $this->cpf = $cpf;
            $this->especialidade = $especialidade;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getNomeProfessor () {
            return $this->nomeProfessor;
        }

        public function setNomeProfessor ($nomeProfessor) {
            $this->nomeProfessor = $nomeProfessor;
        }

        public function getCpf () {
            return $this->cpf;
        }

        public function setCpf ($cpf) {
            $this->cpf = $cpf;
        }

        public function getEspecialidade () {
            return $this->especialidade;
        }

        public function setEspecialidade ($especialidade) {
            $this->especialidade = $especialidade;
        }
    }
