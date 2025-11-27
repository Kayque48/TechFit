<?php
session_start();

// Validar acesso
if (!isset($_SESSION['aluno_id'])) {
    header('Location: loginCliente.php');
    exit;
}

// Buscar dados do aluno
require_once __DIR__ . '/../../controllers/AlunoController.php';
$controller = new AlunoController();
$aluno = $controller->buscarPorEmail($_SESSION['aluno_email']);

if (!$aluno) {
    // Se não encontrar, criar array com dados padrão
    $aluno = [
        'NOME_ALUNO' => $_SESSION['aluno_nome'] ?? 'Usuário',
        'IDADE' => 'N/A',
        'ENDERECO_ALUNO' => 'N/A',
        'TELEFONE' => 'N/A',
        'EMAIL' => $_SESSION['aluno_email'],
        'plano' => 'N/A'
    ];
}
?>

<div id="geral" class="hidden">
    <div class="content-header">
        <h1 class="page-title">Seu Perfil</h1>
        <p class="page-subtitle">Gerencie suas informações aqui</p>
    </div>

    <div class="product-form-container">
        <form id="productForm">
            <!-- Informações Básicas -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações Básicas
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="clientName">Nome:</label>
                        <p id="nome-cliente"><?php echo htmlspecialchars($aluno['NOME_ALUNO']); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="clientYear">Idade:</label>
                        <p id="idade-cliente"><?php echo htmlspecialchars($aluno['IDADE']); ?> anos</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="clientOld">Endereço:</label>
                        <p id="endereco-cliente"><?php echo htmlspecialchars($aluno['ENDERECO_ALUNO'] ?? 'Não informado'); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="clientPlan">Plano:</label>
                        <p id="plano-cliente"><?php echo htmlspecialchars($aluno['plano'] ?? 'Não informado'); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="clientPhone">Telefone:</label>
                        <p id="telefone-cliente"><?php echo htmlspecialchars($aluno['TELEFONE'] ?? 'Não informado'); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="clientEmail">Email:</label>
                        <p id="email-cliente"><?php echo htmlspecialchars($aluno['EMAIL']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Detalhes Exercícios -->
            <div class="exercise-details container px-4 py-5" id="custom-cards">
                <h3 class="section-title pb-2 border-bottom">
                    <i class="fas fa-dumbbell me-2"></i>
                    Detalhes dos Exercícios
                </h3>

                <div class="row justify-content-center text-center mb-4">
                    <?php
                    $dias = [
                        ['nome' => 'Segunda-feira', 'img' => 'https://plus.unsplash.com/premium_photo-1672862927484-cfc92dd88081?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Terça-feira',   'img' => 'https://plus.unsplash.com/premium_photo-1661630801762-b59faf22d543?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Quarta-feira',  'img' => 'https://images.unsplash.com/photo-1669989179344-3e84780dab7d?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Quinta-feira',  'img' => 'https://images.unsplash.com/photo-1605720789771-a7fb8ab19d04?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Sexta-feira',   'img' => 'https://images.unsplash.com/photo-1734458211458-4d508abf564e?q=80&w=627&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Sábado',        'img' => 'https://images.unsplash.com/photo-1609899517237-77d357b047cf?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['nome' => 'Domingo',       'img' => 'https://images.unsplash.com/photo-1581122584612-713f89daa8eb?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                    ];
                    foreach ($dias as $dia): ?>
                        <div class="col-6 col-md-4 col-lg-3 mb-4 d-flex flex-column align-items-center dia-semana"
                             onclick="atualizarTitulo('<?= $dia['nome'] ?>')"
                             role="button" style="cursor:pointer;">
                            <img src="<?= $dia['img'] ?>" alt="<?= $dia['nome'] ?>" class="rounded-circle shadow" width="100" height="100" style="object-fit:cover; background:#f8f9fa;">
                            <h5 class="fw-normal mt-3"><?= $dia['nome'] ?></h5>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>
                    <span id="titulo-treino">Treinos da Semana</span>
                </h3>

                <style>
                    .dia-semana.active-day { outline: 3px solid #0d6efd; border-radius: 12px; padding: 4px; }
                    .d-none { display: none !important; }
                </style>

                <script>
                    function atualizarTitulo(dia) {
                        const titulo = document.getElementById('titulo-treino');
                        titulo.textContent = 'Treinos de ' + dia;

                        document.querySelectorAll('.dia-semana').forEach(el => {
                            const text = el.querySelector('h5')?.textContent?.trim();
                            if (text === dia) el.classList.add('active-day'); else el.classList.remove('active-day');
                        });

                        document.querySelectorAll('.card-col').forEach(card => {
                            const cardDay = card.dataset.day;
                            if (cardDay === dia) card.classList.remove('d-none'); else card.classList.add('d-none');
                        });
                    }

                    function mostrarTodos() {
                        document.getElementById('titulo-treino').textContent = 'Treinos da Semana';
                        document.querySelectorAll('.dia-semana').forEach(el => el.classList.remove('active-day'));
                        document.querySelectorAll('.card-col').forEach(card => card.classList.remove('d-none'));
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        mostrarTodos();
                    });
                </script>

                <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                    <!-- Card 1 - Segunda -->
                    <div class="col card-col" data-day="Segunda-feira">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/abs.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">ABS</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://github.com/twbs.png" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>JORGE ARMADO</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>06:00 - 06:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 - Terça -->
                    <div class="col card-col" data-day="Terça-feira">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/peito.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Peito</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>MARIA SILVA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>07:00 - 07:45</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 - Quarta -->
                    <div class="col card-col" data-day="Quarta-feira">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/costas.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Costas</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>PAULO SOUZA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>08:00 - 08:50</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 - Quinta -->
                    <div class="col card-col" data-day="Quinta-feira">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/pernas.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Pernas</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>ANA LIMA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>09:00 - 09:50</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5 - Sexta -->
                    <div class="col card-col" data-day="Sexta-feira">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/biceps.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Bíceps</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/men/50.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>CARLOS MELO</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>10:00 - 10:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6 - Sábado -->
                    <div class="col card-col" data-day="Sábado">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/triceps.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Tríceps</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/women/55.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>FERNANDA DIAS</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>11:00 - 11:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 7 - Domingo -->
                    <div class="col card-col" data-day="Domingo">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('img/cards/stretching.jpg'); background-size:cover;">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h4 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Stretching</h4>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <img src="https://randomuser.me/api/portraits/women/60.jpg" alt="Instrutor" width="32" height="32" class="rounded-circle border border-white">
                                    </li>
                                    <li class="d-flex align-items-center me-3">
                                        <i class="fas fa-location-dot me-2"></i>
                                        <small>JULIANA COSTA</small>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <small>16:00 - 16:30</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
