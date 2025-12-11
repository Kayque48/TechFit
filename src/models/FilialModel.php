<?php
require_once __DIR__ . '/Model.php';

class FilialModel extends Model {
    protected $table = 'FILIAS';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getEstatisticas() {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total_filiais,
                SUM(CARGA_MAX) as capacidade_total,
                SUM(NUM_COLABORADORES) as total_colaboradores
            FROM FILIAS
        ");
        return $stmt->fetch();
    }
}
?>

