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
                        <div class="stat-label">Total de Aulas</div>
                        <div class="stat-value"><?= $aulaController->contar()?></div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Tipo de Aula Com Mais Alunos</div>
                        <div class="stat-value"><?= $aulaController->tipoComMaisAulas() ?></div>
                    </div>

                    <div class="stat-card danger">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-label">Tipo de Aula Com Menos Alunos</div>
                        <div class="stat-value"><?= $aulaController->tipoComMenosAulas() ?></div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="content-card">
                    <div class="content-card-header d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Aulas Cadastrados
                        </h3>

                        <div class="action-buttons">
                            <a href="cadastroAula.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Novo Aula
                            </a>

                            <a href="listaAulas.php" class="btn btn-success">
                                <i class="fas fa-list me-2"></i> Ver Todos os Aulas
                            </a>
                        </div>

                    </div>

                    <?php if (!empty($aulas)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Duração</th>
                                        <th>Data</th>
                                        <th>Professor</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($aulas as $aula): ?>
                                        <tr>
                                            <td><?= $aula->getId() ?></td>
                                            <td><?= $aula->getNomeAula() ?></td>
                                            <td><?= $aula->getTipo() ?></td>
                                            <td><?= $aula->getTempo() ?></td>
                                            <td><?= $aula->getData() ?></td>
                                            <td><?= $aulaController->nomeProfessor($aula->getProfessor()) ?></td>
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
                                Você ainda não tem nenhuma aula registrada.
                                <a href="cadastroAula.php" class="alert-link">Clique aqui para criar uma</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
</body>
</html>