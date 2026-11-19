<?php

require_once __DIR__.'/../../../includes/funcoes/func_mudaAbreviacao.php';

$relatoriosAgrupados = [];

foreach ($relatoriosParados as $relatorio) {
    $relatoriosAgrupados[$relatorio->id_rel][] = $relatorio;
}

$resultados = '';

foreach ($relatoriosAgrupados as $avaliacoes) {
    $rel = $avaliacoes[0];
    $ultimaAvaliacao = end($avaliacoes);

    $relTipo = tipoRelatorio($rel->tipo);

    $observacao = '';

    if ($ultimaAvaliacao->resultado === 'r') {
        $observacao = '
            <small>
                <strong>Obs:</strong> Foram solicitadas alterações no relatório, ou seja, o relatório está nas mãos do <strong>responsável</strong>.
            </small>
        ';
    }

    $resultados .= '
        <div class="card mt-2">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <strong>📃 '.$rel->titulo.'</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <strong>Protocolo:</strong> '.$rel->protocolo.'
                    </div>
                    <div class="col-sm">
                        <strong>Tipo de Relatório:</strong> '.$relTipo.'
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <strong>Coordenador:</strong> '.$rel->nome_prof.'
                    </div>
                </div>
            </div>

            <div class="card-body">
                <strong>Tramitação do Relatório</strong>
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
                <td class="text-nowrap text-center">'.$aval->fase_seq.'</td>

                <td class="text-nowrap">
                    <a href="../forms/'.$aval->form.'/vista.php?p='.$aval->id_rel.'&v='.$aval->ver.'" target="_blank">
                        📄 <span class="badge badge-info"></span>
                    </a>
                    '.$aval->avaliador_funcao.' -
                    <span class="badge badge-light">'.$aval->avaliador_nome.'</span>
                </td>

                <td class="text-nowrap">
                    <span class="badge badge-'.$badgeSituacao.'">
                        '.$situacao.'
                    </span>
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

                    <a href="../propostas/visualizar.php?id='.$aval->idproj.'&v='.$aval->pver.'&w=1" target="_blank">
                        <button class="btn btn-success btn-sm mb-2">📃 Projeto</button>
                    </a>
                </div>
            </div>
        </div>
    ';
}

$obPagination = $obPaginationRelatorios;
$parametroPagina = 'pagina_relatorios';

require __DIR__.'/../../../includes/paginacao_pendencias.php';

?>

<section>
    <div id="accordion-relatorios">
        <?= $resultados ?>
    </div>
</section>

<section>
    <div class="row mt-2">
        <div class="col">
            <?= $paginacao ?>
        </div>
    </div>
</section>
