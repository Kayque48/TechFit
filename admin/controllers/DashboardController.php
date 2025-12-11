<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AlunoModel.php';
require_once __DIR__ . '/../models/ProfessorModel.php';
require_once __DIR__ . '/../models/PlanoModel.php';
require_once __DIR__ . '/../models/FilialModel.php';
require_once __DIR__ . '/../models/ProdutoModel.php';
require_once __DIR__ . '/../models/AvaliacaoModel.php';

class DashboardController extends Controller {
    public function index() {
        $alunoModel = new AlunoModel();
        $professorModel = new ProfessorModel();
        $planoModel = new PlanoModel();
        $filialModel = new FilialModel();
        $produtoModel = new ProdutoModel();
        $avaliacaoModel = new AvaliacaoModel();
        
        $stats = [
            'alunos' => $alunoModel->getEstatisticas(),
            'planos' => $planoModel->getEstatisticas(),
            'filiais' => $filialModel->getEstatisticas(),
            'produtos' => $produtoModel->getEstatisticas(),
            'imc' => $avaliacaoModel->getEstatisticasIMC()
        ];
        
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
?>

