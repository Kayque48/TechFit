<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AulaModel.php';

class AulaController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new AulaModel();
    }
    
    public function index() {
        $aulas = $this->model->findAll();
        require_once __DIR__ . '/../views/aulas/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_AULA' => $_POST['nome'] ?? '',
                'AVALIACAO' => $_POST['avaliacao'] ?? ''
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=aula&action=index');
            }
        }
        
        require_once __DIR__ . '/../views/aulas/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_AULA' => $_POST['nome'] ?? '',
                'AVALIACAO' => $_POST['avaliacao'] ?? ''
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=aula&action=index');
            }
        }
        
        $aula = $this->model->findById($id);
        require_once __DIR__ . '/../views/aulas/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=aula&action=index');
        }
    }
    
    public function exportCSV() {
        $aulas = $this->model->findAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=aulas_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Nome', 'Avaliação'], ';');
        
        foreach ($aulas as $aula) {
            fputcsv($output, [
                $aula['ID_AULA'],
                $aula['NOME_AULA'],
                $aula['AVALIACAO']
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

