<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleCadProduto.css">
    <link rel="stylesheet" href="css/hidden.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/ajuste.css">
    <link rel="stylesheet" href="css/secTreino.css">
    <link rel="stylesheet" href="css/secPlano.css">
    <link rel="stylesheet" href="css/secConfig.css">
    <title> Perfil - TechFit</title>

</head>
<body>
    <!-- Header -->
    <?php
        require_once '../src/views/headerUser.php'
    ?>

    <!-- Layout Principal -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php
        require_once '../src/views/sidebars.php';
        ?>

        <!-- Sessão Visão Geral -->
        <main class="main-content">
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
                                    <p id="nome-cliente">Nome do Cliente</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientYear">Idade:</label>
                                    <p id="idade-cliente">Idade</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientOld">Membro desde:</label>
                                    <p id="membro-cliente">Data de assinatura</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="clientPlan">Plano:</label>
                                    <p id="Plano-cliente">Tipo do Plano do Cliente</p>
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
                                /* pequeno destaque para o dia selecionado */
                                .dia-semana.active-day { outline: 3px solid #0d6efd; border-radius: 12px; padding: 4px; }
                                .d-none { display: none !important; }
                            </style>

                            <script>
                                function atualizarTitulo(dia) {
                                    const titulo = document.getElementById('titulo-treino');
                                    titulo.textContent = 'Treinos de ' + dia;

                                    // destacar dia selecionado
                                    document.querySelectorAll('.dia-semana').forEach(el => {
                                        const text = el.querySelector('h5')?.textContent?.trim();
                                        if (text === dia) el.classList.add('active-day'); else el.classList.remove('active-day');
                                    });

                                    // mostrar apenas cards do dia selecionado
                                    document.querySelectorAll('.card-col').forEach(card => {
                                        const cardDay = card.dataset.day;
                                        if (cardDay === dia) card.classList.remove('d-none'); else card.classList.add('d-none');
                                    });
                                }

                                // função para resetar visualização (mostrar todos)
                                function mostrarTodos() {
                                    document.getElementById('titulo-treino').textContent = 'Treinos da Semana';
                                    document.querySelectorAll('.dia-semana').forEach(el => el.classList.remove('active-day'));
                                    document.querySelectorAll('.card-col').forEach(card => card.classList.remove('d-none'));
                                }

                                // inicializar mostrando todos
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

                                <!-- Additional cards can be added here with data-day="Nome do Dia" -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Seção Plano -->
            <section id="plano" class="plans container py-5 hidden">
                <div class="container py-3">
                    <div class="content-header">
                        <h1 class="page-title">Nossos Planos</h1>
                        <p class="page-subtitle">Escolha o plano que melhor se adapta a você</p>
                    </div>

                    <div class="product-form-container">
                        <div class="pricing-header text-center">
                            <h1 class="display-4 fw-normal text-body-emphasis">Planos de Academia</h1>
                            <p class="fs-5 text-body-secondary">
                            Encontre o plano ideal para alcançar seus objetivos de fitness com nossa variedade de opções.
                            </p>
                        </div>
                    

                        <main class="planos-container">
                            <div class="card" data-plano="Básico">
                                <h4>Plano Básico</h4>
                                <h1>$20 <small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul>
                                    <li>Acesso a todas as máquinas</li>
                                    <li>1 aula de grupo por semana</li>
                                    <li>Suporte online</li>
                                </ul>
                                <butto class="abrirModal btn-inscrever">Inscreva-se</button>
                            </div>

                            <div class="card" data-plano="Intermediário">
                                <h4>Plano Intermediário</h4>
                                <h1>$35 <small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul>
                                    <li>Acesso ilimitado</li>
                                    <li>3 aulas por semana</li>
                                    <li>Acompanhamento com personal</li>
                                </ul>
                                <button class="abrirModal btn-inscrever">Inscreva-se</button>
                            </div>

                            <div class="card" data-plano="Premium">
                                <h4>Plano Premium</h4>
                                <h1>$50 <small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul>
                                    <li>Acesso 24h</li>
                                    <li>Aulas ilimitadas</li>
                                    <li>Consultoria nutricional</li>
                                    <li>Treinamento pessoal ilimitado</li>
                                </ul>
                                <button class="abrirModal btn-inscrever">Inscreva-se</button>
                            </div>
                        </main>
                    </div>

                    <!-- Modal -->
                    <div id="modalPlano" class="modal hidden">
                        <div class="modal-content">
                            <span id="fecharModal" class="fechar">&times;</span>
                            <h2 id="modalTitulo">Inscrição</h2>
                            <form id="formPlano">
                                <input type="text" placeholder="Nome completo" required>
                                <input type="email" placeholder="Email" required>
                                <input type="password" placeholder="Senha" required>
                                <button type="submit">Confirmar Inscrição</button>
                            </form>
                        </div>
                    </div>


                   <div class="product-form-container">             
                        <h2 class="display-6 text-center mb-4">Compare os planos</h2>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 34%;"></th>
                                        <th style="width: 22%;">Básico</th>
                                        <th style="width: 22%;">Avançado</th>
                                        <th style="width: 22%;">Premium</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-start">Acesso a máquinas</th>
                                        <td>Limitado</td>
                                        <td>Total</td>
                                        <td>Total 24/7</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-start">Aulas de grupo</th>
                                        <td>1 por semana</td>
                                        <td>3 por semana</td>
                                        <td>Ilimitadas</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-start">Treinamento personalizado</th>
                                        <td>Não incluso</td>
                                        <td>2x por mês</td>
                                        <td>Ilimitado</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-start">Consultoria nutricional</th>
                                        <td>Não incluso</td>
                                        <td>1x por mês</td>
                                        <td>Quinzenal</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-start">Avaliação física</th>
                                        <td>Trimestral</td>
                                        <td>Bimestral</td>
                                        <td>Mensal</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-start">Horário de acesso</th>
                                        <td>Comercial</td>
                                        <td>Estendido</td>
                                        <td>24 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>
            

            <!-- ===================== SEÇÃO TREINO ===================== -->
            <div id="treino" class="hidden">

                <div class="content-header">
                    <h1 class="page-title">Histórico de Treinos</h1>
                    <p class="page-subtitle">Consulte os treinos realizados e o total de horas treinadas</p>
                </div>

            <div class="product-form-container">

                <!-- Busca -->
                <div class="form-section">
                    <h2 class="section-title">Buscar Treinos</h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Pesquisar por nome do treino</label>
                            <input type="text" class="form-control-custom" placeholder="Ex: Peito, Costas, Pernas...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Filtrar por data</label>
                            <input type="date" class="form-control-custom">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Filtrar por duração</label>
                            <select class="form-control-custom">
                                <option value="">Selecione</option>
                                <option>Menos de 30 min</option>
                                <option>30 min - 1h</option>
                                <option>1h - 2h</option>
                                <option>Mais de 2h</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Histórico -->
                <div class="form-section">
                    <h2 class="section-title">Treinos Realizados</h2>

                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Treino</th>
                                    <th>Duração</th>
                                    <th>Calorias</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id="tabela-treinos">
                                <tr>
                                    <td>20/11/2025</td>
                                    <td>Peito e Tríceps</td>
                                    <td>01:12h</td>
                                    <td>430 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                                <tr>
                                    <td>18/11/2025</td>
                                    <td>Pernas e Ombros</td>
                                    <td>01:45h</td>
                                    <td>520 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                                <tr>
                                    <td>16/11/2025</td>
                                    <td>Costas e Bíceps</td>
                                    <td>00:58h</td>
                                    <td>390 kcal</td>
                                    <td><button class="btn-techfit btn-primary">Ver</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="form-section">
                    <h2 class="section-title">Estatísticas Gerais</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">Total de treinos realizados</label>
                            <input type="text" class="form-control-custom" value="34 treinos" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Total de horas treinadas</label>
                            <input type="text" class="form-control-custom" value="41h e 22min" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Média semanal</label>
                            <input type="text" class="form-control-custom" value="4 treinos/semana" disabled>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
         <!-- ===================== SEÇÃO FICHA ===================== -->
        <div id="ficha" class="hidden">

            <div class="content-header">
                <h1 class="page-title">Ficha de Avaliação Física</h1>
                <p class="page-subtitle">Acompanhe suas medidas, evolução e composição corporal</p>
            </div>

            <div class="product-form-container">

                <!-- Medidas corporais -->
                <div class="form-section">
                    <h2 class="section-title">Medidas Corporais</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 78.5">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Altura (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 178">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Peitoral (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 100">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cintura (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 84">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Quadril (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 96">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Braço Direito (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 34">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Braço Esquerdo (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 33.5">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Coxa (cm)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 56">
                        </div>

                    </div>
                </div>

                <!-- Composição corporal -->
                <div class="form-section">
                    <h2 class="section-title">Composição Corporal</h2>

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">IMC</label>
                            <input type="text" class="form-control-custom" placeholder="Automático" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">% Gordura</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 14%">
                        </div>

                        <div class="form-group">
                            <label class="form-label">% Massa Magra</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 86%">
                        </div>

                        <div class="form-group">
                            <label class="form-label">TMB (kcal)</label>
                            <input type="number" class="form-control-custom" placeholder="Ex: 1750">
                        </div>

                    </div>
                </div>

                <!-- Histórico -->
                <div class="form-section">
                    <h2 class="section-title">Histórico de Avaliações</h2>

                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>% Gordura</th>
                                    <th>% Massa Magra</th>
                                    <th>Cintura</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id="historico-avaliacoes">
                                <tr>
                                    <td>12/11/2025</td>
                                    <td>78.5 kg</td>
                                    <td>16%</td>
                                    <td>84%</td>
                                    <td>84 cm</td>
                                    <td><button class="btn-techfit btn-danger">Excluir</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botões -->
                <div class="action-buttons">
                    <button class="btn-techfit btn-primary">Salvar Avaliação</button>
                    <button class="btn-techfit btn-success">Nova Avaliação</button>
                </div>

            </div>
        </div>
     <footer>
      <?php 
        require_once '../src/views/footer.php';
      ?>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/hidden.js"></script>
<script src="js/modal.js"></script>
<script src="js/treino.js"></script>
<script src="js/config.js"></script>
</html>