<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-clipboard-data"></i> Minhas Avaliações Físicas</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($avaliacoes)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Você ainda não possui avaliações físicas cadastradas.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Peso (kg)</th>
                            <th>Altura (m)</th>
                            <th>IMC</th>
                            <th>Gordura Corporal (%)</th>
                            <th>Massa Magra (kg)</th>
                            <th>TMB</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avaliacoes as $av): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($av['DATA_AVALIACAO'])); ?></td>
                                <td><?php echo $av['PESO']; ?></td>
                                <td><?php echo $av['ALTURA']; ?></td>
                                <td>
                                    <?php if ($av['IMC']): ?>
                                        <span class="badge bg-info"><?php echo number_format($av['IMC'], 2); ?></span>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $av['GORDURA_CORPORAL'] ?? 'N/A'; ?></td>
                                <td><?php echo $av['MASSA_MEGRA'] ?? 'N/A'; ?></td>
                                <td><?php echo $av['TMB'] ?? 'N/A'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

