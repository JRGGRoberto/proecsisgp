<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<main class="container-fluid">
    <h3 class="mt-3">Dashboard [Beta em modo de testes]</h3>
    <div class="row mt-4 mb-3">
        <div class="col-12">
            
            <div class=" d-flex align-items-center justify-content-between flex-wrap">

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
        </div>
    </div>
    <div class="row mb-4 mt-4">
        <!-- Propostas -->
        <div class="col-md-6">
            <div class="card shadow-sm">
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
        <div class="col-md-6">
            <div class="card shadow-sm">
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

    <div class="row mb-4">
        <!-- Tipos -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tipos de Propostas</h5>
                </div>

                <div class="card-body" style="height: 220px;">
                    <canvas id="graficoTipos"></canvas>
                </div>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5 class="mb-0">Relatórios</h5>
                    <span id="qtdRelatorio" class="fw-bold fs-4">Carregando...</span>
                </div>

                <div class="card-body" style="height: 220px;">
                    <canvas id="graficoRelatorios"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./includes/index.js"></script>
