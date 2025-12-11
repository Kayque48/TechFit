<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ProdutoModel.php';

class ProdutoController extends Controller {
    private $model;
    
    public function __construct() {
        $this->model = new ProdutoModel();
    }
    
    public function index() {
        $produtos = $this->model->findAll();
        require_once __DIR__ . '/../views/produtos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_PRODUTO' => $_POST['nome'] ?? '',
                'QUANTIDADE' => $_POST['quantidade'] ?? 20,
                'PSTATUS' => $_POST['status'] ?? 'DISPONÍVEL',
                'PRECO' => $_POST['preco'] ?? 0
            ];
            
            if ($this->model->create($data)) {
                $this->redirect('index.php?controller=produto&action=index');
            }
        }
        
        require_once __DIR__ . '/../views/produtos/create.php';
    }
    
    public function update() {
        $id = $_GET['id'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_PRODUTO' => $_POST['nome'] ?? '',
                'QUANTIDADE' => $_POST['quantidade'] ?? 20,
                'PSTATUS' => $_POST['status'] ?? 'DISPONÍVEL',
                'PRECO' => $_POST['preco'] ?? 0
            ];
            
            if ($this->model->update($id, $data)) {
                $this->redirect('index.php?controller=produto&action=index');
            }
        }
        
        $produto = $this->model->findById($id);
        require_once __DIR__ . '/../views/produtos/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $this->redirect('index.php?controller=produto&action=index');
        }
    }
    
    public function exportCSV() {
        $produtos = $this->model->findAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=produtos_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Nome', 'Quantidade', 'Status', 'Preço'], ';');
        
        foreach ($produtos as $produto) {
            fputcsv($output, [
                $produto['ID_PRODUTO'],
                $produto['NOME_PRODUTO'],
                $produto['QUANTIDADE'],
                $produto['PSTATUS'],
                $produto['PRECO']
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
?>

