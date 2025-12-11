<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-event"></i> Gerenciar Aulas</h2>
    <div>
        <a href="admin.php?controller=aula&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nova Aula
        </a>
        <a href="admin.php?controller=aula&action=exportCSV" class="btn btn-success">
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
                        <th>Avaliação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($aulas)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma aula cadastrada</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($aulas as $aula): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aula['ID_AULA']); ?></td>
                                <td><?php echo htmlspecialchars($aula['NOME_AULA']); ?></td>
                                <td><?php echo htmlspecialchars($aula['AVALIACAO']); ?></td>
                                <td>
                                    <a href="admin.php?controller=aula&action=update&id=<?php echo $aula['ID_AULA']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=aula&action=delete&id=<?php echo $aula['ID_AULA']; ?>" 
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

