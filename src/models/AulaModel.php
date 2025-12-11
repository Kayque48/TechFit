<?php
require_once __DIR__ . '/Model.php';

class AulaModel extends Model {
    protected $table = 'AULAS';
    
    public function __construct() {
        parent::__construct();
    }
}
?>

