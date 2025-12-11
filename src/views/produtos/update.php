<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Produto</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" name="nome" 
                               value="<?php echo htmlspecialchars($produto['NOME_PRODUTO'] ?? ''); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" class="form-control" name="quantidade" 
                                   value="<?php echo htmlspecialchars($produto['QUANTIDADE'] ?? 20); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="DISPONÍVEL" <?php echo ($produto['PSTATUS'] ?? '') == 'DISPONÍVEL' ? 'selected' : ''; ?>>Disponível</option>
                                <option value="INDISPONÍVEL" <?php echo ($produto['PSTATUS'] ?? '') == 'INDISPONÍVEL' ? 'selected' : ''; ?>>Indisponível</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preço</label>
                        <input type="number" step="0.01" class="form-control" name="preco" 
                               value="<?php echo htmlspecialchars($produto['PRECO'] ?? 0); ?>" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=produto&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

