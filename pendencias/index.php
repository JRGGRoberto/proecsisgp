<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

require '../includes/header.php';

$tipo = $_GET['tipo'] ?? 'usuarios';
$currentUrl = $_SERVER['REQUEST_URI'];

?>

<h2 class="mt-0">Pendências</h2>

<section>
    <form method="get">
        <label for="tipo-pendencia">Consultar:</label>
        <select
            id="tipo-pendencia"
            name="tipo"
            class="custom-select custom-select-sm w-auto"
            role="button"
            onchange="this.form.submit()">
            <option value="usuarios" <?= $tipo === 'usuarios' ? 'selected' : '' ?>>
                Professores e Agentes
            </option>
            <option value="processos" <?= $tipo === 'processos' ? 'selected' : '' ?>>
                Propostas e Relatórios
            </option>
        </select>
    </form>
</section>

<?php
    if ($tipo === 'usuarios') {
            require './usuarios/usuarios.php';
    }   elseif ($tipo === 'processos') {
            // Filtros gerais
                $nome_prof = htmlspecialchars(filter_input(INPUT_GET, 'nome_prof') ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $titulo = htmlspecialchars(filter_input(INPUT_GET, 'titulo') ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $protocolo = htmlspecialchars(filter_input(INPUT_GET, 'protocolo') ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $fase_seq = filter_input(INPUT_GET, 'fase_seq', FILTER_VALIDATE_INT);
                $diasParados = filter_input(INPUT_GET, 'dias_parados', FILTER_VALIDATE_INT);
            ?>

            <div class="card mt-3 mb-3">
                <div class="card-body">
                    <form method="get">
                        <input type="hidden" name="tipo" value="processos">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Título</label>
                                <input
                                    type="text"
                                    name="titulo"
                                    id="titulo"
                                    class="form-control form-control-sm"
                                    value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>"
                                >
                            </div>

                            <div class="col-md-4">
                                <label>Coordenador</label>
                                <input
                                    type="text"
                                    name="nome_prof"
                                    id="nome_prof"
                                    class="form-control form-control-sm"
                                    value="<?= htmlspecialchars($nome_prof, ENT_QUOTES, 'UTF-8') ?>"
                                >
                            </div>

                            <div class="col-md-4">
                                <label>Protocolo</label>
                                <input
                                    type="text"
                                    name="protocolo"
                                    id="protocolo"
                                    class="form-control form-control-sm"
                                    value="<?= htmlspecialchars($protocolo, ENT_QUOTES, 'UTF-8') ?>"
                                >
                            </div>

                            <div class="col-md-3 mt-2">
                                <label>Fase</label>
                                <select name="fase_seq" id="fase_seq" class="form-control form-control-sm">
                                    <option value="">Todas</option>
                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <option value="<?= $i ?>" <?= $fase_seq == $i ? 'selected' : '' ?>>
                                            Fase <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label>Dias parados</label>
                                <select name="dias_parados" id="dias_parados" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    <option value="10" <?= $diasParados == 10 ? 'selected' : '' ?>>
                                        10 dias ou mais
                                    </option>
                                    <option value="30" <?= $diasParados == 30 ? 'selected' : '' ?>>
                                        30 dias ou mais
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end mt-2">
                                <button type="submit" class="btn btn-primary btn-sm mr-2">
                                    Filtrar
                                </button>
                                <a href="<?php echo $currentUrl; ?>" id="limpar">
                                    <span class="badge badge-primary">X</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                require './processos/propostas.php';
                require './processos/relatorios.php';
        ?>

            <div class="accordion mt-3 mb-3" id="accordionProcessos">
                <div class="card">
                    <div class="card-header bg-white" id="headingPropostas">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-dark text-decoration-none"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapsePropostas"
                                    aria-expanded="true"
                                    aria-controls="collapsePropostas">
                                <strong>Propostas pendentes</strong>
                                <span class="badge badge-primary ml-2">
                                    <?= $propostasParadasQtd ?>
                                </span>
                            </button>
                        </h5>
                    </div>

                    <div id="collapsePropostas"
                        class="collapse"
                        aria-labelledby="headingPropostas"
                        data-parent="#accordionProcessos">
                        <div class="card-body">
                            <?php require './processos/includes/listagem_propostas.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-white" id="headingRelatorios">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-dark text-decoration-none collapsed"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseRelatorios"
                                    aria-expanded="false"
                                    aria-controls="collapseRelatorios">
                                <strong>Relatórios pendentes</strong>
                                <span class="badge badge-primary ml-2">
                                    <?= $relatoriosParadosQtd ?>
                                </span>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseRelatorios"
                        class="collapse"
                        aria-labelledby="headingRelatorios"
                        data-parent="#accordionProcessos">
                        <div class="card-body">
                            <?php require './processos/includes/listagem_relatorios.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>

  

<?php
   


require '../includes/footer.php';


?>

<script>
    const btnLimpar = document.getElementById('limpar');

    btnLimpar.hidden = true;

    function showLimpar(){
    let titulo = document.getElementById('titulo').value;
    let nome_prof = document.getElementById('nome_prof').value;
    let protocolo   = document.getElementById('protocolo').value;
    // let filtrarBtn = document.getElementById('filtroBtn');
    let fase_seq = document.getElementById('fase_seq');
    let dias_parados = document.getElementById('dias_parados');


    if (
      titulo.length > 0 ||
      nome_prof.length > 0 ||
      protocolo.length > 0 ||
      fase_seq > 0 ||
      dias_parados > 0
    ) {
      btnLimpar.hidden = false;

    } else {
      btnLimpar.hidden = true;
      
    }
  }
  
</script>