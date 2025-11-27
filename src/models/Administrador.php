<?php

    class Administrador {
        private $id;
        private $auser;
        private $senha;

        public function __construct ($auser, $senha, $id = null) {
            $this->id = $id;
            $this->auser = $auser;
            $this->senha = $senha;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getAuser () {
            return $this->auser;
        }

        public function setAuser ($auser) {
            $this->auser = $auser;
        }

        public function getSenha () {
            return $this->senha;
        }

        public function setSenha ($senha) {
            $this->senha = $senha;
        }
    }
