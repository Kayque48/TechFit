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
                        <div class="stat-label">Total de Planos</div>
                        <div class="stat-value"><?= $planoController->contar() ?></div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Plano com mais Alunos</div>
                        <div class="stat-value"></div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-label">Plano Com menos Alunos</div>
                        <div class="stat-value"><</div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Planos Ativos
                        </h3>

                        <div class="action-buttons">
                            <a href="planoCRUD.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Novo Plano
                            </a>

                            <a href="listaPlanos.php" class="btn btn-success">
                                <i class="fas fa-list me-2"></i> Ver Todos os Planos
                            </a>
                        </div>

                    </div>

                    <?php if (!empty($planos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Preço</th>
                                        <th>Quantidade de Alunos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($planos as $plano): ?>
                                        <tr>
                                            <td><?= $plano->getId() ?></td>
                                            <td><?= $plano->getTipoPlano() ?></td>
                                            <td><?= $plano->getDescricao() ?></td>
                                            <td><?= $plano->getPreco() ?></td>
                                            <td><?= $alunoController->contarPorPlano($plano->getId()) ?></td>
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
                                Você ainda não tem nenhum plano cadastrado.
                                <a href="PlanoCRUD.php" class="alert-link">Clique aqui para criar um</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
</body>
</html>