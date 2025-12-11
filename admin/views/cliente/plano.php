<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-card-list"></i> Meu Plano</h2>
    </div>
</div>

<?php if ($plano): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4><i class="bi bi-star-fill"></i> Plano Atual: <?php echo htmlspecialchars($plano['TIPO_PLANO']); ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Descrição</h5>
                    <p><?php echo htmlspecialchars($plano['DESCRICAO']); ?></p>
                    
                    <h5 class="mt-4">Benefícios Incluídos</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Máquinas: <?php echo htmlspecialchars($plano['MAQUINAS']); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Aulas em Grupo: <?php echo htmlspecialchars($plano['AULAS_GRUPO']); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Treinamento: <?php echo htmlspecialchars($plano['TREINAMENTO']); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Consultoria: <?php echo htmlspecialchars($plano['CONSULTORIA']); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Tipo de Avaliação: <?php echo htmlspecialchars($plano['T_AVALIACAO']); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle text-success"></i> 
                            Horário de Acesso: <?php echo htmlspecialchars($plano['H_ACESSO']); ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-primary">R$ <?php echo number_format($plano['PRECO'], 2, ',', '.'); ?></h3>
                            <p class="text-muted">Valor do Plano</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> Você não possui um plano ativo no momento.
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5><i class="bi bi-list"></i> Planos Disponíveis</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach ($planosDisponiveis as $planoDisponivel): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5><?php echo htmlspecialchars($planoDisponivel['TIPO_PLANO']); ?></h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo htmlspecialchars($planoDisponivel['DESCRICAO']); ?></p>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check"></i> <?php echo htmlspecialchars($planoDisponivel['MAQUINAS']); ?></li>
                                <li><i class="bi bi-check"></i> <?php echo htmlspecialchars($planoDisponivel['AULAS_GRUPO']); ?></li>
                                <li><i class="bi bi-check"></i> <?php echo htmlspecialchars($planoDisponivel['TREINAMENTO']); ?></li>
                            </ul>
                            <h4 class="text-center text-primary">R$ <?php echo number_format($planoDisponivel['PRECO'], 2, ',', '.'); ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

