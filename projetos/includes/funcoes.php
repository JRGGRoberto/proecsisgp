<?php

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
