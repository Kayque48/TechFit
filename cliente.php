<?php
session_start();

// Autoload simples
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/',
        __DIR__ . '/models/',
        __DIR__ . '/config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/config/auth.php';

$auth = Auth::getInstance();
$action = $_GET['action'] ?? 'dashboard';

// Roteamento para área do cliente
switch ($action) {
    case 'login':
        require_once __DIR__ . '/views/cliente/login.php';
        break;
    
    case 'doLogin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            
            if ($auth->loginCliente($email, $senha)) {
                header('Location: cliente.php?action=dashboard');
                exit;
            } else {
                $erro = 'Email ou senha inválidos';
                require_once __DIR__ . '/views/cliente/login.php';
            }
        }
        break;
    
    case 'logout':
        $auth->logout();
        break;
    
    case 'dashboard':
        $auth->requireCliente();
        require_once __DIR__ . '/controllers/ClienteController.php';
        $controller = new ClienteController();
        $controller->dashboard();
        break;
    
    case 'perfil':
        $auth->requireCliente();
        require_once __DIR__ . '/controllers/ClienteController.php';
        $controller = new ClienteController();
        $controller->perfil();
        break;
    
    case 'avaliacoes':
        $auth->requireCliente();
        require_once __DIR__ . '/controllers/ClienteController.php';
        $controller = new ClienteController();
        $controller->avaliacoes();
        break;
    
    case 'plano':
        $auth->requireCliente();
        require_once __DIR__ . '/controllers/ClienteController.php';
        $controller = new ClienteController();
        $controller->plano();
        break;
    
    default:
        if ($auth->isCliente()) {
            header('Location: cliente.php?action=dashboard');
        } else {
            header('Location: cliente.php?action=login');
        }
        exit;
}
?>

