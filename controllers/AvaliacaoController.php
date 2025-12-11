<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AvaliacaoModel.php';
require_once __DIR__ . '/../models/AlunoModel.php';

class AvaliacaoController extends Controller {
    private $model;
    private $alunoModel;
    
    public function __construct() {
        $this->model = new AvaliacaoModel();
        $this->alunoModel = new AlunoModel();
    }
    
    public function index() {
        $avaliacoes = $this->model->getAvaliacoesComAlunos();
        require_once __DIR__ . '/../views/avaliacoes/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peso = floatval($_POST['peso'] ?? 0);
            $altura = floatval($_POST['altura'] ?? 0);
            $imc = $altura > 0 ? $peso / ($altura * $altura) : null;
            
            $data = [
                'DATA_AVALIACAO' => $_POST['data'] ?? date('Y-m-d'),
                'PESO' => $peso,
                'ALTURA' => $altura,
                'PEITORAL' => !empty($_POST['peitoral']) ? $_POST['peitoral'] : null,
                'CINTURA' => !empty($_POST['cintura']) ? $_POST['cintura'] : null,
                'QUADRIL' => !empty($_POST['quadril']) ? $_POST['quadril'] : null,
                'BRAÇO_ESQUERDO' => !empty($_POST['braco_esquerdo']) ? $_POST['braco_esquerdo'] : null,
                'BRAÇO_DIREITO' => !empty($_POST['braco_direito']) ? $_POST['braco_direito'] : null,
                'COXA' => !empty($_POST['coxa']) ? $_POST['coxa'] : null,
                'GORDURA_CORPORAL' => !empty($_POST['gordura']) ? $_POST['gordura'] : null,
                'MASSA_MEGRA' => !empty($_POST['massa_magra']) ? $_POST['massa_magra'] : null,
                'TMB' => !empty($_POST['tmb']) ? $_POST['tmb'] : null,
                'IMC' => $imc,
                'FK_ALUNO' => $_POST['aluno'] ?? null
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=avaliacao&action=index');
            }
        }
        
        $alunos = $this->alunoModel->findAll();
        require_once __DIR__ . '/../views/avaliacoes/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peso = floatval($_POST['peso'] ?? 0);
            $altura = floatval($_POST['altura'] ?? 0);
            $imc = $altura > 0 ? $peso / ($altura * $altura) : null;
            
            $data = [
                'DATA_AVALIACAO' => $_POST['data'] ?? date('Y-m-d'),
                'PESO' => $peso,
                'ALTURA' => $altura,
                'PEITORAL' => !empty($_POST['peitoral']) ? $_POST['peitoral'] : null,
                'CINTURA' => !empty($_POST['cintura']) ? $_POST['cintura'] : null,
                'QUADRIL' => !empty($_POST['quadril']) ? $_POST['quadril'] : null,
                'BRAÇO_ESQUERDO' => !empty($_POST['braco_esquerdo']) ? $_POST['braco_esquerdo'] : null,
                'BRAÇO_DIREITO' => !empty($_POST['braco_direito']) ? $_POST['braco_direito'] : null,
                'COXA' => !empty($_POST['coxa']) ? $_POST['coxa'] : null,
                'GORDURA_CORPORAL' => !empty($_POST['gordura']) ? $_POST['gordura'] : null,
                'MASSA_MEGRA' => !empty($_POST['massa_magra']) ? $_POST['massa_magra'] : null,
                'TMB' => !empty($_POST['tmb']) ? $_POST['tmb'] : null,
                'IMC' => $imc,
                'FK_ALUNO' => $_POST['aluno'] ?? null
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=avaliacao&action=index');
            }
        }
        
        $avaliacao = $this->model->findById($id);
        $alunos = $this->alunoModel->findAll();
        require_once __DIR__ . '/../views/avaliacoes/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=avaliacao&action=index');
        }
    }
    
    public function exportCSV() {
        $avaliacoes = $this->model->getAvaliacoesComAlunos();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=avaliacoes_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Data', 'Aluno', 'Peso', 'Altura', 'IMC', 'Gordura Corporal', 'Massa Magra', 'TMB'], ';');
        
        foreach ($avaliacoes as $av) {
            fputcsv($output, [
                $av['ID_AVALIACAO'],
                $av['DATA_AVALIACAO'],
                $av['NOME_ALUNO'] ?? 'N/A',
                $av['PESO'],
                $av['ALTURA'],
                $av['IMC'] ?? 'N/A',
                $av['GORDURA_CORPORAL'] ?? 'N/A',
                $av['MASSA_MEGRA'] ?? 'N/A',
                $av['TMB'] ?? 'N/A'
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

