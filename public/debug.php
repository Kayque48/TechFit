<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/controllers/AlunoController.php';

$controller = new AlunoController();

echo "<h2>Debug do Banco de Dados</h2>";

// Listar todos os usuários
$alunos = $controller->ler();

echo "<h3>Usuários cadastrados:</h3>";
if (!empty($alunos)) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Nome</th><th>Email</th><th>Senha</th><th>Telefone</th></tr>";
    foreach ($alunos as $aluno) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($id->getId()) . "</td>";
        echo "<td>" . htmlspecialchars($aluno->getNome()) . "</td>";
        echo "<td>" . htmlspecialchars($aluno->getEmail()) . "</td>";
        echo "<td>" . htmlspecialchars($aluno->getSenha() ?? 'VAZIO') . "</td>";
        echo "<td>" . htmlspecialchars($aluno->getTelefone() ?? 'VAZIO') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum usuário cadastrado!</p>";
}

// Teste de busca
echo "<h3>Teste de busca por email:</h3>";
$testEmail = 'fernando@gmail.com';
$resultado = $controller->buscarPorEmail($testEmail);
if ($resultado) {
    echo "<pre>" . print_r($resultado, true) . "</pre>";
} else {
    echo "Email não encontrado: " . $testEmail;
}
?>
