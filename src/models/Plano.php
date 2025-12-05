<?php

    class Plano {
        private $id;
        private $tipoPlano;
        private $descricao;
        private $maquinas;
        private $aulasGrupo;
        private $treinamentos;
        private $consultoria;
        private $avaliacao;
        private $acesso;
        private $preco;


        public function __construct ($id, $tipoPlano, $descricao, $maquinas, $aluasGrupo, $treinamentos, $consultoria, $avaliacao, $acesso, $preco) {
            $this->setid( $id );
            $this->setTipoPlano($tipoPlano);
            $this->setDescricao($descricao);
            $this->setMaquinas($maquinas);
            $this->setAulasGrupo($aluasGrupo);
            $this->setTreinamentos($treinamentos);
            $this->setConsultoria($consultoria);
            $this->setavaliacao($avaliacao);
            $this->setacesso($acesso);
            $this->setPreco($preco);
        }

        public function getId () {
            return $this->id;
        }

        public function setId ($id) {
            $this->id = $id;
        }

        public function getTipoPlano () {
            return $this->tipoPlano;
        }

        public function setTipoPlano ($tipoPlano) {
            $this->tipoPlano = $tipoPlano;
        }

        public function getDescricao () {
            return $this->descricao;
        }

        public function setDescricao ($descricao) {
            $this->descricao = $descricao;
        }

        public function setMaquinas ($maquinas) {
            $this->maquinas = $maquinas;
        }

        public function getMaquinas () {
            return $this->maquinas;
        }

        public function setAulasGrupo ($aulasGrupo) {
            $this->aulasGrupo = $aulasGrupo;
        }

        public function getAulasGrupo () {
            return $this->aulasGrupo;
        }

        public function setTreinamentos ($treinamentos) {
            $this->treinamentos = $treinamentos;
        }

        public function getTreinamentos () {
            return $this->treinamentos;
        }

        public function setConsultoria ($consultoria) {
            $this->consultoria = $consultoria;
        }

        public function getConsultoria () {
            return $this->consultoria;
        }

        public function setAvaliacao ($avaliacao) {
            $this->avaliacao = $avaliacao;
        }


        public function getAvaliacao () {
            return $this->avaliacao;
        }

        public function setAcesso ($acesso) {
            $this->acesso = $acesso;
        }

        public function getAcesso () {
            return $this->acesso;
        }

        public function getPreco () {
            return $this->preco;
        }

        public function setPreco ($preco) {
            $this->preco = $preco;
        }
    }