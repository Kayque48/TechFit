<?php

    class Fisico {
        private $id;
        private $data;
        private $peso;
        private $altura;
        private $peitoral;
        private $cintura;
        private $quadril;
        private $braEsquerdo;
        private $braDireito;
        private $coxa;
        private $gordura;
        private $masMagra;
        private $tmb;
        private $imc;
        private $fkAluno;

        public function __construct ($data, $peso, $altura, $peitoral, $cintura, $quadril, $braEsquerdo, $braDireito, $coxa, $gordura, $masMagra, $tmb, $imc, $fkAluno = null, $id = null) {
            $this->id = $id;
            $this->setData($data);
            $this->setPeso($peso);
            $this->setAltura($altura);
            $this->setPeitoral($peitoral);
            $this->setCintura($cintura);
            $this->setQuadril($quadril);
            $this->setBraEsquerdo($braEsquerdo);
            $this->setBraDireito($braDireito);
            $this->setCoxa($coxa);
            $this->setGordura($gordura);
            $this->setMasMagra($masMagra);
            $this->setTmb($tmb);
            $this->setImc($imc);
            $this->fkAluno = $fkAluno;
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getFkAluno () {
            return $this->fkAluno;
        }

        public function setFkAluno ($fkAluno) {
            $this->fkAluno = $fkAluno;
        }

        public function setData ($data) {
            $this->data = $data;
        }

        public function setPeso ($peso) {
            $this->peso = $peso;
        }

        public function setAltura ($altura) {
            $this->altura = $altura;
        }

        public function setPeitoral ($peitoral) {
            $this->peitoral = $peitoral;
        }

        public function setCintura ($cintura) {
            $this->cintura = $cintura;
        }

        public function setQuadril ($quadril) {
            $this->quadril = $quadril;
        }

        public function setBraEsquerdo ($braEsquerdo) {
            $this->braEsquerdo = $braEsquerdo;
        }

        public function setBraDireito ($braDireito) {
            $this->braDireito = $braDireito;
        }

        public function setCoxa ($coxa) {
            $this->coxa = $coxa;
        }

        public function setGordura ($gordura) {
            $this->gordura = $gordura;
        }

        public function setMasMagra ($masMagra) {
            $this->masMagra = $masMagra;
        }

        public function setTmb ($tmb) {
            $this->tmb = $tmb;
        }

        public function setImc ($imc) {
            $this->imc = $imc;
        }

        public function getData () {
            return $this->data;
        }

        public function getPeso () {
            return $this->peso;
        }

        public function getAltura () {
            return $this->altura;
        }

        public function getPeitoral () {
            return $this->peitoral;
        }

        public function getCintura () {
            return $this->cintura;
        }

        public function getQuadril () {
            return $this->quadril;
        }

        public function getBraEsquerdo () {
            return $this->braEsquerdo;
        }

        public function getBraDireito () {
            return $this->braDireito;
        }

        public function getCoxa () {
            return $this->coxa;
        }

        public function getGordura () {
            return $this->gordura;
        }

        public function getMasMagra () {
            return $this->masMagra;
        }

        public function getTmb () {
            return $this->tmb;
        }

        public function getImc () {
            return $this->imc;
        }
    }