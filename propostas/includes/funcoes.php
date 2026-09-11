<?php

use App\Entity\Outros;
use App\Session\Login;

include __DIR__.'/../../includes/funcoes/func_formatDateHour.php';
include __DIR__.'/../../includes/funcoes/func_mudaAbreviacao.php';
Login::requireLogin();
$user = Login::getUsuarioLogado();

$userId = $user['id'];
use App\Entity\Campi;

function dt($dt)
{
    return substr($dt, 8, 2).'/'.substr($dt, 5, 2).'/'.substr($dt, 0, 4);
}

function avaliacoesRelatorios()
{
}

function resumirTexto(string $texto, int $limite = 256): string
{
    // tira tudo q veio do summernote
    $texto = preg_replace('/<style\b[^>]>.?<\/style>/is', '', $texto);
    // remove paragrafo
    $texto = preg_replace('/<p[^>]>\s<\/p>/i', '', $texto);

    // limpa td
    $textoLimpo = trim(strip_tags($texto));

    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    return mb_substr($textoLimpo, 0, $limite).' <span class="badge badge-pill badge-success">(continua...)</span>';
}

// Monta tabela de avaliações dos projetos
function montarTblAvalProp(array $avaliacoes, $projId, $mensagem)
{
    $todasConcluidas = false;
    $ultimaAval =
        '<table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Projeto</th>
                    <th class="mx-4">Parecere(s) 
                        <a href="../prnRelatorios/index.php?id='.$projId.'" target="_blank"><span class="badge badge-secondary">Visualizar  🖨️</span></a>
                    </th>
                    <th>Situação</th>
                    <th>Parte</th>
                </tr>
            </thead>
            <tbody>';
    $count = 0;
    $etapas = 0;
    $btnStatus = [];

    foreach ($avaliacoes as $aval) {
        ++$count;
        $class = '';
        $td = '';
        $instancia = '';
        $instancia = mudaAbreviacaoInstancias($aval->tp_instancia);

        // config da tabela de avaliação
        switch ($aval->resultado) {
            case 'a':
                $aval->resultado = 'Aprovado';
                $badgeSituacao = 'success';

                $class = 'table-success';
                $td = '<td class="text-nowrap"><a href="../forms/'.$aval->form.'/vista.php?p='.$projId.'&v='.$aval->ver.'" target="_blank">📄</a> '.$instancia.'</td>';

                $btnStatus[] = [
                    'pos' => $aval->fase_seq,
                    'cor' => 'success',
                ];
                break;

            case 'r':
                $aval->resultado = 'Solicitação de alterações';
                $badgeSituacao = 'danger';

                $class = 'table-danger';
                $td = '<td class="text-nowrap"><a href="../forms/'.$aval->form.'/vista.php?p='.$projId.'&v='.$aval->ver.'" target="_blank">📄</a> '.$instancia.'</td>';

                $btnStatus[] = [
                    'pos' => $aval->fase_seq,
                    'cor' => 'danger',
                ];
                break;
            default:
                $aval->resultado = 'Em análise';
                $badgeSituacao = 'warning';
                $class = 'table-warning';
                $td = '<td class="text-nowrap"><span class="badge badge-light">Espera de parecer... ['.$instancia.'] '.formatarData($aval->created_at).'</span></td>';

                $btnStatus[] = [
                    'pos' => $aval->fase_seq,
                    'cor' => 'warning',
                ];
        }

        $ultimaAval .=
           '<tr class="'.$class.'">
                <td>
                   <a href="../propostas/visualizar.php?id='.$projId.'&v='.$aval->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($aval->ver + 1).'</span></a>
                </td>'
            .$td.
                '<td><span class="align-middle badge badge-'.$badgeSituacao.'">'.$aval->resultado.'</span></td>'.
                '<td>'.$aval->fase_seq.'/'.$aval->etapas.'</td>
            </tr>';

        $etapas = $aval->etapas;

        if ($aval->etapas == $aval->fase_seq && $aval->resultado == 'a') {
            $todasConcluidas = true;
        }
    }

    $ultimaAval .=
      '</tbody>
    </table>';

    $btnStatus = array_reverse($btnStatus);

    foreach ($btnStatus as $btn) {
        $btnS[$btn['pos'] - 1] = $btn;
    }

    $progresso =
     '<span class="badge badge-light">Processo ['.$mensagem.']<br>
        <div class="btn-group">';

    foreach ($btnS as $btn) {
        $progresso .= '<button type="button" class="btn btn-'.$btn['cor'].'" disabled></button>';
    }

    $progresso .=
          ' </div>
        </span>';

    $btnAvaliacoes = '';

    if ($todasConcluidas) {
        $btnAvaliacoes =
            '<a href="../prnRelatorios/index.php?id='.$projId.'" target="_blank" 
                class="btn btn-primary btn-sm mb-2" data-toggle="tooltip" data-placement="bottom" title="Visualizar todas as avaliações realizadas.">
                🖨️ Avaliações
            </a>';
    }

    return [$progresso, $ultimaAval, $btnAvaliacoes];
}

function montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes)
{
    $id = $relatorio->id;

    $linkFeito = '<a href="../relatorio/editar'.$link.'.php?id='.$id.'" target="_blank">';

    // pega a ultima avaliacao realizada no array de avaliacoes
    $ultimaAval = end($avaliacoes);

    if ($ultimaAval && $ultimaAval->resultado == 'r') {
        $html = '
        <div class="mb-1">
            '.$linkFeito.'
                <button class="btn btn-danger btn-sm mb-2">
                    '.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$resultadoRel.'
                </button>
            </a>
        ';
    } else {
        $html = '
            <div class="mb-3">
                '.$linkFeito.'
                    <button class="btn btn-primary btn-sm mb-2">
                        '.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$resultadoRel.'
                    </button>
                </a>
        ';
    }

    if (!empty($avaliacoes)) {
        $html .= '
            <button
                class="btn btn-secondary btn-sm mb-2"
                type="button"
                data-toggle="collapse"
                data-target="#avaliacoes-rel-'.$id.'"
                aria-expanded="false"
                aria-controls="avaliacoes-rel-'.$id.'"
            >
                📋 Avaliações
            </button>

            <div
                id="avaliacoes-rel-'.$id.'"
                class="collapse"
            >
                '.$avaliacoesRel.'
            </div>
        ';
    }

    $html .= '
        </div>
    ';

    return $html;
}

function createRelAvaliacoes($avaliacoes, $relatorio)
{
    if (empty($avaliacoes)) {
        return '';
    }

    $tabelaRelAval = ' 
        <table class="table table-bordered table-sm mb-0">
            <thead class="thead-dark">
                <tr>
                    <th>Relatório</th>
                    <th>Parecer(es)</th>
                    <th>Situação</th>
                    <th>Parte</th>
                </tr>
            </thead>
            <tbody>
    ';
    foreach ($avaliacoes as $avaliacao) {
        switch ($avaliacao->resultado) {
            case 'a':
                $resultado = 'Aprovado';
                $badgeSituacao = 'success';
                $class = 'table-success';
                break;
            case 'r':
                $resultado = 'Solicitação de alterações';
                $badgeSituacao = 'danger';
                $class = 'table-danger';
                break;
            default:
                $resultado = 'Em análise';
                $badgeSituacao = 'warning';
                $class = 'table-warning';
                break;
        }

        $linkAvaliacao = '
            <a
                href="../relatorio/aval.php?id='.$avaliacao->id.'"
                target="_blank"
            >
                📄
            </a>
        ';

        $tabelaRelAval .= '
            <tr class="'.$class.'">
                <td>
                    '.tipoRelatorioIcon($relatorio->tipo).'
                </td>
                <td class="text-nowrap">
                    '.$linkAvaliacao.'
                    '.mudaAbreviacaoInstancias($avaliacao->tp_instancia).'
                </td>
                <td>
                    <span class="badge badge-'.$badgeSituacao.'">
                        '.$resultado.'
                    </span>
                </td>
                <td>
                    '.$avaliacao->fase_seq.'/'.$relatorio->fases.'
                </td>
            </tr>
        ';
    }

    $tabelaRelAval .= '
            </tbody>
        </table>
    ';

    return $tabelaRelAval;
}

function createBT($tipo, $id, $ver = null, $form = null, $tipo_exten = null, $titulo = null, $userId = null, $profId = null): string
{
    // Garante que o botão apareca apenas na pág "Meus projetos"
    if (($_GET['pag'] == 'listagem_all') || ($_GET['pag'] == null)) {
        $hidden = 'hidden';
    } elseif ($_GET['pag'] == 'listagem') {
        $hidden = null;
    }

    switch ($tipo) {
        case 'submeter':
            return '<a><button id="sub'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)"> 📤 Submeter </button></a>';
        case 'submeterNovamente':
            return '<a><button id="Alt'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)"> 📤 Submeter novamente </button></a>';
        case 'editar':
            return '<a href="editar.php?id='.$id.'&v='.$ver.'"><button class="btn btn-success btn-sm mb-2"> 📝 Editar </button></a>';
        case 'excluir':
            return '<a><button id="del'.$id.'v'.$ver.'" class="btn btn-danger  btn-sm mb-2" onclick="writeNumber(this)"> 🗑 Excluir </button></a>';
        case 'visualizar':
            return '<a href="visualizar.php?id='.$id.'&v='.$ver.'&w=1" target="_blank"><button class="btn btn-success btn-sm mb-2"> 📄 Projeto </button></a>';
        case 'adequacoes':
            return '<a href="../forms/'.$form.'/vista.php?p='.$id.'&v='.($ver - 1).'"><button class="btn btn-danger btn-sm mb-2" > 📑 Informações de adequações </button></a>';
        case 'alteraSAP':
            return '<a><button id="SAP'.$id.'v'.$ver.'" class="btn btn-warning btn-sm mb-2 ml-1" '.$hidden.' onclick="writeNumber(this)"> 🔄 Solicitar alteração </button></a>';
        case 'relatorioParcial':
            // tirar o
            if ($userId == $profId) {
                // Se não for evento
                if ($tipo_exten != 2) {
                    return '
                        <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2 "> 📝 Criar/Editar Relatórios </button></a> 
                    ';
                } else {
                    // Evento:
                    return '
                        <a href="../relatorio/index.php?id='.$id.'">
                            <button 
                                class="btn btn-success btn-sm mb-2" 
                                data-toggle="tooltip"
                                Title="Relatório parcial não é aplicado para eventos."
                                data-placement="bottom" 
                                disabled>
                                📝 Criar/Editar Relatórios
                            </button>
                        </a>
                    ';
                }
            } else {
                return '';
            }
            // no break
        case 'relatorioFinal':
            if ($userId == $profId) {
                // tirar o
                return '<a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2 ml-4"> 📝 Editar Relatórios </button></a>';
            } else {
                return '';
            }
            // no break
        case 'declaracao' :
            if ($userId == $profId) {
                return '<a href="./declaracao.php?id='.$id.'"><button class="btn btn-info btn-sm mb-2 ">📃 Declaração </button></a>';
            } else {
                return '';
            }
            // no break
        default:
            return '';
    }
}

function getUsuariosEspecificos()
{
    $ids_DirCampus = Campi::getRegistros();

    return array_merge([
        'bfd757a5-4f2d-4a10-87a8-a872ae69f1fd',
        'b8fa555f-cedb-47cf-91cc-7581736aac88',
    ], array_column($ids_DirCampus, 'chef_div_id'));
}

function naoSubmetido($p, $user): string
{
    $i = $p->id;
    $v = $p->ver;
    $userId = $user['id'];
    $profId = $p->id_prof;
    // $userConfig = $user['config'];
    if ($userId == $profId) {
        return
        createBT('submeter', $i, $v).' &nbsp; '.
        createBT('editar', $i, $v).' &nbsp; '.
        createBT('visualizar', $i, $v).' &nbsp; '.
        createBT('excluir', $i, $v);
    } else {
        return '';
    }
}

function emAvaliacao($p, $user)
{
    $i = $p->id;
    $v = $p->ver;
    $t = $p->titulo;
    $form = $p->form;
    $profId = $p->id_prof;
    $userId = $user['id'];
    $userConfig = $user['config'];

    $osCabeca = [1, 2, 3, 4]; // só a elite

    if ($userId == $profId) {
        if ($p->resultado == 'n') {
            if ($p->edt == 0) {
                return
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('alteraSAP', $i, $v).'  	&nbsp; ';
            // createBT('cancelar', $i, $v).'  	&nbsp; ';
            } elseif ($p->edt == 1) {
                return
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
                createBT('visualizar', $i, $v).'  	&nbsp; ';
                // createBT('cancelar', $i, $v);
            }
        } elseif ($p->resultado == 'e') {
            return
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('alteraSAP', $i, $v).'  	&nbsp; ';
        // createBT('cancelar', $i, $v).'  	&nbsp; ';
        } elseif ($p->resultado == 'r') {
            return
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
                createBT('visualizar', $i, $v).'  	&nbsp; ';
        }
    } elseif (in_array($userConfig, $osCabeca)) {
        return createBT('visualizar', $i, $v);
    } else {
        return '';
    }
}

function naoIniciado($p, $userId)
{
    $i = $p->id;
    $v = $p->ver;
    $t = $p->titulo;
    $profId = $p->id_prof;

    if ($userId == $profId) {
        return
            createBT('visualizar', $i, $v).' &nbsp; '.
            createBT('alteraSAP', $i, $v).' &nbsp; '.
            createBT('declaracao', $i, $v, null, null, null, $userId, $profId);
    // createBT('cancelar', $i, $v, null, null, $t);
    } else {
        return createBT('visualizar', $i, $v);
    }
}

function emExecucao($p, $userId): string
{
    $i =
    $p->id;
    $v = $p->ver;
    $tipo = $p->tipo_exten;
    $profId = $p->id_prof;
    $rel_parInfos = '';

    $rel_par = Outros::qry("
        select 
            rp.id, 
            rp.last_result,
            if(rp.tramitar = 1 and rp.last_result = 'a' and rp.etapa = rp.etapas and rp.tramitar = 1, 1, 0 ) publicado, 
            DATE_FORMAT(rp.created_at , '%d/%m/%Y') dt_create
        from rel_parcial rp
        where rp.idproj = '".$i."'
            order by rp.created_at desc
        "
    );
    if (isset($rel_par)) {
        foreach ($rel_par as $rp) {
            $resultadoRel = '<span class="badge badge-light ">Em avaliação</span>';
            $avaliacoes = Outros::qry("
                SELECT 
                    fr.*
                FROM avaliacoes_rel ar
                INNER JOIN form_rel fr 
                    ON fr.id = ar.id
                WHERE ar.id_rel = '".$rp->id."'
                ORDER BY fr.created_at ASC
            ");

            if ($rp->publicado == 1) {
                $resultadoRel = '';

                $rel_parInfos .= '
                    <a href="../relatorio/editarp.php?id='.$rp->id.'" target="_blank">
                        <button class="btn btn-primary btn-sm ">
                            📊 Relatório Parcial '.$rp->dt_create.' 
                            </button>
                    </a> &nbsp; ';
            } else {
                if ($rp->last_result == 'r' && $profId == $userId) {
                    $resultadoRel = '<span class="badge badge-light">Solicitação de alterações</span>';
                    $linkFeito = '<a href="../relatorio/editarp.php?id='.$rp->id.'" target="_blank">';
                    $rel_parInfos .= $linkFeito.'<button class="btn btn-danger btn-sm "> 📊 Relatório Parcial &nbsp;'.$rp->dt_create.'&nbsp;'.$resultadoRel.'</button></a> &nbsp; ';
                } else {
                    $rel_parInfos .= '
                    <button 
                        class="btn btn-primary btn-sm" 
                        disabled 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Relatório em avaliação.">
                            📊 Relatório Parcial '.$rp->dt_create.'&nbsp;'.$resultadoRel.' 
                    </button> &nbsp; ';
                }
            }
        }
    }

    $seeBtn = null;
    if ($userId == $profId) {
        $seeBtn = createBT('alteraSAP', $i, $v).'  	&nbsp; ';
    }

    return
        createBT('visualizar', $i, $v).'  	&nbsp; '.
        createBT('relatorioParcial', $i, $v, null, $tipo, null, $userId, $profId).' &nbsp;'.
        $seeBtn.
        $rel_parInfos
        // createBT('cancelar', $i, $v).' &nbsp; '
    ;
}

function adequacoes($p, $user)
{
    $i = $p->id;
    $v = $p->ver;
    $t = $p->titulo;
    $form = Outros::q("select form from avalia_last al where al.id_proj = '".$i."'");

    $form == null ? $form = '' : $form = $form->form;

    $profId = $p->id_prof;
    $userId = $user['id'];
    $userConfig = $user['config'];

    $osCabeca = [1, 2, 3, 4]; // só a elite

    if ($userId == $profId) {
        if ($p->resultado == 'r') {
            return
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('cancelar', $i, $v, null, null, $t);
        } elseif ($p->resultado == 'n') {
            if ($p->edt == 0) {
                return
                createBT('visualizar', $i, $v).
                createBT('cancelar', $i, $v).'  	&nbsp; ';
            } else {
                return
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('cancelar', $i, $v);
            }
        }
    } elseif (in_array($userConfig, $osCabeca)) {
        return createBT('visualizar', $i, $v);
    } else {
        return '';
    }
}

function ressubmit($p, $user)
{
    $i = $p->id;
    $v = $p->ver;
    // $t = $p->titulo;
    $form = Outros::q("select form from avalia_last al where al.id_proj = '".$i."'");
    $form == null ? $form = '' : $form = $form->form;

    return
    createBT('visualizar', $i, $v).'  	&nbsp; '.
    createBT('editar', $i, $v).'  	&nbsp; '.
    createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
    createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
    createBT('cancelar', $i, $v);
}

function aguardandoRelatorio($p, $userId)
{
    $i = $p->id;
    $v = $p->ver;
    $profId = $p->id_prof;

    $rel_Infos = '';

    // puxa os cabeça
    $usuariosEspecificos = getUsuariosEspecificos();

    $rel = Outros::qry(" 
        SELECT 
            r.id,
            r.tipo,
            r.publicado,
            r.created_at,
            r.last_result,
            r.fase_atual,
            r.fases
        FROM relats r
        WHERE r.idproj = '".$i."' 
        ORDER BY r.created_at DESC
    ");

    $botoes = createBT('visualizar', $i, $v);

    if ($userId == $profId) {
        $botoes .= '
            <a href="../relatorio/index.php?id='.$i.'" 
                class="btn btn-success btn-sm mb-2 mr-1">
                📝 Criar/Editar Relatórios
            </a>';

        $botoes .= createBT('declaracao', $i, $v, null, null, null, $userId, $profId);
    }

    $necessitaAlteracoes = false;

    if (isset($rel)) {
        foreach ($rel as $relatorio) {
            // puxando cada avaliacao do relatorio
            $avaliacoes = Outros::qry("
                    SELECT  
                         ar.*
                    FROM avaliacoes_rel ar
                    WHERE ar.id_rel = '".$relatorio->id."'
                    ORDER BY ar.fase_seq ASC, ar.created_at ASC
            ");

            $avaliacoesRel = createRelAvaliacoes($avaliacoes, $relatorio);

            $tipoRel = tipoRelatorioIcon($relatorio->tipo);
            $link = in_array($relatorio->tipo, ['fi', 're', 'pr']) ? 'f' : 'p';

            $infEtapas = '['.$relatorio->fase_atual.'/'.$relatorio->fases.']';

            $resultadoRel = '<span class="badge badge-light">
                        Em avaliação '.$infEtapas.'
                    </span>';

            if ($relatorio->publicado == 1) {
                $resultadoRel = '';
                $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);

            // em avaliação
            } else {
                if ($relatorio->last_result == 'r' && $profId == $userId) {
                    $necessitaAlteracoes = true;

                    $resultadoRel = '<span class="badge badge-light">Solicitação de alterações</span>';
                    $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);
                } elseif (in_array($userId, $usuariosEspecificos) || $userId == $profId) {
                    $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);
                } else {
                    $rel_Infos .= '
                        <div class="mb-1">
                            <button 
                                class="btn btn-primary btn-sm"
                                disabled
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Relatório em avaliação."
                            >
                                '.$tipoRel.'&nbsp;'.
                                formatarData($relatorio->created_at).'&nbsp;'.$resultadoRel.'
                            </button>
                        </div>
                    ';
                }
            }
        }
    }

    if (!empty($rel_Infos)) {
        $botoes .= '
                <div class="w-100 border-top mt-2 pt-2 mb-2">
                    <strong>Relatórios</strong>
                </div>
                '.$rel_Infos.'
        ';
    }

    // se for o dono do projeto
    if ($userId == $profId) {
        return [
            'botoes' => $botoes,
            'necessitaAlteracoes' => $necessitaAlteracoes,
        ];

    // os cabeças
    } elseif (in_array($userId, $usuariosEspecificos)) {
        return [
            'botoes' => createBT('visualizar', $i, $v).
                (!empty($rel_Infos) ? '
                    <div class="mt-2 mb-1">
                        <strong>📊 Relatórios</strong>
                    </div>
                    <div class="ml-2">
                        '.$rel_Infos.'
                    </div>
                ' : ''),
            'necessitaAlteracoes' => $necessitaAlteracoes,
        ];
    } else {
        return [
            'botoes' => createBT('visualizar', $i, $v),
            'necessitaAlteracoes' => false,
        ];
    }
}

function finalizado($p, $userId): string
{
    $i = $p->id;
    $v = $p->ver;
    $profId = $p->id_prof;
    $rel_Infos = '';

    $usuariosEspecificos = getUsuariosEspecificos();

    // puxando relatorios do projeto
    $rel = Outros::qry(" 
        SELECT 
            r.id,
            r.tipo,
            r.publicado,
            r.created_at,
            r.last_result,
            r.fase_atual,
            r.fases
        FROM relats r
        WHERE r.idproj = '".$i."' 
        ORDER BY r.created_at DESC
    ");

    $botoes = createBT('visualizar', $i, $v);

    if ($userId == $profId) {
        $botoes .= '
            <a href="../relatorio/index.php?id='.$i.'"class="btn btn-success btn-sm mb-2 mr-1">
                📝 Criar/Editar Relatórios
            </a>';

        $botoes .= createBT('declaracao', $i, $v, null, null, null, $userId, $profId);
    }

    $botoes .= '<div class="w-100 border-top mt-2 pt-2 mb-2"><strong>Relatórios</strong></div>';
    if (isset($rel)) {
        foreach ($rel as $relatorio) {
            // puxando cada avaliacao do relatorio
            $avaliacoes = Outros::qry("
                    SELECT 
                        ar.*
                    FROM avaliacoes_rel ar
                    WHERE ar.id_rel = '".$relatorio->id."'
                    ORDER BY ar.fase_seq ASC, ar.created_at ASC
            ");

            $avaliacoesRel = createRelAvaliacoes($avaliacoes, $relatorio);
            $tipoRel = tipoRelatorioIcon($relatorio->tipo);
            // seta o link na visualização do rel
            $link = in_array($relatorio->tipo, ['fi', 're', 'pr']) ? 'f' : 'p';

            $infEtapas = '['.$relatorio->fase_atual.'/'.$relatorio->fases.']';

            $resultadoRel = '<span class="badge badge-light">
                        Em avaliação '.$infEtapas.'
                    </span>';

            if ($relatorio->publicado == 1) {
                $resultadoRel = '';
                $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);
            } else {
                if ($relatorio->last_result == 'r' && $profId == $userId) {
                    $resultadoRel = '<span class="badge badge-light">Solicitação de alterações</span>';
                    $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);
                } elseif (in_array($userId, $usuariosEspecificos)) {
                    $rel_Infos .= montarTblAvalRel($relatorio, $tipoRel, $link, $resultadoRel, $avaliacoesRel, $avaliacoes);
                } else {
                    $rel_Infos .= '
                        <div class="mb-1">
                            <button 
                                class="btn btn-primary btn-sm"
                                disabled
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Relatório em avaliação."
                            >
                                '.$tipoRel.'&nbsp;'.
                                formatarData($relatorio->created_at).'&nbsp;'.$resultadoRel.'
                            </button>
                        </div>';
                }
            }
        }
    }

    $btns = '';
    $btns = createBT('visualizar', $i, $v).' &nbsp; '.
    createBT('relatorioFinal', $i, $v, null, null, null, $userId, $profId).''.
    $rel_Infos.'
    '.createBT('declaracao', $i, $v, null, null, null, $userId, $profId);

    return $btns;
}

function cancelado($p): string
{
    $i = $p->id;
    $v = $p->ver;

    return createBT('visualizar', $i, $v);
}

?>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>