<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
                <!-- Cards Resumo -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-label">Total de Alunos</div>
                        <div class="stat-value"><?= $alunoController->contar() ?></div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Último Acesso ao Site</div>
                        <div class="stat-value">40</div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-label">Último Acesso ao Academia</div>
                        <div class="stat-value">8</div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Alunos Cadastrados
                        </h3>

                        <div class="action-buttons">
                            <a href="cadastroCliente.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Novo Aluno
                            </a>

                            <a href="listaAlunos.php" class="btn btn-success">
                                <i class="fas fa-list me-2"></i> Ver Todos os Alunos
                            </a>
                        </div>

                    </div>

                    <?php if (!empty($alunos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th>Data de Nascimento</th>
                                        <th>Endereço</th>
                                        <th>Plano</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($alunos as $aluno): ?>
                                        <tr>
                                            <td><?= $aluno->getId() ?></td>
                                            <td><?= $aluno->getNome() ?></td>
                                            <td><?= $aluno->getTelefone() ?></td>
                                            <td><?= $aluno->getEmail() ?></td>
                                            <td><?= $aluno->getDataNasc() ?></td>
                                            <td><?= $aluno->getEndereco() ?></td>
                                            <td><?= $aluno->getPlano() ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Sem dados registrados</strong>
                            <p>
                                Você ainda não tem nenhum aluno cadastrado.
                                <a href="cadastrarAluno.php" class="alert-link">Clique aqui para criar um</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
</body>
</html>