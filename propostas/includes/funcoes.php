<?php

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

$userId = $user['id'];


function dt($dt)
{
    return substr($dt, 8, 2).'/'.substr($dt, 5, 2).'/'.substr($dt, 0, 4);
}

function resumirTexto(string $texto, int $limite = 256): string
{
    $textoLimpo = trim(strip_tags($texto));
    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    return substr($textoLimpo, 0, $limite).' <span class="badge badge-pill badge-success">(continua...)</span>';
}

//Monta tabela de avaliações dos projetos
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
        switch ($la->tp_instancia){
            case 'ca':
                $la->tp_instancia = 'Chefe de Divisão';
                break;
            case 'ce':
                $la->tp_instancia = 'Dir. de Centro de Área';
                break;
            case 'co':
                $la->tp_instancia = 'Coord. de Colegiado';
                break;
            case 'pf':
                $la->tp_instancia = 'Professor Parecerista';
                break;
            case 'dc':
                $la->tp_instancia = 'Dir. de Campus';
                break;
            default: 
                $la->tp_instancia = 'Cargo não definido';
                break;
        };

        switch ($la->resultado) {
            case 'a':
                $la->resultado = 'Aprovado';
                $badgeSituacao = 'success';

                $class = 'table-success';
                $td = '<td class="text-nowrap"><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$la->tp_instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'success')); // 'primary')); //
                break;
                
            case 'r':
                $la->resultado = 'Solicitação de alterações';
                $badgeSituacao = 'danger';

                $class = 'table-danger';
                $td = '<td class="text-nowrap"><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$la->tp_instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'danger'));
                break;
            default:
                $la->resultado = 'Em análise';
                $badgeSituacao = 'warning';
                $class = 'table-warning';
                $td = '<td class="text-nowrap"><span class="badge badge-light">Espera de parecer... ['.$la->tp_instancia.'] '.dt($la->created_at).'</span></td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'warning'));
        }

        $LastV .=
           '<tr class="'.$class.'">
                <td>
                   <a href="../projetos/visualizar.php?id='.$projId.'&v='.$la->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver + 1).'</span></a>
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


function createBT($tipo, $id, $ver, $form = null, $tipo_exten = null, $titulo = null, $userId = null, $profId = null): string
{
    switch ($tipo) {
        case 'submeter':
            return '<button id="sub'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter</button>';
        case 'submeterNovamente':
            return '<button id="Alt'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter novamente</button>';
        case 'editar':
            return '<a href="editar.php?id='.$id.'&v='.$ver.'"><button class="btn btn-success btn-sm mb-2">📝 Editar</button></a>';
        case 'excluir':
            return '<button id="del'.$id.'v'.$ver.'" class="btn btn-danger  btn-sm mb-2" onclick="writeNumber(this)">🗑 Excluir</button>';
        case 'visualizar':
            return '<a href="visualizar.php?id='.$id.'&v='.$ver.'&w=1" target="_blank"><button class="btn btn-success btn-sm mb-2"> 📄 Projeto</button></a>';
            // <a href="cancelar.php?id='.$id.'&v='.$ver.'&w=1" target="_blank"></a>
       case 'cancelar':
            return '
              <button class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalCancel'.$id.'">
                  Cancelar
              </button>
              
              <div class="modal fade" id="modalCancel'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel'.$id.'">Confirmar Cancelamento</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Tem certeza que deseja cancelar o projeto "<strong>'.$titulo.'</strong>"?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                      <a href="cancelar.php?id='.$id.'&v='.$ver.'">
                        <button class="btn btn-danger btn-sm">Confirmar Cancelamento</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            ';
        case 'adequacoes':
            return '<a href="../forms/'.$form.'/vista.php?p='.$id.'&v='.($ver - 1).'"><button class="btn btn-danger btn-sm mb-2" >📑 Informações de adequações</button></a>';
        case 'relatorioParcial':
            // if ($tipo_exten != 2) { 
            //   return  '
            //     <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório Parcial</button></a> &nbsp; 
            //   ';
            // }
            if ($userId == $profId) {
                if ($tipo_exten != 2) { 
                    return  '
                        <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório Parcial</button></a> &nbsp; 
                    ';     
                } else { 
                    //Evento: 
                    return '
                        <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2" data-toggle="tooltip" data-placement="bottom" title="Não é possível criar relatório parcial para Eventos." disabled>📊 Relatório Parcial</button></a> &nbsp; 
                    ';
                } 
            }  else { 
                return '';
            }
        
        case 'relatorioFinal':
            if ($userId == $profId) {
                return  '<a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório Final</button></a> &nbsp; ';
            } else { 
                return '';
            }
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
    //$userConfig = $user['config'];
    if ($userId == $profId) {   
        return 
        createBT('submeter', $i, $v).'  	&nbsp; '.
        createBT('editar', $i, $v).'  	&nbsp; '.
        createBT('visualizar', $i, $v).' &nbsp; '.
        createBT('excluir', $i, $v)
        ;
    } 
    else {
        return "";
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

    $osCabeca = [1,2,3,4]; //só a elite


    if ($userId == $profId) {
        if ($p->resultado == 'r') {
            return 
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('cancelar', $i, $v, null, null, $t);
        } elseif ($p->resultado == 'n') {
            if ($p->edt == 0) {
                return 
                createBT('visualizar', $i, $v). 
                createBT('cancelar', $i, $v).'  	&nbsp; ';
            } else {
                return 
                createBT('visualizar', $i, $v).'  	&nbsp; '.
                createBT('editar', $i, $v).'  	&nbsp; '.
                createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
                createBT('adequacoes', $i, $v, $form).'  	&nbsp; '.
                createBT('cancelar', $i, $v);
            }
        } elseif ($p->resultado == 'e') {
            return 
                createBT('visualizar', $i, $v). 
                createBT('cancelar', $i, $v).'  	&nbsp; ';
        }
    } elseif (in_array($userConfig, $osCabeca)) {
        return 
            createBT('visualizar', $i, $v);    
        } 
    else {
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
            createBT('cancelar', $i, $v, null, null, $t);
    } else {
        return 
            createBT('visualizar', $i, $v);
    }
}

function emExecucao($p, $userId): string
{
    $i = $p->id;
    $v = $p->ver;
    $tipo = $p->tipo_exten;
    $profId = $p->id_prof;

    return (
        createBT('visualizar', $i, $v) . ' &nbsp;'. 
        createBT('relatorioParcial', $i, $v, null, $tipo, null, $userId, $profId) 
        // createBT('cancelar', $i, $v).' &nbsp; '
    );
    // if ($tipo != 2)
    //     return (
    //       createBT('cancelar', $i, $v).' &nbsp; '.
    //       createBT('visualizar', $i, $v) . ' &nbsp;'. 
    //       createBT('relatorioParcial', $i, $v)
    //     );
    // else { 
    //   return (
    //       createBT('cancelar', $i, $v).' &nbsp; '.
    //       createBT('visualizar', $i, $v)
    //   );
    // }
}

function finalizado($p, $userId): string
{
    $i = $p->id;
    $v = $p->ver;
    $profId = $p->id_prof;

    return 
      createBT('visualizar', $i, $v).' &nbsp; '.
      createBT('relatorioFinal', $i, $v, null, null, null, $userId, $profId);         
}

function cancelado($p): string
{
    $i = $p->id;
    $v = $p->ver;
    return createBT('visualizar', $i, $v);
}
