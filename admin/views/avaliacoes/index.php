<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-clipboard-data"></i> Gerenciar Avaliações Físicas</h2>
    <div>
        <a href="admin.php?controller=avaliacao&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nova Avaliação
        </a>
        <a href="admin.php?controller=avaliacao&action=exportCSV" class="btn btn-success">
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
                        <th>Data</th>
                        <th>Aluno</th>
                        <th>Peso</th>
                        <th>Altura</th>
                        <th>IMC</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($avaliacoes)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma avaliação cadastrada</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($avaliacoes as $av): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($av['ID_AVALIACAO']); ?></td>
                                <td><?php echo htmlspecialchars($av['DATA_AVALIACAO']); ?></td>
                                <td><?php echo htmlspecialchars($av['NOME_ALUNO'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($av['PESO']); ?> kg</td>
                                <td><?php echo htmlspecialchars($av['ALTURA']); ?> m</td>
                                <td>
                                    <?php if ($av['IMC']): ?>
                                        <span class="badge bg-info"><?php echo number_format($av['IMC'], 2); ?></span>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="admin.php?controller=avaliacao&action=update&id=<?php echo $av['ID_AVALIACAO']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="admin.php?controller=avaliacao&action=delete&id=<?php echo $av['ID_AVALIACAO']; ?>" 
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

