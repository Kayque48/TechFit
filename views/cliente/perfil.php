<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-person"></i> Meu Perfil</h4>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Perfil atualizado com sucesso!
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" 
                               value="<?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($aluno['EMAIL']); ?>" disabled>
                        <small class="text-muted">O email não pode ser alterado</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="telefone" 
                               value="<?php echo htmlspecialchars($aluno['TELEFONE'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco" 
                               value="<?php echo htmlspecialchars($aluno['ENDERECO_ALUNO']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($aluno['IDADE']); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha (deixe em branco para manter)</label>
                        <input type="password" class="form-control" name="senha">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

