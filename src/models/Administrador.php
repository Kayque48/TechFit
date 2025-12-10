<?php

    class Administrador {
        private $id;
        private $user;
        private $emailAdm;
        private $senha;

        public function __construct ($user, $emailAdm, $senha, $id = null) {
           $this->setUser($user);
           $this->setEmailAdm($emailAdm);
           $this->setSenha($senha);
           $this->setId($id);

        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getUser () {
            return $this->user;
        }

        public function setUser ($user) {
            $this->user = $user;
        }

        public function getEmailAdm () {
            return $this->emailAdm;
        }

        public function setEmailAdm ($emailAdm) {
            $this->emailAdm = $emailAdm;
        }

        public function getSenha () {
            return $this->senha;
        }

        public function setSenha ($senha) {
            $this->senha = $senha;
        }
    }
