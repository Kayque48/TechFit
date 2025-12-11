<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/PlanoModel.php';

class PlanoController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new PlanoModel();
    }
    
    public function index() {
        $planos = $this->model->findAll();
        require_once __DIR__ . '/../views/planos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TIPO_PLANO' => $_POST['tipo'] ?? '',
                'DESCRICAO' => $_POST['descricao'] ?? '',
                'MAQUINAS' => $_POST['maquinas'] ?? '',
                'AULAS_GRUPO' => $_POST['aulas_grupo'] ?? '',
                'TREINAMENTO' => $_POST['treinamento'] ?? '',
                'CONSULTORIA' => $_POST['consultoria'] ?? '',
                'T_AVALIACAO' => $_POST['t_avaliacao'] ?? '',
                'H_ACESSO' => $_POST['h_acesso'] ?? '',
                'PRECO' => $_POST['preco'] ?? 0
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=plano&action=index');
            }
        }
        
        require_once __DIR__ . '/../views/planos/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TIPO_PLANO' => $_POST['tipo'] ?? '',
                'DESCRICAO' => $_POST['descricao'] ?? '',
                'MAQUINAS' => $_POST['maquinas'] ?? '',
                'AULAS_GRUPO' => $_POST['aulas_grupo'] ?? '',
                'TREINAMENTO' => $_POST['treinamento'] ?? '',
                'CONSULTORIA' => $_POST['consultoria'] ?? '',
                'T_AVALIACAO' => $_POST['t_avaliacao'] ?? '',
                'H_ACESSO' => $_POST['h_acesso'] ?? '',
                'PRECO' => $_POST['preco'] ?? 0
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=plano&action=index');
            }
        }
        
        $plano = $this->model->findById($id);
        require_once __DIR__ . '/../views/planos/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=plano&action=index');
        }
    }
    
    public function exportCSV() {
        $planos = $this->model->findAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=planos_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Tipo', 'Descrição', 'Máquinas', 'Aulas Grupo', 'Treinamento', 'Consultoria', 'Avaliação', 'Horário Acesso', 'Preço'], ';');
        
        foreach ($planos as $plano) {
            fputcsv($output, [
                $plano['ID_PLANO'],
                $plano['TIPO_PLANO'],
                $plano['DESCRICAO'],
                $plano['MAQUINAS'],
                $plano['AULAS_GRUPO'],
                $plano['TREINAMENTO'],
                $plano['CONSULTORIA'],
                $plano['T_AVALIACAO'],
                $plano['H_ACESSO'],
                $plano['PRECO']
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

