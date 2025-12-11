<?php
class Auth {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Login de Cliente
     */
    public function loginCliente($email, $senha) {
        require_once __DIR__ . '/../src/models/AlunoDAO.php';
        $dao = new AlunoDAO();
        
        $aluno = $dao->buscarPorEmail($email);
        
        if ($aluno && isset($aluno['SENHA']) && password_verify($senha, $aluno['SENHA'])) {
            $_SESSION['cliente_id'] = $aluno['ID_ALUNO'];
            $_SESSION['cliente_nome'] = $aluno['NOME_ALUNO'];
            $_SESSION['cliente_email'] = $aluno['EMAIL'];
            $_SESSION['tipo_usuario'] = 'cliente';
            $_SESSION['logado'] = true;
            return true;
        }
        
        return false;
    }
    
    /**
     * Login de Admin
     */
    public function loginAdmin($usuario, $senha) {
        require_once __DIR__ . '/../src/models/AdministradorDAO.php';
        $dao = new AdministradorDAO();
        
        $admin = $dao->buscarPorUsuario($usuario);
        
        if ($admin && password_verify($senha, $admin['SENHA'])) {
            $_SESSION['admin_id'] = $admin['ID_ADMINISTRADOR'];
            $_SESSION['admin_usuario'] = $admin['AUSER'];
            $_SESSION['tipo_usuario'] = 'admin';
            $_SESSION['logado'] = true;
            return true;
        }
        
        return false;
    }
    
    /**
     * Verificações de Tipo de Usuário
     */
    public function isCliente() {
        return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'cliente';
    }
    
    public function isAdmin() {
        return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
    }
    
    /**
     * Requer autenticação
     */
    public function requireCliente() {
        if (!$this->isCliente()) {
            header('Location: /public/login.php');
            exit;
        }
    }
    
    public function requireAdmin() {
        if (!$this->isAdmin()) {
            header('Location: /admin/index.php?action=login');
            exit;
        }
    }
    
    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        header('Location: /public/index.php');
        exit;
    }
    
    /**
     * Getters
     */
    public function getClienteId() {
        return $_SESSION['cliente_id'] ?? null;
    }
    
    public function getAdminId() {
        return $_SESSION['admin_id'] ?? null;
    }
}
?>