<?php
require_once __DIR__ . '/Model.php';

class ProfessorModel extends Model {
    protected $table = 'PROFESSORES';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getProfessoresComAulas() {
        $stmt = $this->db->prepare("
            SELECT p.*, GROUP_CONCAT(a.NOME_AULA) as aulas
            FROM PROFESSORES p
            LEFT JOIN PODE po ON p.ID_PROFESSOR = po.FK_PROFESSOR
            LEFT JOIN AULAS a ON po.FK_AULA = a.ID_AULA
            GROUP BY p.ID_PROFESSOR
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>

