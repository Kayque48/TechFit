<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Avaliação Física</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Aluno</label>
                            <select class="form-select" name="aluno" required>
                                <option value="">Selecione um aluno</option>
                                <?php foreach ($alunos as $aluno): ?>
                                    <option value="<?php echo $aluno['ID_ALUNO']; ?>"
                                        <?php echo ($avaliacao['FK_ALUNO'] ?? '') == $aluno['ID_ALUNO'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data da Avaliação</label>
                            <input type="date" class="form-control" name="data" 
                                   value="<?php echo htmlspecialchars($avaliacao['DATA_AVALIACAO'] ?? date('Y-m-d')); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="peso" 
                                   value="<?php echo htmlspecialchars($avaliacao['PESO'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Altura (m)</label>
                            <input type="number" step="0.01" class="form-control" name="altura" 
                                   value="<?php echo htmlspecialchars($avaliacao['ALTURA'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gordura Corporal (%)</label>
                            <input type="number" step="0.01" class="form-control" name="gordura" 
                                   value="<?php echo htmlspecialchars($avaliacao['GORDURA_CORPORAL'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Peitoral (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="peitoral" 
                                   value="<?php echo htmlspecialchars($avaliacao['PEITORAL'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Cintura (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="cintura" 
                                   value="<?php echo htmlspecialchars($avaliacao['CINTURA'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Quadril (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="quadril" 
                                   value="<?php echo htmlspecialchars($avaliacao['QUADRIL'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Coxa (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="coxa" 
                                   value="<?php echo htmlspecialchars($avaliacao['COXA'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Braço Esquerdo (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="braco_esquerdo" 
                                   value="<?php echo htmlspecialchars($avaliacao['BRAÇO_ESQUERDO'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Braço Direito (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="braco_direito" 
                                   value="<?php echo htmlspecialchars($avaliacao['BRAÇO_DIREITO'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Massa Magra (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="massa_magra" 
                                   value="<?php echo htmlspecialchars($avaliacao['MASSA_MEGRA'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">TMB (Taxa Metabólica Basal)</label>
                        <input type="number" step="0.01" class="form-control" name="tmb" 
                               value="<?php echo htmlspecialchars($avaliacao['TMB'] ?? ''); ?>">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=avaliacao&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

