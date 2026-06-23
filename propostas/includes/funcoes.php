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

function resumirTexto(string $texto, int $limite = 256): string
{
    $remStyle = '</style>';
    $posStyle = strpos($texto, $remStyle);
    if ($posStyle > 0) {
        $texto = substr($texto, $posStyle);
    }

    $textoLimpo = trim(strip_tags($texto));

    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    return substr($textoLimpo, 0, $limite).' <span class="badge badge-pill badge-success">(continua...)</span>';
}

// Monta tabela de avaliações dos projetos
function montarTblEProgress(array $ListaVerAnts, $projId, $msg1)
{
    $todasConcluidas = false;
    $LastV =
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
    $a = 0;
    $etapas = 0;
    $btnStatus = [];

    foreach ($ListaVerAnts as $la) {
        ++$a;
        $class = '';
        $td = '';
        $instancia = '';
        $instancia = mudaAbreviacaoInstancias($la->tp_instancia);

        switch ($la->resultado) {
            case 'a':
                $la->resultado = 'Aprovado';
                $badgeSituacao = 'success';

                $class = 'table-success';
                $td = '<td class="text-nowrap"><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'success')); // 'primary')); //
                break;

            case 'r':
                $la->resultado = 'Solicitação de alterações';
                $badgeSituacao = 'danger';

                $class = 'table-danger';
                $td = '<td class="text-nowrap"><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'danger'));
                break;
            default:
                $la->resultado = 'Em análise';
                $badgeSituacao = 'warning';
                $class = 'table-warning';
                $td = '<td class="text-nowrap"><span class="badge badge-light">Espera de parecer... ['.$instancia.'] '.formatarData($la->created_at).'</span></td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'warning'));
        }

        $LastV .=
           '<tr class="'.$class.'">
                <td>
                   <a href="../propostas/visualizar.php?id='.$projId.'&v='.$la->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver + 1).'</span></a>
                </td>'

          .$td.
                '<td><span class="align-middle badge badge-'.$badgeSituacao.'">'.$la->resultado.'</span></td>'.
                '<td>'.$la->fase_seq.'/'.$la->etapas.'</td>
            </tr>';

        $etapas = $la->etapas;

        if ($la->etapas == $la->fase_seq && $la->resultado == 'a') {
            $todasConcluidas = true;
        }
    }

    $LastV .=
      '</tbody>
    </table>';

    $btnStatus = array_reverse($btnStatus);

    $btnS = [];  // / criando todos os blocos em CINZA
    for ($x = 0; $x <= $etapas - 1; ++$x) {
        array_push($btnS, new Blocos($x, 'secondary'));
    }

    foreach ($btnStatus as $btn) {
        $btnS[$btn->pos - 1] = $btn;
    }

    $progresso =
     '<span class="badge badge-light">Processo ['.$msg1.']<br>
        <div class="btn-group">';

    foreach ($btnS as $btn) {
        $progresso .= '<button type="button" class="btn btn-'.$btn->cor.'" disabled></button>';
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

    return [$progresso, $LastV, $btnAvaliacoes];
}

// echo '<pre>';
//     print_r($user);
// echo '</pre>';

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
            if ($userId == $profId) {
                return '<a><button id="SAP'.$id.'v'.$ver.'" class="btn btn-warning btn-sm mb-2 ml-1" '.$hidden.' onclick="writeNumber(this)"> 🔄 Solicitar alteração </button></a>';
            } else {
                return '';
            }

            // no break
        case 'relatorioParcial':
            // tirar o
            if ($userId == $profId) {
                // Se não for evento
                if ($tipo_exten != 2) {
                    return '
                        <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2 "> 📝 Relatório Parcial </button></a> 
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
                                📝 Relatório Parcial
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
                return '<a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2 ml-4"> 📝 Relatório Final </button></a>';
            } else {
                return '';
            }
            // no break
        case 'declaracao' :
            if ($userId == $profId) {
                return '<a href="./declaracao.php?id='.$id.'"><button class="btn btn-info btn-sm mb-2 ml-2 ">📃 Declaração </button></a>';
            } else {
                return '';
            }
            // no break
        default:
            return '';
    }
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
            } else {
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
            createBT('cancelar', $i, $v, null, null, $t);

    } else {
        return createBT('visualizar', $i, $v);
    }
}

function emExecucao($p, $userId): string
{
    $i = $p->id;
    $v = $p->ver;
    $tipo = $p->tipo_exten;

    $profId = $p->id_prof;
    $relParcialInfo = '';

    $rel_par = Outros::qry("
        select 
            rp.id, 
            rp.last_result,
            rp.publicado,
            rp.created_at
        from 
            relats rp
        where 
            rp.idproj = '".$i."'
            order by 
                rp.created_at desc
        "
    );

    // echo '<pre>';
    // print_r($rel_par);
    // echo '</pre>';
    // exit;

    if ($rel_par) {
        foreach ($rel_par as $rp) {
            $pub = '<span class="badge badge-light ">Em avaliação</span>';

            if ($rp->publicado == 1) {
                $pub = '';

                $relParcialInfo .= '
                    <a href="../relatorio/editarp.php?id='.$rp->id.'" target="_blank">
                        <button class="btn btn-primary btn-sm mb-2">📊 Relatório Parcial '.formatarData($rp->created_at).' </button>
                    </a> &nbsp; ';
            } else {
                if ($rp->last_result == 'r' && $profId == $userId) {
                    $pub = '<span class="badge badge-light">Solicitação de alterações</span>';
                    $linkFeito = '<a href="../relatorio/editarp.php?id='.$rp->id.'" target="_blank">';
                    $relParcialInfo .= $linkFeito.'<button class="btn btn-danger btn-sm mb-2 "> 📊 Relatório Parcial &nbsp;'.formatarData($rp->created_at).'&nbsp;'.$pub.'</button></a> &nbsp; ';
                } else {
                    $relParcialInfo .= '
                    <button 
                        class="btn btn-primary btn-sm mb-2" 
                        disabled 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Relatório em avaliação.">
                            📊 Relatório Parcial '.formatarData($rp->created_at).'&nbsp;'.$pub.' 
                    </button> &nbsp; ';
                }
            }
        }
    }

    $btns = '';
    $btns = createBT('visualizar', $i, $v).' &nbsp; '.
    createBT('relatorioParcial', $i, $v, null, $tipo, null, $userId, $profId).' &nbsp;'.
    $relParcialInfo.
    createBT('declaracao', $i, $v, null, null, null, $userId, $profId);

    return $btns;
}

function adequacoes($p, $user)
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
    $form = $p->form;
    // $profId = $p->id_prof;
    // $userId = $user['id'];
    // $userConfig = $user['config'];

    return
    createBT('editar', $i, $v).'  	&nbsp; '.
    createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
    createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
    createBT('visualizar', $i, $v).'  	&nbsp; '.
    createBT('cancelar', $i, $v);
}

function aguardandoRelatorio($p, $userId)
{
    $i = $p->id;
    $v = $p->ver;
    $profId = $p->id_prof;
    $rel_Infos = '';

    $ids_DirCampus = Campi::getRegistros();
    $usuariosEspecificos = array_merge([
        'bfd757a5-4f2d-4a10-87a8-a872ae69f1fd', // MATHEUS ESCOBOZO GUIZILINI
        'b8fa555f-cedb-47cf-91cc-7581736aac88',  // JOSé ROBERTO DE GÓES GOMES
    ], array_column(
        $ids_DirCampus, 'chef_div_id'
    )
    );

    $rel = Outros::qry(" 
        select 
            r.id, r.tipo, r.publicado, r.created_at, r.last_result 
        from 
            relats r 
        where 
            r.idproj = '".$i."' 
        order by r.created_at desc
    ");

    if (isset($rel)) {
        foreach ($rel as $relatorio) {
            $tipoRel = '';
            $tipoRel = tipoRelatorioIcon($relatorio->tipo);

            $link = in_array($relatorio->tipo, ['fi', 're', 'pr']) ? 'f' : 'p';

            $pub = '<span class="badge badge-light">Em avaliação</span>';
            if ($relatorio->publicado == 1) {
                $pub = '';
                $linkFeito = '<a href="../relatorio/editar'.$link.'.php?id='.$relatorio->id.'" target="_blank">';

                $rel_Infos .= $linkFeito.'<button class="btn btn-primary btn-sm mb-2">'.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$pub.'</button></a> &nbsp; ';
            } else {
                if ($relatorio->last_result == 'r' && $profId == $userId) {
                    $pub = '<span class="badge badge-light">Solicitação de alterações</span>';
                    $linkFeito = '<a href="../relatorio/editar'.$link.'.php?id='.$relatorio->id.'" target="_blank">';
                    $rel_Infos .= $linkFeito.'<button class="btn btn-danger btn-sm mb-2 ml-2">'.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$pub.'</button></a> &nbsp; ';
                } elseif (in_array($userId, $usuariosEspecificos)) {
                    $linkFeito = '<a href="../relatorio/editar'.$link.'.php?id='.$relatorio->id.'" target="_blank">';
                    $rel_Infos .= $linkFeito.'<button 
                            class="btn btn-primary btn-sm mb-2 ml-2"  
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Relatório em avaliação."
                        >'.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$pub.'</button></a> &nbsp; ';
                } else {
                    $rel_Infos .= '
                        <button 
                            class="btn btn-primary btn-sm mb-2 ml-2" 
                            disabled 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Relatório em avaliação."
                        >'.$tipoRel.'&nbsp;'.formatarData($relatorio->created_at).'&nbsp;'.$pub.'</button> &nbsp; ';
                }
            }
        }
    }

    if ($userId == $profId) {
        return
            // tirar o
            createBT('visualizar', $i, $v).' &nbsp; '.
            '<a href="../relatorio/index.php?id='.$i.'" class="btn btn-success btn-sm mb-2 mr-2">📝 Relatório Final</a>'.
            $rel_Infos.
            createBT('declaracao', $i, $v, null, null, null, $userId, $profId);
    } elseif (in_array($userId, $usuariosEspecificos)) {
        return createBT('visualizar', $i, $v).$rel_Infos;
    //    createBT('alteraSAP', $i, $v).' &nbsp; ';
    } else {
        return createBT('visualizar', $i, $v);
        //    createBT('alteraSAP', $i, $v).' &nbsp; ';
    }
}

function finalizado($p, $userId): string
{
    $i = $p->id;
    $v = $p->ver;
    $profId = $p->id_prof;
    $rel_Infos = '';

    $rel_par = Outros::qry(" select 
                                r.id, r.tipo, r.publicado, r.created_at
                            from 
                                relats r 
                            where 
                                r.idproj = '".$i."' 
                            order by r.created_at desc
                        ");
    if (isset($rel_par)) {
        foreach ($rel_par as $rp) {
            $tipoRel = '';
            $tipoRel = tipoRelatorioIcon($rp->tipo);

            $pub = '<span class="badge badge-light">Em avaliação</span>';
            if ($rp->publicado == 1) {
                $pub = '';

                $link = in_array($rp->tipo, ['fi', 're', 'pr']) ? 'f' : 'p';
                $linkFeito = '<a href="../relatorio/editar'.$link.'.php?id='.$rp->id.'" target="_blank">';

                if ($rp->tipo == 'im') {
                    $tipoRel = '📊 Relatório Final (importado) ';
                    $linkFeito = '<a href="../upload/uploads/'.$rp->caminho.'" target="_blank">';
                }

                $rel_Infos .= $linkFeito.'<button class="btn btn-primary btn-sm mb-2 ml-2">'.$tipoRel.'&nbsp;'.formatarData($rp->created_at).''.$pub.'</button>';
            } else {
                $rel_Infos .= '<button class="btn btn-primary btn-sm mb-2 disabled ml-2">'.$tipoRel.'&nbsp;'.formatarData($rp->created_at).''.$pub.'</button>';
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