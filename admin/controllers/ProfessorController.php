<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ProfessorModel.php';
require_once __DIR__ . '/../models/AulaModel.php';

class ProfessorController extends Controller {
    private $model;
    private $aulaModel;
    
    public function __construct() {
        $this->model = new ProfessorModel();
        $this->aulaModel = new AulaModel();
    }
    
    public function index() {
        $professores = $this->model->getProfessoresComAulas();
        require_once __DIR__ . '/../views/professores/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_PROFESSOR' => $_POST['nome'] ?? '',
                'CPF' => $_POST['cpf'] ?? '',
                'ESPECIALIDADE' => $_POST['especialidade'] ?? ''
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=professor&action=index');
            }
        }
        
        require_once __DIR__ . '/../views/professores/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_PROFESSOR' => $_POST['nome'] ?? '',
                'CPF' => $_POST['cpf'] ?? '',
                'ESPECIALIDADE' => $_POST['especialidade'] ?? ''
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=professor&action=index');
            }
        }
        
        $professor = $this->model->findById($id);
        require_once __DIR__ . '/../views/professores/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=professor&action=index');
        }
    }
    
    public function exportCSV() {
        $professores = $this->model->getProfessoresComAulas();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=professores_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Nome', 'CPF', 'Especialidade', 'Aulas'], ';');
        
        foreach ($professores as $prof) {
            fputcsv($output, [
                $prof['ID_PROFESSOR'],
                $prof['NOME_PROFESSOR'],
                $prof['CPF'],
                $prof['ESPECIALIDADE'],
                $prof['aulas'] ?? 'Nenhuma'
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

