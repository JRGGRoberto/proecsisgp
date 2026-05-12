<?php

include '../includes/paginacao.php';

function tipoRelatori($tp)
{
    switch ($tp) {
        case 'fi':
            return 'Final';
            break;
        case 're':
            return 'Final com pedido de renovação';
            break;
        case 'pr':
            return 'Final com pedido de prorrogação';
            break;
        case 'pa':
            return 'Parcial';
            break;
        default:
            return 'Tipo não definido';
            break;
    }
}

$qnt1 = 0;

$resultados = '<div id="accordion">';
foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $resultados .= '
      <div class="card mt-2">
      <div class="card-header">
        <div class="row">
            <div class="col-sm-4"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id.'">📃 '.$ava->titulo.'</a></div>
            <div class="col">'.$ava->nome_prof.'</div>
            <div class="col">'.$ava->protocolo.'</div>
            <div class="col">'.tipoRelatori($ava->tipo).'</div>
            <div class="col"><span class="badge badge-success">Etapa:'.$ava->fase_seq.'/'.$ava->fases.'</span></div>
            
        </div>
      </div>
      <div id="p'.$ava->id.'" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <h5>Tipo de Proposta</h5>

          <div class="col">


            <div class="d-flex flex-row-reverse ">
              <div class="p-1"></div>
              <a href="../forms/index.php?tp=r&i='.$ava->id.'&p='.$ava->idproj.'&v='.$ava->pver.'"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Avaliar/Visualizar relatório</button></a>
              <div class="p-1"></div>
              
              <a href="../propostas/visualizar.php?id='.$ava->idproj.'&v='.$ava->pver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
              <div class="p-1"></div>
            </div>

          
          </div>
        </div>
      </div>
    </div>';
}
$resultados .= '</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

$resultados .= '<section>
    <div class="row mt-2 align-bottom">
      <div class="col">'
        .$paginacao.
'      </div>
    </div>
  </section>';
