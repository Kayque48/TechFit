<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/FilialModel.php';

class FilialController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new FilialModel();
    }
    
    public function index() {
        $filiais = $this->model->findAll();
        require_once __DIR__ . '/../views/filiais/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ENDERECO' => $_POST['endereco'] ?? '',
                'CARGA_MAX' => $_POST['carga_max'] ?? 50,
                'NUM_COLABORADORES' => $_POST['num_colaboradores'] ?? 0,
                'CEP' => $_POST['cep'] ?? ''
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=filial&action=index');
            }
        }
        
        require_once __DIR__ . '/../views/filiais/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ENDERECO' => $_POST['endereco'] ?? '',
                'CARGA_MAX' => $_POST['carga_max'] ?? 50,
                'NUM_COLABORADORES' => $_POST['num_colaboradores'] ?? 0,
                'CEP' => $_POST['cep'] ?? ''
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=filial&action=index');
            }
        }
        
        $filial = $this->model->findById($id);
        require_once __DIR__ . '/../views/filiais/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=filial&action=index');
        }
    }
    
    public function exportCSV() {
        $filiais = $this->model->findAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=filiais_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Endereço', 'Carga Máxima', 'Colaboradores', 'CEP'], ';');
        
        foreach ($filiais as $filial) {
            fputcsv($output, [
                $filial['ID_FILIAL'],
                $filial['ENDERECO'],
                $filial['CARGA_MAX'],
                $filial['NUM_COLABORADORES'],
                $filial['CEP']
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

