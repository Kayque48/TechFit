<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* GRID */
        .tables-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
            align-items: start;
        }

        /* CARDS */
        .table-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .table-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* TAMANHOS */
        .table-card-lg {
            width: 100%;
        }

        .table-card-sm {
            max-width: 520px;
            justify-self: start;
        }

        /* HEADER DOS CARDS */
        .table-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .table-card-header h5 {
            margin: 0;
            font-weight: 700;
            color: #1E5332;
        }

        /* BOTÕES TECHFIT */
        .btn-techfit {
            background: linear-gradient(135deg, #68A842, #1E5332);
            color: #fff;
            border-radius: 10px;
            padding: 0.45rem 1rem;
            font-weight: 600;
            border: none;
        }

        .btn-techfit:hover {
            background: #1E5332;
            color: #fff;
        }

        .btn-techfit-outline {
            border: 2px solid #68A842;
            color: #68A842;
            border-radius: 10px;
            padding: 0.4rem 0.7rem;
        }

        .btn-techfit-outline:hover {
            background: #68A842;
            color: #fff;
        }

        /* TABELAS */
        .table th {
            font-weight: 600;
            color: #495057;
        }

        .table td {
            vertical-align: middle;
        }

        /* RESPONSIVO */
        @media (max-width: 992px) {
            .tables-grid {
                grid-template-columns: 1fr;
            }

            .table-card-sm {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Cards Resumo -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total de Colaboradores</div>
            <div class="stat-value"><?= $adminController->contar() + $professorController->contar() ?></div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-label">Total Administradores</div>
            <div class="stat-value"><?= $adminController->contar() ?></div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-label">Total Professores</div>
            <div class="stat-value"><?= $professorController->contar() ?></div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-label">Especialidade Com Mais Professores</div>
            <div class="stat-value"><?= $professorController->especialidadeComMaisProfessores() ?></div>
        </div>

        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-label">Especialidade Com Menos Professores</div>
            <div class="stat-value"><?= $professorController->especialidadeComMenosProfessores() ?></div>
        </div>

    </div>

    <!-- Tabela -->
    <div class="tables-grid">

        <!-- CARD PROFESSORES -->
        <div class="table-card table-card-lg">
            <div class="table-card-header">
                <h5>
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Professores
                </h5>

                <div class="table-card-header" style="gap: 0.5rem;">
                    <a href="cadastroProfessor.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Novo Professor
                    </a>

                    <a href="listaProfessores.php" class="btn btn-success">
                        <i class="fas fa-list me-2"></i> Ver Todas os Professores
                    </a>
                </div>

                </div>

                <?php if (!empty($professores)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Especialidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($professores as $professor): ?>
                                    <tr>
                                        <td><?= $professor->getId() ?></td>
                                        <td><?= $professor->getNomeProfessor() ?></td>
                                        <td><?= $professor->getCPF() ?></td>
                                        <td><?= $professor->getEspecialidade() ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Nenhum professor cadastrado
                    </div>
                <?php endif; ?>
            </div>

            <!-- CARD ADMINS -->
            <div class="table-card table-card-sm">
                <div class="table-card-header">
                    <h5>
                        <i class="fas fa-user-shield me-2"></i>
                        Administradores
                    </h5>

                    <a href="GerenciarAdmin.php" class="btn btn-techfit-outline">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($administradores as $admin): ?>
                                <tr>
                                    <td><?= $admin->getId() ?></td>
                                    <td><?= $admin->getUser() ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


</body>

</html>