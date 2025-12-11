<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Gerenciar Alunos</h2>
    <div>
        <a href="admin.php?controller=aluno&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Aluno
        </a>
        <a href="admin.php?controller=aluno&action=exportCSV" class="btn btn-success">
            <i class="bi bi-file-earmark-spreadsheet"></i> Exportar CSV
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Plano</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alunos)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum aluno cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno['ID_ALUNO']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['IDADE']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['EMAIL']); ?></td>
                                <td><?php echo htmlspecialchars($aluno['TELEFONE'] ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo htmlspecialchars($aluno['TIPO_PLANO'] ?? 'Sem plano'); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin.php?controller=aluno&action=update&id=<?php echo $aluno['ID_ALUNO']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=aluno&action=delete&id=<?php echo $aluno['ID_ALUNO']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Tem certeza que deseja excluir?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

