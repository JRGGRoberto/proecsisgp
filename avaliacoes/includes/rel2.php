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
            <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id.'">📃 '.$ava->titulo.'</a></div>
            <div class="col">'.tipoRelatori($ava->tipo).'</div>
        </div>
      </div>
      <div id="p'.$ava->id.'" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <h5>Tipo de Proposta</h5>

          <div class="col">
          
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
