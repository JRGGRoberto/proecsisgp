<?php

use App\Entity\EmailService;

$emailService = new EmailService();

$propostasAgrupadas = [];

foreach ($propostasParadas as $proposta) {
    $propostasAgrupadas[$proposta->id_projeto][] = $proposta;
}

$resultados = '';

foreach ($propostasAgrupadas as $avaliacoes) {
    $proj = $avaliacoes[0];
    $ultimaAvaliacao = end($avaliacoes);

    $observacao = '';

    if ($ultimaAvaliacao->resultado === 'r') {
        $observacao = '
            <small>
                <strong>Obs:</strong> Foram solicitadas alterações na proposta, ou seja, a proposta está nas mãos do <strong>proponente</strong>.
            </small>
        ';
    }

    $resultados .= '
        <div class="card mt-2">
            <div class="card-header">
                <strong>📃 '.$proj->titulo.'</strong>
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
            <div class="card-body">
                <strong>Tramitação da Proposta</strong>
                <div class="mt-2">
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

        $entrada = date('d/m/Y', strtotime($aval->created_at));
        $saida = $aval->updated_at
            ? date('d/m/Y', strtotime($aval->updated_at))
            : '-';

        $resultados .= '
            <tr class="'.$class.'">
                <td class="text-nowrap text-center">'.$aval->fase_avaliacao.'</td>
                <td class="text-nowrap">
                    <a href="../forms/'.$aval->form.'/vista.php?p='.$aval->id_projeto.'&v='.$aval->ver.'" target="_blank">📄</a>
                    '.$aval->avaliador_funcao.' -
                    <span class="badge badge-light">'.$aval->avaliador_nome.'</span>
                </td>
                <td class="text-nowrap">
                    <span class="badge badge-'.$badgeSituacao.'">'.$situacao.'</span>
                </td>
                <td class="text-nowrap">'.$entrada.'</td>
                <td class="text-nowrap">'.$saida.'</td>
                <td class="text-nowrap">'.$aval->dias_permanencia.' dias</td>
            </tr>
        ';
    }

    $resultados .= '
                        </tbody>
                    </table>
                    <a href="../propostas/visualizar.php?id='.$proj->id_projeto.'&v='.$proj->ver.'&w=1" target="_blank">
                        <button class="btn btn-success btn-sm mb-2">📃 Projeto</button>
                    </a>
                </div>
            </div>
        </div>
    ';
}

$obPagination = $obPaginationPropostas;
$parametroPagina = 'pagina_propostas';

require __DIR__.'/../../../includes/paginacao_pendencias.php';

echo $resultados;
?>

<section>
    <div class="row mt-2">
        <div class="col">
            <?= $paginacao ?>
        </div>
    </div>
</section>