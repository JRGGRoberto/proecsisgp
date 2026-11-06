<?php

use App\Entity\EmailService;
$emailService = new EmailService();


$propostasAgrupadas = [];

foreach ($propostasParadas as $proposta) {
    $propostasAgrupadas[$proposta->id_projeto][] = $proposta;
}

$resultados = '';

// echo '<pre>';
// print_r($propostasParadasQtd);
// echo '</pre>';

foreach ($propostasAgrupadas as $avaliacoes) {

    $proj = $avaliacoes[0];
    $ultimaAvaliacao = end($avaliacoes);

    $nomeAvaliador = htmlspecialchars($ultimaAvaliacao->avaliador_nome ?? 'Não informado', ENT_QUOTES, 'UTF-8');
    $emailAvaliador = htmlspecialchars($ultimaAvaliacao->avaliador_email ?? '', ENT_QUOTES, 'UTF-8');

    // $emailService->mailNotificarAvaliador(
    //     $proj->id, $proj->titulo, $proj->protocolo, $proj->tipo_exten, $emailAvaliador, $nomeAvaliador
    // );
    $observacao = '';

    if ($ultimaAvaliacao->resultado === 'r') {
        $observacao = '
        <small>
            <strong>Obs:</strong> Foram solicitadas alterações na proposta, ou seja, a proposta está nas mãos do <strong>proponente</strong>.
        </small>
        ';
    }
    $idCard = 'p' . str_replace('-', '', $proj->id_projeto);
    $idAvaliacoes = 'avaliacoes-' . str_replace('-', '', $proj->id_projeto);

    // echo '<pre>';
    // print_r($ultimaAvaliacao);
    // echo '</pre>';
    
    


    $resultados .= '
    <div class="card mt-2">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                        <strong>📃 '.$proj->titulo.'</strong>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <strong>Protocolo:</strong> '.$proj->protocolo.'
                </div>

                <div class="col-sm">
                    <strong>Tipo de Proposta:</strong> '.$proj->tipo_exten.'
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <strong>Coordenador:</strong> '.$proj->nome_prof.'
                </div>

                <div class="col-sm">
                    <strong>Campus:</strong> '.$proj->campus.'
                </div>
            </div>
        </div>

        <div id="'.$idCard.'">
            <div class="card-body">
                <strong>Tramitação da Proposta</strong>

                <div class="mt-2">
    ';

    $resultados .= '
    '.$observacao.'
    <table class="table table-bordered table-sm">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Fase</th>
                <th>Parecer(es)</th>
                <th>Situação</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Permanência</th>
            </tr>
        </thead>
        <tbody>
';

        foreach ($avaliacoes as $aval) {

            switch ($aval->resultado) {
                case 'a':
                    $situacao = 'Aprovado';
                    $badgeSituacao = 'success';
                    $class = 'table-success';
                    break;

                case 'r':
                    $situacao = 'Solicitação de alterações';
                    $badgeSituacao = 'danger';
                    $class = 'table-danger';
                    break;

                default:
                    $situacao = 'Em análise';
                    $badgeSituacao = 'warning';
                    $class = 'table-warning';
            }

            $entrada = date('d/m/Y ', strtotime($aval->created_at));

            $saida = $aval->updated_at
                ? date('d/m/Y ', strtotime($aval->updated_at))
                : '-';

            $resultados .= '
                <tr class="'.$class.'">

                    <td class="text-nowrap text-center">
                        '.$aval->fase_avaliacao.'
                    </td>

                    <td class="text-nowrap ">
                        <a href="../forms/'.$aval->form.'/vista.php?p='.$aval->id_projeto.'&v='.$aval->ver.'" target="_blank">
                            📄 <span class="badge badge-info"></span>
                        </a> '.$aval->avaliador_funcao.' - <span class="badge badge-light">'.$aval->avaliador_nome.' </span>
                    </td>

                    <td class="text-nowrap">
                        <span class="badge badge-'.$badgeSituacao.'">
                            '.$situacao.'
                        </span>
                    </td>

                    <td class="text-nowrap">'.$entrada.'</td>

                    <td class="text-nowrap">'.$saida.'</td>

                    <td class="text-nowrap">
                        '.$aval->dias_permanencia.' dias
                    </td>
                </tr>
            ';
        }

        $resultados .= '
                </tbody>
            </table>
            <a href="../propostas/visualizar.php?id='.$aval->id_projeto.'&v='.$proj->ver.'&w=1" target="_blank">
              <button class="btn btn-success btn-sm mb-2">📃 Projeto </button>
            </a>
           
        ';

    $resultados .= '
                </div>
            </div>
        </div>
    </div>



    ';
}

include '../includes/paginacao.php';

?>

<div class="card mb-3 mt-3">
    <div class="card-body">
       <form method="get">

            <div class="row my-2">

                <div class="col-4">
                    <label>Título</label>
                    <input
                        type="text"
                        name="titulo"
                        class="form-control form-control-sm"
                        value="<?= $titulo; ?>"
                        id="titulo"
                        onchange="showLimpar();"
                    >
                </div>

                <div class="col-4">
                    <label>Coordenador</label>
                    <input
                        type="text"
                        name="nome_prof"
                        class="form-control form-control-sm"
                        value="<?= $nome_prof; ?>"
                        id="nome_prof"
                        onchange="showLimpar();"
                    >
                </div>

                <div class="col-4">
                    <label>Protocolo</label>
                    <input
                        type="text"
                        name="protocolo"
                        class="form-control form-control-sm"
                        value="<?= $protocolo; ?>"
                        id="protocolo"
                        onchange="showLimpar();"
                    >
                </div>

                <div class="col-3 mt-2">
                    <label>Fase</label>
                    <select
                        name="fase_seq"
                        id="fase_seq"
                        class="form-control form-control-sm"
                        onchange="showLimpar();"
                    >
                        <option value="">Todas</option>
                        <option value="1" <?= $fase_seq == 1 ? 'selected' : ''; ?>>Fase 1</option>
                        <option value="2" <?= $fase_seq == 2 ? 'selected' : ''; ?>>Fase 2</option>
                        <option value="3" <?= $fase_seq == 3 ? 'selected' : ''; ?>>Fase 3</option>
                        <option value="4" <?= $fase_seq == 4 ? 'selected' : ''; ?>>Fase 4</option>
                        <option value="5" <?= $fase_seq == 5 ? 'selected' : ''; ?>>Fase 5</option>
                        <option value="6" <?= $fase_seq == 6 ? 'selected' : ''; ?>>Fase 6</option>
                    </select>
                </div>

                <div class="col-3 mt-2">
                    <label>Dias parados</label>
                    <select
                        name="dias_parados"
                        id="dias_parados"
                        class="form-control form-control-sm"
                        onchange="showLimpar();"
                    >
                        <option value="">Todos</option>
                        <option value="10" <?= $diasParados == 10 ? 'selected' : ''; ?>>
                            10 dias ou mais
                        </option>
                        <option value="30" <?= $diasParados == 30 ? 'selected' : ''; ?>>
                            30 dias ou mais
                        </option>
                    </select>
                </div>

                <div class="col-2 d-flex align-items-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm mr-2">
                        Filtrar
                    </button>

                    <a href="./" id="limpar">
                        <span class="badge badge-primary">x</span>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<section>
    <div id="accordion">
        <?= $resultados; ?>
    </div>
</section>

<section>
    <div class="row mt-2 align-bottom">
        <div class="col">
            <?= $paginacao; ?>
        </div>
    </div>
</section>

<script>
function showLimpar() {
    var titulo = document.getElementById('titulo').value;
    var nomeProf = document.getElementById('nome_prof').value;
    var protocolo = document.getElementById('protocolo').value;
    var fase = document.getElementById('fase_seq').value;
    var diasParados = document.getElementById('dias_parados').value;

    var btnLimpar = document.getElementById('limpar');

    if (
        titulo.length > 0 ||
        nomeProf.length > 0 ||
        protocolo.length > 0 ||
        fase.length > 0 ||
        diasParados.length > 0
    ) {
        btnLimpar.hidden = false;
    } else {
        btnLimpar.hidden = true;
    }
}

showLimpar();
</script>