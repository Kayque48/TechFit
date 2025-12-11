<?php

class Treino {
    private $id;
    private $nome;
    private $diaSemana;
    private $horarioInicio;
    private $horarioFim;
    private $instrutor;
    private $descricao;
    private $calorias;
    private $idAluno;
    private $dataRealizacao;

    public function __construct(
        $id,
        $nome,
        $diaSemana,
        $horarioInicio,
        $horarioFim,
        $instrutor,
        $descricao,
        $calorias,
        $idAluno,
        $dataRealizacao
    ) {
        $this->setId($id);
        $this->setNome($nome);
        $this->setDiaSemana($diaSemana);
        $this->setHorarioInicio($horarioInicio);
        $this->setHorarioFim($horarioFim);
        $this->setInstrutor($instrutor);
        $this->setDescricao($descricao);
        $this->setCalorias($calorias);
        $this->setIdAluno($idAluno);
        $this->setDataRealizacao($dataRealizacao);
    }

    // Getters
    public function getId() { 
        return $this->id; 
    }

    public function getNome() { 
        return $this->nome; 
    }

    public function getDiaSemana() { 
        return $this->diaSemana; 
    }

    public function getHorarioInicio() { 
        return $this->horarioInicio; 
    }

    public function getHorarioFim() { 
        return $this->horarioFim; 
    }

    public function getInstrutor() { 
        return $this->instrutor; 
    }

    public function getDescricao() { 
        return $this->descricao; 
    }

    public function getCalorias() { 
        return $this->calorias; 
    }

    public function getIdAluno() { 
        return $this->idAluno; 
    }

    public function getDataRealizacao() { 
        return $this->dataRealizacao; 
    }

    // Setters
    public function setId($id) { 
        $this->id = $id; 
    }

    public function setNome($nome) { 
        $this->nome = $nome; 
    }

    public function setDiaSemana($diaSemana) { 
        $this->diaSemana = $diaSemana; 
    }

    public function setHorarioInicio($horarioInicio) { 
        $this->horarioInicio = $horarioInicio; 
    }

    public function setHorarioFim($horarioFim) { 
        $this->horarioFim = $horarioFim; 
    }

    public function setInstrutor($instrutor) { 
        $this->instrutor = $instrutor; 
    }

    public function setDescricao($descricao) { 
        $this->descricao = $descricao; 
    }

    public function setCalorias($calorias) { 
        $this->calorias = $calorias; 
    }

    public function setIdAluno($idAluno) { 
        $this->idAluno = $idAluno; 
    }

    public function setDataRealizacao($dataRealizacao) { 
        $this->dataRealizacao = $dataRealizacao; 
    }

    // Métodos auxiliares
    
    /**
     * Calcula a duração do treino em formato HH:MM
     */
    public function getDuracao() {
        try {
            $inicio = new DateTime($this->horarioInicio);
            $fim = new DateTime($this->horarioFim);
            $diff = $inicio->diff($fim);
            return $diff->format('%H:%I');
        } catch (Exception $e) {
            return '00:00';
        }
    }

    /**
     * Calcula a duração do treino em minutos
     */
    public function getDuracaoMinutos() {
        try {
            $inicio = new DateTime($this->horarioInicio);
            $fim = new DateTime($this->horarioFim);
            $diff = $inicio->diff($fim);
            return ($diff->h * 60) + $diff->i;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Retorna informações formatadas do treino
     */
    public function getResumo() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'diaSemana' => $this->diaSemana,
            'horario' => substr($this->horarioInicio, 0, 5) . ' - ' . substr($this->horarioFim, 0, 5),
            'duracao' => $this->getDuracao(),
            'instrutor' => $this->instrutor,
            'calorias' => $this->calorias,
            'data' => date('d/m/Y', strtotime($this->dataRealizacao))
        ];
    }

    /**
     * Verifica se o treino é de hoje
     */
    public function isHoje() {
        return $this->dataRealizacao === date('Y-m-d');
    }

    /**
     * Verifica se o treino é desta semana
     */
    public function isDessaSemana() {
        $dataAtual = new DateTime();
        $dataTreino = new DateTime($this->dataRealizacao);
        $semanaAtual = $dataAtual->format('W-Y');
        $semanaTreino = $dataTreino->format('W-Y');
        return $semanaAtual === $semanaTreino;
    }

    /**
     * Retorna array com todos os dados do treino
     */
    public function toArray() {
        return [
            'ID_TREINO' => $this->id,
            'NOME_TREINO' => $this->nome,
            'DIA_SEMANA' => $this->diaSemana,
            'HORARIO_INICIO' => $this->horarioInicio,
            'HORARIO_FIM' => $this->horarioFim,
            'INSTRUTOR' => $this->instrutor,
            'DESCRICAO' => $this->descricao,
            'CALORIAS' => $this->calorias,
            'FK_ALUNO' => $this->idAluno,
            'DATA_REALIZACAO' => $this->dataRealizacao,
            'DURACAO' => $this->getDuracao(),
            'DURACAO_MINUTOS' => $this->getDuracaoMinutos()
        ];
    }
}