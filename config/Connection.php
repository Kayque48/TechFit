<?php
// config/Connection.php
class Connection {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $dbname = 'techfit_db';
    private $user = 'root';
    private $pass = 'BoiDataBase';

    private function __construct() {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};charset=utf8mb4",
                $this->user,
                $this->pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}
    
    public function __wakeup() {
        throw new Exception("Não é possível desserializar singleton");
    }

    public function teste() {
    echo "Connection CORRETA carregada<br>";
}
}