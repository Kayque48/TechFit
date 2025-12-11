<?php
require_once __DIR__ . '/Model.php';

class AlunoModel extends Model {
    protected $table = 'ALUNOS';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAlunosComPlanos() {
        $stmt = $this->db->prepare("
            SELECT a.*, p.TIPO_PLANO, p.PRECO 
            FROM ALUNOS a 
            LEFT JOIN PLANOS p ON a.FK_PLANO = p.ID_PLANO
            ORDER BY a.ID_ALUNO
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getEstatisticas() {
        $stats = [];
        
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM ALUNOS");
        $stats['total'] = $stmt->fetch()['total'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as com_plano FROM ALUNOS WHERE FK_PLANO IS NOT NULL");
        $stats['com_plano'] = $stmt->fetch()['com_plano'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as sem_plano FROM ALUNOS WHERE FK_PLANO IS NULL");
        $stats['sem_plano'] = $stmt->fetch()['sem_plano'];
        
        return $stats;
    }
}
?>

