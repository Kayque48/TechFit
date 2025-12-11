<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Aluno</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" 
                               value="<?php echo htmlspecialchars($aluno['NOME_ALUNO'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" name="idade" 
                               value="<?php echo htmlspecialchars($aluno['IDADE'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco" 
                               value="<?php echo htmlspecialchars($aluno['ENDERECO_ALUNO'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="telefone" 
                               value="<?php echo htmlspecialchars($aluno['TELEFONE'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" 
                               value="<?php echo htmlspecialchars($aluno['EMAIL'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha (deixe em branco para manter)</label>
                        <input type="password" class="form-control" name="senha">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Plano</label>
                        <select class="form-select" name="plano">
                            <option value="">Sem plano</option>
                            <?php foreach ($planos as $plano): ?>
                                <option value="<?php echo $plano['ID_PLANO']; ?>"
                                    <?php echo ($aluno['FK_PLANO'] == $plano['ID_PLANO']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($plano['TIPO_PLANO']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=aluno&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

