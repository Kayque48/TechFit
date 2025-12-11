<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Filial</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco" 
                               value="<?php echo htmlspecialchars($filial['ENDERECO'] ?? ''); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Carga Máxima</label>
                            <input type="number" class="form-control" name="carga_max" 
                                   value="<?php echo htmlspecialchars($filial['CARGA_MAX'] ?? 50); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número de Colaboradores</label>
                            <input type="number" class="form-control" name="num_colaboradores" 
                                   value="<?php echo htmlspecialchars($filial['NUM_COLABORADORES'] ?? 0); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CEP</label>
                        <input type="text" class="form-control" name="cep" 
                               value="<?php echo htmlspecialchars($filial['CEP'] ?? ''); ?>" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=filial&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

