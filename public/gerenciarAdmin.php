<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se o admin está logado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: loginAdm.php?erro=2');
    exit;
}

require_once __DIR__ . '/../src/controllers/AdministradorController.php';
$controller = new AdministradorController();

$Admin = ['USER' => $_SESSION['usuario']];

$mensagem = '';
$tipoMensagem = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';

    // CRIAR NOVO ADMIN
    if ($acao == 'criar') {
        $usuario = trim($_POST['usuario'] ?? '');
        $senha = trim($_POST['senha'] ?? '');
        $confirmarSenha = trim($_POST['confirmar_senha'] ?? '');

        if (empty($usuario) || empty($senha)) {
            $mensagem = 'Preencha todos os campos obrigatórios';
            $tipoMensagem = 'erro';
        } elseif ($senha !== $confirmarSenha) {
            $mensagem = 'As senhas não correspondem';
            $tipoMensagem = 'erro';
        } elseif (strlen($senha) < 6) {
            $mensagem = 'A senha deve ter no mínimo 6 caracteres';
            $tipoMensagem = 'erro';
        } else {
            try {
                // Verificar se usuário já existe
                $existe = $controller->buscarPorUsuario($usuario);
                if ($existe) {
                    $mensagem = 'Este usuário já está cadastrado';
                    $tipoMensagem = 'erro';
                } else {
                    $controller->criar($usuario, $senha);
                    $mensagem = 'Administrador cadastrado com sucesso!';
                    $tipoMensagem = 'sucesso';
                }
            } catch (Exception $e) {
                $mensagem = 'Erro ao cadastrar: ' . $e->getMessage();
                $tipoMensagem = 'erro';
            }
        }
    }

    // ALTERAR SENHA
    if ($acao == 'alterar_senha') {
        $senhaAtual = trim($_POST['senha_atual'] ?? '');
        $novaSenha = trim($_POST['nova_senha'] ?? '');
        $confirmarNovaSenha = trim($_POST['confirmar_nova_senha'] ?? '');

        if (empty($senhaAtual) || empty($novaSenha)) {
            $mensagem = 'Preencha todos os campos obrigatórios';
            $tipoMensagem = 'erro';
        } elseif ($novaSenha !== $confirmarNovaSenha) {
            $mensagem = 'As novas senhas não correspondem';
            $tipoMensagem = 'erro';
        } elseif (strlen($novaSenha) < 6) {
            $mensagem = 'A nova senha deve ter no mínimo 6 caracteres';
            $tipoMensagem = 'erro';
        } else {
            try {
                // Verificar senha atual
                $adminAtual = $controller->buscarPorUsuario($Admin['USER']);
                if ($adminAtual && $adminAtual->getSenha() === $senhaAtual) {
                    $controller->atualizar($adminAtual->getId(), $Admin['USER'], $novaSenha);
                    $mensagem = 'Senha alterada com sucesso!';
                    $tipoMensagem = 'sucesso';
                } else {
                    $mensagem = 'Senha atual incorreta';
                    $tipoMensagem = 'erro';
                }
            } catch (Exception $e) {
                $mensagem = 'Erro ao alterar senha: ' . $e->getMessage();
                $tipoMensagem = 'erro';
            }
        }
    }

    // EXCLUIR ADMIN
    if ($acao == 'deletar' && isset($_POST['idAdmin'])) {
        try {
            // Não permitir excluir a si mesmo
            $adminParaDeletar = $controller->getDAO()->lerAdministradores();
            $idAtual = null;
            foreach ($adminParaDeletar as $adm) {
                if ($adm->getUser() === $Admin['USER']) {
                    $idAtual = $adm->getId();
                    break;
                }
            }
            
            if ($idAtual == $_POST['idAdmin']) {
                $mensagem = 'Você não pode excluir sua própria conta!';
                $tipoMensagem = 'erro';
            } else {
                $controller->excluir($_POST['idAdmin']);
                $mensagem = 'Administrador excluído com sucesso!';
                $tipoMensagem = 'sucesso';
            }
        } catch (Exception $e) {
            $mensagem = 'Erro ao excluir: ' . $e->getMessage();
            $tipoMensagem = 'erro';
        }
    }
}

$administradores = $controller->ler();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Administradores - TechFit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --verde-escuro: #1E5332;
            --verde-claro: #68A842;
            --amarelo: #FBC70B;
            --laranja: #E95D29;
            --azul: #0093D1;
            --roxo: #6f42c1;
            --gray-light: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, var(--gray-light) 0%, #e8f4f8 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .techfit-header {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, #2a7a4a 100%);
            color: white;
            padding: 1.25rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 1.6rem;
            gap: 1rem;
        }

        .logo-icon {
            background: var(--amarelo);
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--verde-escuro);
            font-size: 1.5rem;
        }

        .admin-name {
            color: var(--amarelo);
            font-weight: 700;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .alert-custom {
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-sucesso {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .alert-erro {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        .section-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin: 2rem auto;
            max-width: 1200px;
        }

        .section-title {
            color: var(--verde-escuro);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--laranja);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--verde-escuro);
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--azul);
            box-shadow: 0 0 0 0.2rem rgba(0, 147, 209, 0.15);
        }

        .btn-custom {
            padding: 0.85rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-laranja {
            background: linear-gradient(135deg, var(--laranja), #d35400);
            color: white;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .table-custom {
            width: 100%;
        }

        .table-custom thead {
            background: var(--gray-light);
        }

        .table-custom thead th {
            padding: 1.25rem 1rem;
            font-weight: 700;
            color: var(--verde-escuro);
            border-bottom: 3px solid var(--laranja);
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table-custom tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table-custom tbody tr:hover {
            background: rgba(233, 93, 41, 0.05);
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--laranja), #d35400);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-action {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #bd2130);
            color: white;
        }

        .info-box {
            background: rgba(233, 93, 41, 0.1);
            border-left: 4px solid var(--laranja);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .password-strength {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
        }

        .strength-weak { width: 33%; background: #dc3545; }
        .strength-medium { width: 66%; background: #ffc107; }
        .strength-strong { width: 100%; background: #28a745; }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="techfit-header">
        <div class="header-container">
            <a href="telaAdministrador.php" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <span>TechFit Admin</span>
            </a>

            <div class="user-info">
                <?php
                $nomeCompleto = $Admin['USER'] ?? '';
                $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                ?>
                <span class="admin-greeting">
                    Olá, <span class="admin-name"><?= htmlspecialchars($primeiroNome) ?></span>
                </span>
                <a class="btn-logout" href="telaAdministrador.php?action=logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Sair
                </a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="mt-4 mb-4">
            <a href="telaAdministrador.php" class="text-decoration-none d-flex align-items-center"
                style="color: var(--verde-escuro); font-weight: 600;">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar
            </a>
        </div>

        <?php if ($mensagem): ?>
            <div class="alert-custom alert-<?= $tipoMensagem ?>">
                <i class="fas fa-<?= $tipoMensagem === 'sucesso' ? 'check-circle' : 'exclamation-circle' ?> fa-lg"></i>
                <span><?= htmlspecialchars($mensagem) ?></span>
            </div>
        <?php endif; ?>

        <!-- Seção: Alterar Senha -->
        <div class="section-card">
            <h3 class="section-title">
                <i class="fas fa-key"></i>
                Alterar Minha Senha
            </h3>

            <div class="info-box">
                <p style="margin: 0; color: #721c24;">
                    <i class="fas fa-info-circle me-2"></i>
                    Use uma senha forte com pelo menos 6 caracteres.
                </p>
            </div>

            <form action="" method="post">
                <input type="hidden" name="acao" value="alterar_senha">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Senha Atual *</label>
                        <input type="password" class="form-control" name="senha_atual" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nova Senha *</label>
                        <input type="password" class="form-control" name="nova_senha" id="novaSenha" required>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        <small class="text-muted" id="strengthText"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmar Nova Senha *</label>
                        <input type="password" class="form-control" name="confirmar_nova_senha" required>
                    </div>
                </div>

                <button type="submit" class="btn-custom btn-laranja">
                    <i class="fas fa-save"></i>
                    Alterar Senha
                </button>
            </form>
        </div>

        <!-- Seção: Cadastrar Novo Admin -->
        <div class="section-card">
            <h3 class="section-title">
                <i class="fas fa-user-plus"></i>
                Cadastrar Novo Administrador
            </h3>

            <form action="" method="post">
                <input type="hidden" name="acao" value="criar">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Usuário *</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Nome de usuário" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Senha *</label>
                        <input type="password" class="form-control" name="senha" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmar Senha *</label>
                        <input type="password" class="form-control" name="confirmar_senha" required>
                    </div>
                </div>

                <button type="submit" class="btn-custom btn-laranja">
                    <i class="fas fa-user-plus"></i>
                    Cadastrar Administrador
                </button>
            </form>
        </div>

        <!-- Seção: Lista de Admins -->
        <div class="section-card">
            <h3 class="section-title">
                <i class="fas fa-users-cog"></i>
                Administradores Cadastrados
            </h3>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($administradores as $adm): ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($adm->getId()) ?></strong></td>
                                <td><?= htmlspecialchars($adm->getUser()) ?></td>
                                <td>
                                    <?php if ($adm->getUser() === $Admin['USER']): ?>
                                        <span class="badge-admin">
                                            <i class="fas fa-crown me-1"></i> Você
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Administrador</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($adm->getUser() !== $Admin['USER']): ?>
                                        <button
                                            type="button"
                                            class="btn-action btn-delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $adm->getId() ?>">
                                            <i class="fas fa-trash"></i> Excluir
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal<?= $adm->getId() ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                Confirmar Exclusão
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir o administrador <strong><?= htmlspecialchars($adm->getUser()) ?></strong>?</p>
                                            <p class="text-muted">Esta ação não pode ser desfeita.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="" method="post" style="display:inline;">
                                                <input type="hidden" name="acao" value="deletar">
                                                <input type="hidden" name="idAdmin" value="<?= $adm->getId() ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash me-2"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Indicador de força da senha
        const novaSenha = document.getElementById('novaSenha');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        if (novaSenha) {
            novaSenha.addEventListener('input', function() {
                const senha = this.value;
                let strength = 0;

                if (senha.length >= 6) strength++;
                if (senha.length >= 10) strength++;
                if (/[a-z]/.test(senha) && /[A-Z]/.test(senha)) strength++;
                if (/\d/.test(senha)) strength++;
                if (/[^a-zA-Z0-9]/.test(senha)) strength++;

                strengthBar.className = 'password-strength-bar';
                
                if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = 'Senha fraca';
                    strengthText.style.color = '#dc3545';
                } else if (strength <= 4) {
                    strengthBar.classList.add('strength-medium');
                    strengthText.textContent = 'Senha média';
                    strengthText.style.color = '#ffc107';
                } else {
                    strengthBar.classList.add('strength-strong');
                    strengthText.textContent = 'Senha forte';
                    strengthText.style.color = '#28a745';
                }
            });
        }
    </script>
</body>
</html>