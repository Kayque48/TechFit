<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Total de Alunos</h5>
                <h2><?php echo $stats['alunos']['total']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-check-circle"></i> Com Plano</h5>
                <h2><?php echo $stats['alunos']['com_plano']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> Filiais</h5>
                <h2><?php echo $stats['filiais']['total_filiais'] ?? 0; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Produtos</h5>
                <h2><?php echo $stats['produtos']['total']; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-pie-chart"></i> Distribuição de Planos</h5>
            </div>
            <div class="card-body">
                <canvas id="planosChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-bar-chart"></i> Classificação IMC</h5>
            </div>
            <div class="card-body">
                <canvas id="imcChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-graph-up"></i> Status de Alunos</h5>
            </div>
            <div class="card-body">
                <canvas id="alunosChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-boxes"></i> Status de Produtos</h5>
            </div>
            <div class="card-body">
                <canvas id="produtosChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Gráfico de Planos
const planosData = <?php echo json_encode($stats['planos']); ?>;
const planosCtx = document.getElementById('planosChart').getContext('2d');
new Chart(planosCtx, {
    type: 'pie',
    data: {
        labels: planosData.map(p => p.TIPO_PLANO || 'Sem nome'),
        datasets: [{
            data: planosData.map(p => p.total_alunos),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de IMC
const imcData = <?php echo json_encode($stats['imc']); ?>;
const imcCtx = document.getElementById('imcChart').getContext('2d');
new Chart(imcCtx, {
    type: 'bar',
    data: {
        labels: imcData.map(i => i.categoria),
        datasets: [{
            label: 'Quantidade',
            data: imcData.map(i => i.total),
            backgroundColor: 'rgba(75, 192, 192, 0.8)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Status de Alunos
const alunosCtx = document.getElementById('alunosChart').getContext('2d');
new Chart(alunosCtx, {
    type: 'doughnut',
    data: {
        labels: ['Com Plano', 'Sem Plano'],
        datasets: [{
            data: [
                <?php echo $stats['alunos']['com_plano']; ?>,
                <?php echo $stats['alunos']['sem_plano']; ?>
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de Produtos
const produtosCtx = document.getElementById('produtosChart').getContext('2d');
new Chart(produtosCtx, {
    type: 'bar',
    data: {
        labels: ['Total', 'Disponíveis', 'Estoque Total'],
        datasets: [{
            label: 'Quantidade',
            data: [
                <?php echo $stats['produtos']['total']; ?>,
                <?php echo $stats['produtos']['disponivel']; ?>,
                <?php echo $stats['produtos']['estoque_total']; ?>
            ],
            backgroundColor: 'rgba(0, 123, 255, 0.8)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

