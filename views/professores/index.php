<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-person-badge"></i> Gerenciar Professores</h2>
    <div>
        <a href="admin.php?controller=professor&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Professor
        </a>
        <a href="admin.php?controller=professor&action=exportCSV" class="btn btn-success">
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
                        <th>CPF</th>
                        <th>Especialidade</th>
                        <th>Aulas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($professores)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum professor cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($professores as $prof): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prof['ID_PROFESSOR']); ?></td>
                                <td><?php echo htmlspecialchars($prof['NOME_PROFESSOR']); ?></td>
                                <td><?php echo htmlspecialchars($prof['CPF'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($prof['ESPECIALIDADE']); ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?php echo htmlspecialchars($prof['aulas'] ?? 'Nenhuma'); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin.php?controller=professor&action=update&id=<?php echo $prof['ID_PROFESSOR']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=professor&action=delete&id=<?php echo $prof['ID_PROFESSOR']; ?>" 
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

