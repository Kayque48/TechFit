<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Gerenciar Produtos</h2>
    <div>
        <a href="admin.php?controller=produto&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Produto
        </a>
        <a href="admin.php?controller=produto&action=exportCSV" class="btn btn-success">
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
                        <th>Quantidade</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum produto cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($produto['ID_PRODUTO']); ?></td>
                                <td><?php echo htmlspecialchars($produto['NOME_PRODUTO']); ?></td>
                                <td><?php echo htmlspecialchars($produto['QUANTIDADE']); ?></td>
                                <td>
                                    <span class="badge <?php echo $produto['PSTATUS'] == 'DISPONÍVEL' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo htmlspecialchars($produto['PSTATUS']); ?>
                                    </span>
                                </td>
                                <td>R$ <?php echo number_format($produto['PRECO'] ?? 0, 2, ',', '.'); ?></td>
                                <td>
                                    <a href="admin.php?controller=produto&action=update&id=<?php echo $produto['ID_PRODUTO']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=produto&action=delete&id=<?php echo $produto['ID_PRODUTO']; ?>" 
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

