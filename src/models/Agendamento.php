<?php

    class Agendamento {
        private $id;
        private $alunoId;
        private $aulaId;

        public function __construct($alunoId, $aulaId, $id = null) {
            $this->setId($id);
            $this->setAlunoId($alunoId);
            $this->setAulaId($aulaId);
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getAlunoId() {
            return $this->alunoId;
        }

        public function setAlunoId($alunoId) {
            $this->alunoId = $alunoId;
        }

        public function getAulaId() {
            return $this->aulaId;
        }

        public function setAulaId($aulaId) {
            $this->aulaId = $aulaId;
        }
    }