<?php

session_start();

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/controllers/',
        __DIR__ . '/../src/models/',
        __DIR__ . '/../config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/../config/auth.php';

$auth = Auth::getInstance();
$action = $_GET['action'] ?? 'dashboard';
$controller = $_GET['controller'] ?? 'dashboard';

// Logout
if ($action === 'logout') {
    $auth->logout();
}

// Login
if ($action === 'login' || $action === 'doLogin') {
    if ($action === 'doLogin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if ($auth->loginAdmin($usuario, $senha)) {
            header('Location: index.php?controller=dashboard&action=index');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos';
            require_once __DIR__ . '/views/admin/login.php';
        }
    } else {
        require_once __DIR__ . '/views/admin/login.php';
    }
    exit;
}

// Verificar autenticação
$auth->requireAdmin();

// Mapeamento de Controllers
$controllers = [
    'dashboard' => 'DashboardController',
    'aluno' => 'AlunoController',
    'professor' => 'ProfessorController',
    'aula' => 'AulaController',
    'plano' => 'PlanoController',
    'filial' => 'FilialController',
    'produto' => 'ProdutoController',
    'avaliacao' => 'AvaliacaoController'
];

$controllerName = $controllers[$controller] ?? 'DashboardController';

if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die("Ação '{$action}' não encontrada no controller '{$controllerName}'");
    }
} else {
    die("Controller '{$controllerName}' não encontrado");
}
?>