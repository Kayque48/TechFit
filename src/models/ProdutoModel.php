<?php
require_once __DIR__ . '/Model.php';

class ProdutoModel extends Model {
    protected $table = 'PRODUTOS';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getEstatisticas() {
        $stats = [];
        
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM PRODUTOS");
        $stats['total'] = $stmt->fetch()['total'];
        
        $stmt = $this->db->query("SELECT COUNT(*) as disponivel FROM PRODUTOS WHERE PSTATUS = 'DISPONÍVEL'");
        $stats['disponivel'] = $stmt->fetch()['disponivel'];
        
        $stmt = $this->db->query("SELECT SUM(QUANTIDADE) as estoque_total FROM PRODUTOS");
        $stats['estoque_total'] = $stmt->fetch()['estoque_total'] ?? 0;
        
        return $stats;
    }
}
?>

