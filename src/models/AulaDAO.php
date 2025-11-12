<?php 

    class AulaDAO {
        private $aulas = [];

        private $arquivo = 'aulas.json';

        public function __construct() {
            if (file_exists($this->arquivo)) {
                $conteudo = file_get_contents($this->arquivo);

                $dados = json_decode($conteudo, true);

                if($dados) {
                    foreach($dados as $nomes => $info) {
                        $this->aulas[$nomes] = new Aulas(
                            $info['nome'],
                            $info['idade'],
                            $info['endereco'],
                            $info['telefone'],
                            $info['email'],
                            $info['avalicao']
                        );
                    }
                }
             }
        }

        private function salvarEmArquivo() {
            $dados = [$nome] = [
                'nome' => $aulas->getNome(),
                'idade' => $aulas->getIdado(),
                'endereco' => $aulas->getEnder(),
                'telefone' => $aulas->getTelef(),
                'avalicao' => $aulas->getAvali()
            ];
             file_put_contents($this->arquivo, json_encode($dados, JSON_PRETTY_PRINT));
        }

        public function criarAula(Aula $aulas) {
            $this->aulas[$aulas->getNome()] = $aulas;
            $this->salvarEmArquivo();
        }

    }