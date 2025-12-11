<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-building"></i> Gerenciar Filiais</h2>
    <div>
        <a href="admin.php?controller=filial&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nova Filial
        </a>
        <a href="admin.php?controller=filial&action=exportCSV" class="btn btn-success">
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
                        <th>Endereço</th>
                        <th>Carga Máxima</th>
                        <th>Colaboradores</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($filiais)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma filial cadastrada</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($filiais as $filial): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($filial['ID_FILIAL']); ?></td>
                                <td><?php echo htmlspecialchars($filial['ENDERECO']); ?></td>
                                <td><?php echo htmlspecialchars($filial['CARGA_MAX']); ?></td>
                                <td><?php echo htmlspecialchars($filial['NUM_COLABORADORES']); ?></td>
                                <td><?php echo htmlspecialchars($filial['CEP']); ?></td>
                                <td>
                                    <a href="admin.php?controller=filial&action=update&id=<?php echo $filial['ID_FILIAL']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=filial&action=delete&id=<?php echo $filial['ID_FILIAL']; ?>" 
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

