<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-card-list"></i> Novo Plano</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Plano</label>
                            <input type="text" class="form-control" name="tipo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control" name="preco" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Máquinas</label>
                            <input type="text" class="form-control" name="maquinas" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Aulas em Grupo</label>
                            <input type="text" class="form-control" name="aulas_grupo" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Treinamento</label>
                            <input type="text" class="form-control" name="treinamento" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Consultoria</label>
                            <input type="text" class="form-control" name="consultoria" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Avaliação</label>
                            <input type="text" class="form-control" name="t_avaliacao" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Horário de Acesso</label>
                            <input type="text" class="form-control" name="h_acesso" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?controller=plano&action=index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

