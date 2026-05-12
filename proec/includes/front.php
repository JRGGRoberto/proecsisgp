<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<main class="container mt-4">
    <h2 class="mb-4 text-center w-100"><strong>PROEC</strong></h2>

    <div class="d-flex align-items-stretch">

        <!-- Esquerda -->
        <div class="d-flex flex-column gap-3 align-items-center" style="flex: 1;">
            
            <h4 class="mb-2 text-center w-100"><strong>Menu</strong></h4>

            <!-- Espaço para alinhar com o filtro -->
            <div style="height: 5px;"></div>

            <a class="btn btn-dark w-100 mb-1"
            href="../solicitaAlteracao/index.php?tipo=atualizar&solicita=PROEC&idLocal=<?php echo $user['reitoria'];?>">
                Alterar coordenador de projeto
            </a>

            <a class="btn btn-dark w-100 mb-1"
            href="../solicitaAlteracao/index.php?tipo=atualizados&solicita=PROEC&idLocal=<?php echo $user['reitoria'];?>">
                Verificar projetos alterados
            </a>

            <?php echo(btnVerificarBolsistas($idPermitido, $user)) ?>
        </div>

        <!-- Direita -->
        <div class="d-flex flex-column ps-3 ml-2 align-items-center" style="flex: 4;">

            <!-- Filtro centralizado -->
            <div class="mb-1 w-100 d-flex justify-content-center">
                <div class="btn-group">
                    <button class="btn btn-outline-primary filtro-ano active" data-ano="">
                        Todos
                    </button>
                    <button class="btn btn-outline-primary filtro-ano" data-ano="2026">
                        2026
                    </button>
                    <button class="btn btn-outline-primary filtro-ano" data-ano="2025">
                        2025
                    </button>
                    <button class="btn btn-outline-primary filtro-ano" data-ano="2024">
                        2024
                    </button>
                </div>
            </div>

            <!-- Gráficos centralizados -->
            <div class="row w-100 justify-content-center">

                <!-- Propostas -->
                <div class="col-md-6 px-1">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <h5 class="mb-0">Propostas <span id="graficoTitulo"></span></h5>
                            <span id="qtdProjetos" class="fw-bold fs-4">Carregando...</span>
                        </div>
                        <div class="card-body" style="height: 260px;">
                            <canvas id="graficoProjetos"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Encerradas -->
                <div class="col-md-6 px-1">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <h5 class="mb-0">Propostas Encerradas</h5>
                            <span id="qtdEncerrados" class="fw-bolder fs-4">Carregando...</span>
                        </div>
                        <div class="card-body" style="height: 260px;">
                            <canvas id="graficoEncerrados"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>
<script src="./includes/dashboard.js"></script>
