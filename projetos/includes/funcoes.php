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

function montarTblEProgress(array $ListaVerAnts, $projId, $msg1)
{
    $LastV =
        '<table class="table table-bordered table-sm">
          <thead class="thead-dark">
            <tr>
              <th>Projeto</th>
              <th>Parecere(s) <a href="../prnRelatorios/index.php?id='.$projId.'" target="_blank"><span class="badge badge-secondary">Prn All🖨️</span></a></th>
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

        switch ($la->resultado) {
            case 'a':
                $class = 'table-success';
                $td = '<td><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$la->tp_instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'success')); // 'primary')); //
                break;
            case 'r':
                $class = 'table-danger';
                $td = '<td><a href="../forms/'.$la->form.'/vista.php?p='.$projId.'&v='.$la->ver.'" target="_blank">📄</a> '.$la->tp_instancia.'</td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'danger'));
                break;
            default:
                $class = 'table-warning';
                $td = '<td><span class="badge badge-light">Espera de parecer... ['.$la->tp_instancia.'] '.dt($la->created_at).'</span></td>';

                array_push($btnStatus, new Blocos($la->fase_seq, 'warning'));
        }

        $LastV .=
           '<tr class="'.$class.'">
                <td>
                   <a href="../projetos/visualizar.php?id='.$projId.'&v='.$la->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver + 1).'</span></a>
                </td>'

          .$td.

                '<td>'.$la->fase_seq.'/'.$la->etapas.'</td>
            </tr>';

        $etapas = $la->etapas;
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

    return [$progresso, $LastV];
}
