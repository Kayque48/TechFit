<?php
require_once __DIR__ . '/../config/database.php';

class Model {
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findById($id) {
        $pk = $this->getPrimaryKey();
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$pk} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function update($id, $data) {
        $set = [];
        $params = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
            $params[$key] = $value;
        }
        $set = implode(', ', $set);
        
        $pk = $this->getPrimaryKey();
        $params['id'] = $id;
        $sql = "UPDATE {$this->table} SET $set WHERE {$pk} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function delete($id) {
        $pk = $this->getPrimaryKey();
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$pk} = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    protected function getPrimaryKey() {
        // Mapeamento das chaves primárias por tabela
        $primaryKeys = [
            'ALUNOS' => 'ID_ALUNO',
            'PROFESSORES' => 'ID_PROFESSOR',
            'AULAS' => 'ID_AULA',
            'PLANOS' => 'ID_PLANO',
            'FILIAS' => 'ID_FILIAL',
            'PRODUTOS' => 'ID_PRODUTO',
            'AVALIACOES_FISICAS' => 'ID_AVALIACAO'
        ];
        
        return $primaryKeys[$this->table] ?? 'ID';
    }
}
?>

