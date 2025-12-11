<?php
require_once __DIR__ . '/Model.php';

class AvaliacaoModel extends Model {
    protected $table = 'AVALIACOES_FISICAS';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAvaliacoesComAlunos() {
        $stmt = $this->db->prepare("
            SELECT av.*, a.NOME_ALUNO 
            FROM AVALIACOES_FISICAS av
            LEFT JOIN ALUNOS a ON av.FK_ALUNO = a.ID_ALUNO
            ORDER BY av.DATA_AVALIACAO DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getEstatisticasIMC() {
        $stmt = $this->db->query("
            SELECT 
                CASE 
                    WHEN IMC < 18.5 THEN 'Abaixo do peso'
                    WHEN IMC < 25 THEN 'Normal'
                    WHEN IMC < 30 THEN 'Sobrepeso'
                    ELSE 'Obesidade'
                END as categoria,
                COUNT(*) as total
            FROM AVALIACOES_FISICAS
            WHERE IMC IS NOT NULL
            GROUP BY categoria
        ");
        return $stmt->fetchAll();
    }
}
?>

