<?php
require_once __DIR__ . '/Model.php';

class PlanoModel extends Model {
    protected $table = 'PLANOS';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getEstatisticas() {
        $stmt = $this->db->query("
            SELECT p.TIPO_PLANO, COUNT(a.ID_ALUNO) as total_alunos
            FROM PLANOS p
            LEFT JOIN ALUNOS a ON p.ID_PLANO = a.FK_PLANO
            GROUP BY p.ID_PLANO, p.TIPO_PLANO
        ");
        return $stmt->fetchAll();
    }
}
?>

