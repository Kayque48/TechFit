<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Professor</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" 
                               value="<?php echo htmlspecialchars($professor['NOME_PROFESSOR'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" class="form-control" name="cpf" 
                               value="<?php echo htmlspecialchars($professor['CPF'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especialidade</label>
                        <input type="text" class="form-control" name="especialidade" 
                               value="<?php echo htmlspecialchars($professor['ESPECIALIDADE'] ?? ''); ?>" required>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=professor&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

