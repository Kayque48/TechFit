<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AlunoModel.php';
require_once __DIR__ . '/../models/AvaliacaoModel.php';
require_once __DIR__ . '/../models/PlanoModel.php';
require_once __DIR__ . '/../config/auth.php';

class ClienteController extends Controller {
    private $alunoModel;
    private $avaliacaoModel;
    private $planoModel;
    private $auth;
    
    public function __construct() {
        $this->alunoModel = new AlunoModel();
        $this->avaliacaoModel = new AvaliacaoModel();
        $this->planoModel = new PlanoModel();
        $this->auth = Auth::getInstance();
    }
    
    public function dashboard() {
        $clienteId = $this->auth->getClienteId();
        $aluno = $this->alunoModel->findById($clienteId);
        
        // Buscar avaliações do cliente
        $avaliacoes = $this->avaliacaoModel->getAvaliacoesComAlunos();
        $avaliacoes = array_filter($avaliacoes, function($av) use ($clienteId) {
            return $av['FK_ALUNO'] == $clienteId;
        });
        
        // Buscar plano do cliente
        $plano = null;
        if ($aluno['FK_PLANO']) {
            $plano = $this->planoModel->findById($aluno['FK_PLANO']);
        }
        
        require_once __DIR__ . '/../views/cliente/dashboard.php';
    }
    
    public function perfil() {
        $clienteId = $this->auth->getClienteId();
        $aluno = $this->alunoModel->findById($clienteId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'NOME_ALUNO' => $_POST['nome'] ?? '',
                'TELEFONE' => $_POST['telefone'] ?? '',
                'ENDERECO_ALUNO' => $_POST['endereco'] ?? ''
            ];
            
            if (!empty($_POST['senha'])) {
                $data['SENHA'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            }
            
            if ($this->alunoModel->update($clienteId, $data)) {
                $_SESSION['cliente_nome'] = $data['NOME_ALUNO'];
                header('Location: cliente.php?action=perfil&success=1');
                exit;
            }
        }
        
        require_once __DIR__ . '/../views/cliente/perfil.php';
    }
    
    public function avaliacoes() {
        $clienteId = $this->auth->getClienteId();
        
        // Buscar avaliações do cliente
        $avaliacoes = $this->avaliacaoModel->getAvaliacoesComAlunos();
        $avaliacoes = array_filter($avaliacoes, function($av) use ($clienteId) {
            return $av['FK_ALUNO'] == $clienteId;
        });
        
        require_once __DIR__ . '/../views/cliente/avaliacoes.php';
    }
    
    public function plano() {
        $clienteId = $this->auth->getClienteId();
        $aluno = $this->alunoModel->findById($clienteId);
        
        $plano = null;
        if ($aluno['FK_PLANO']) {
            $plano = $this->planoModel->findById($aluno['FK_PLANO']);
        }
        
        $planosDisponiveis = $this->planoModel->findAll();
        
        require_once __DIR__ . '/../views/cliente/plano.php';
    }
}
?>

