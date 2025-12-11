<?php
class Auth {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function loginCliente($email, $senha) {
        require_once __DIR__ . '/database.php';
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM ALUNOS WHERE EMAIL = :email");
        $stmt->execute(['email' => $email]);
        $aluno = $stmt->fetch();
        
        if ($aluno && password_verify($senha, $aluno['SENHA'])) {
            $_SESSION['cliente_id'] = $aluno['ID_ALUNO'];
            $_SESSION['cliente_nome'] = $aluno['NOME_ALUNO'];
            $_SESSION['cliente_email'] = $aluno['EMAIL'];
            $_SESSION['tipo_usuario'] = 'cliente';
            return true;
        }
        
        return false;
    }
    
    public function loginAdmin($usuario, $senha) {
        require_once __DIR__ . '/database.php';
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM ADMINISTRACAO WHERE AUSER = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $admin = $stmt->fetch();
        
        if ($admin && $admin['SENHA'] === $senha) {
            $_SESSION['admin_id'] = $admin['ID_ADMINISTRADOR'];
            $_SESSION['admin_usuario'] = $admin['AUSER'];
            $_SESSION['tipo_usuario'] = 'admin';
            return true;
        }
        
        return false;
    }
    
    public function isCliente() {
        return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'cliente';
    }
    
    public function isAdmin() {
        return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
    }
    
    public function requireCliente() {
        if (!$this->isCliente()) {
            header('Location: cliente.php?action=login');
            exit;
        }
    }
    
    public function requireAdmin() {
        if (!$this->isAdmin()) {
            header('Location: admin.php?action=login');
            exit;
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    
    public function getClienteId() {
        return $_SESSION['cliente_id'] ?? null;
    }
    
    public function getAdminId() {
        return $_SESSION['admin_id'] ?? null;
    }
}
?>

