<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Bem-vindo, <?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?>!</h2>
        <p class="text-muted">Acompanhe suas informações e progresso</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-card-list"></i> Plano Atual</h5>
                <h3><?php echo $plano ? htmlspecialchars($plano['TIPO_PLANO']) : 'Sem plano'; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-clipboard-check"></i> Avaliações</h5>
                <h3><?php echo count($avaliacoes); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-envelope"></i> Email</h5>
                <h6><?php echo htmlspecialchars($aluno['EMAIL']); ?></h6>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($avaliacoes)): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-graph-up"></i> Evolução do IMC</h5>
            </div>
            <div class="card-body">
                <canvas id="imcChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-list-ul"></i> Últimas Avaliações</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Peso</th>
                                <th>Altura</th>
                                <th>IMC</th>
                                <th>Gordura Corporal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($avaliacoes, 0, 5) as $av): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($av['DATA_AVALIACAO'])); ?></td>
                                    <td><?php echo $av['PESO']; ?> kg</td>
                                    <td><?php echo $av['ALTURA']; ?> m</td>
                                    <td>
                                        <?php if ($av['IMC']): ?>
                                            <span class="badge bg-info"><?php echo number_format($av['IMC'], 2); ?></span>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $av['GORDURA_CORPORAL'] ?? 'N/A'; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gráfico de IMC
const avaliacoes = <?php echo json_encode(array_values($avaliacoes)); ?>;
const imcCtx = document.getElementById('imcChart').getContext('2d');
new Chart(imcCtx, {
    type: 'line',
    data: {
        labels: avaliacoes.map(a => new Date(a.DATA_AVALIACAO).toLocaleDateString('pt-BR')),
        datasets: [{
            label: 'IMC',
            data: avaliacoes.map(a => a.IMC || null).filter(v => v !== null),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

