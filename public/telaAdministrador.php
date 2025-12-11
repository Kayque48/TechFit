<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../src/controllers/Controller.php';
require_once __DIR__ . '/../src/controllers/DashboardController.php';
require_once __DIR__ . '/../src/controllers/AlunoController.php';
require_once __DIR__ . '/../src/controllers/ProfessorController.php';
require_once __DIR__ . '/../src/controllers/AulaController.php';
require_once __DIR__ . '/../src/controllers/PlanoController.php';
require_once __DIR__ . '/../src/controllers/FilialController.php';
require_once __DIR__ . '/../src/controllers/ProdutoController.php';
require_once __DIR__ . '/../src/controllers/AvaliacaoController.php';
require_once __DIR__ . '/../config/auth.php';



$auth = Auth::getInstance();
$action = $_GET['action'] ?? 'dashboard';
$controller = $_GET['controller'] ?? 'dashboard';


// // Verificar login do ADMIN
// if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
//     header("Location: loginAdm.php?erro=2");
//     exit;
// }

// if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
//     header("Location: loginAdm.php?erro=2");
//     exit;
// }

// if ($action === 'logout') {
//     session_destroy();
//     header('Location: index.php');
//     exit;
// }

// Se for login, mostrar página de login
if ($action === 'login' || $action === 'doLogin') {
    if ($action === 'doLogin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if ($auth->loginAdmin($usuario, $senha)) {
            header('Location: admin.php?controller=dashboard&action=index');
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

// Se não estiver logado e não for login/logout, redirecionar
if (!$auth->isAdmin() && $action !== 'login' && $action !== 'doLogin' && $action !== 'logout') {
    header('Location: admin.php?action=login');
    exit;
}

// Requer autenticação admin para outras ações (exceto login/logout)
if ($action !== 'login' && $action !== 'doLogin' && $action !== 'logout') {
    $auth->requireAdmin();
}

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