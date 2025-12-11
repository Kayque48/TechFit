<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AlunoModel.php';
require_once __DIR__ . '/../models/PlanoModel.php';

class AlunoController extends Controller {
    private $model;
    private $planoModel;
    
    public function __construct() {
        $this->model = new AlunoModel();
        $this->planoModel = new PlanoModel();
    }
    
    public function index() {
        $alunos = $this->model->getAlunosComPlanos();
        $planos = $this->planoModel->findAll();
        require_once __DIR__ . '/../views/alunos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_ALUNO' => $_POST['nome'] ?? '',
                'IDADE' => $_POST['idade'] ?? '',
                'ENDERECO_ALUNO' => $_POST['endereco'] ?? '',
                'TELEFONE' => $_POST['telefone'] ?? '',
                'EMAIL' => $_POST['email'] ?? '',
                'SENHA' => password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT),
                'FK_PLANO' => !empty($_POST['plano']) ? $_POST['plano'] : null
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=aluno&action=index');
            }
        }
        
        $planos = $this->planoModel->findAll();
        require_once __DIR__ . '/../views/alunos/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_ALUNO' => $_POST['nome'] ?? '',
                'IDADE' => $_POST['idade'] ?? '',
                'ENDERECO_ALUNO' => $_POST['endereco'] ?? '',
                'TELEFONE' => $_POST['telefone'] ?? '',
                'EMAIL' => $_POST['email'] ?? '',
                'FK_PLANO' => !empty($_POST['plano']) ? $_POST['plano'] : null
            ];
            
            if (!empty($_POST['senha'])) {
                $data['SENHA'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            }
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=aluno&action=index');
            }
        }
        
        $aluno = $this->model->findById($id);
        $planos = $this->planoModel->findAll();
        require_once __DIR__ . '/../views/alunos/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=aluno&action=index');
        }
    }
    
    public function exportCSV() {
        $alunos = $this->model->getAlunosComPlanos();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=alunos_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Cabeçalhos
        fputcsv($output, ['ID', 'Nome', 'Idade', 'Endereço', 'Telefone', 'Email', 'Plano', 'Preço do Plano'], ';');
        
        // Dados
        foreach ($alunos as $aluno) {
            fputcsv($output, [
                $aluno['ID_ALUNO'],
                $aluno['NOME_ALUNO'],
                $aluno['IDADE'],
                $aluno['ENDERECO_ALUNO'],
                $aluno['TELEFONE'],
                $aluno['EMAIL'],
                $aluno['TIPO_PLANO'] ?? 'Sem plano',
                $aluno['PRECO'] ?? '0.00'
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

