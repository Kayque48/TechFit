<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-card-list"></i> Gerenciar Planos</h2>
    <div>
        <a href="admin.php?controller=plano&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Plano
        </a>
        <a href="admin.php?controller=plano&action=exportCSV" class="btn btn-success">
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
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($planos)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum plano cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($planos as $plano): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($plano['ID_PLANO']); ?></td>
                                <td><?php echo htmlspecialchars($plano['TIPO_PLANO']); ?></td>
                                <td><?php echo htmlspecialchars($plano['DESCRICAO']); ?></td>
                                <td>R$ <?php echo number_format($plano['PRECO'], 2, ',', '.'); ?></td>
                                <td>
                                    <a href="admin.php?controller=plano&action=update&id=<?php echo $plano['ID_PLANO']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=plano&action=delete&id=<?php echo $plano['ID_PLANO']; ?>" 
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

