<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

require '../includes/msgAlert.php';
require './detalhe.php';

$qnt1 = 0;
$resultados = '';

function tipoRelatori($tp)
{
    switch ($tp) {
        case 'fi':
            return 'Final';
            break;
        case 're':
            return 'Final renovação';
            break;
        case 'pr':
            return 'Final prorrogação';
            break;
        case 'pa':
            return 'Parcial';
            break;
        default:
            return 'Tipo não definido';
            break;
    }
}

function notNull($valor)
{
    if ($valor == null || $valor == '') {
        return '<span class="badge badge-secondary">Relatorio excluído</span>';
    } else {
        return $valor;
    }
}

foreach ($historicoRel as $ava) {
    ++$qnt1;
    $estiloD = '';
    $cor = $ava->resultado == 'r' ? 'danger' : 'success';
    $link = '';
    if ($ava->titulo == null || $ava->titulo == '') {
        $link = '<span class="badge badge-secondary">Relatorio excluído</span>';
    } else {
        $link = '<a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id.'">📃 '.$ava->titulo.'</a>';
    }

    $titulo = $ava->titulo;
    if ($ava->ver > 0) {
        $titulo .= ' [Versão: '.($ava->ver + 1).']';
    }

    $resultados .= '
      <div class="card mt-2">
        <div class="card-header">
          <div class="row">
            <div class="col-sm-4">'.$link.'</div>
            <div class="col-sm-2">'.notNull($ava->nome_prof).'</div>
            <div class="col-sm-2">'.$ava->ava_comentario.'</div>
            <div class="col-sm-1"><span class="badge badge-info">'.tipoRelatori($ava->tipo).'</span></div>
            <div class="col-sm-1"><span class="badge badge-'.$cor.' ">'.$ava->etapa.'/'.$ava->etapas.'</span></div>
            <div class="col-sm-1"><span class="badge">'.$ava->dt.'<br>'.$ava->hora.'</span></div>
          </div>
        </div>
        <div id="p'.$ava->id.'" class="collapse">
          <div class="card-body">
            <p>'.prnDetalhe($ava->id_relat, $ava->tp_relatorio).'</p>

          </div>
        </div>
      </div>
    ';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Avaliações de relatórios realizados</h2>
  
  <?php echo $msgAlert; ?>

  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col">
          <label>Buscar por titulo</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?php echo $busca; ?>"  id="titulo"  onchange="showLimpar();">
        </div>
<!--
        <div class="col">
          <label>Buscar Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="< ?=$colegiado?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="< ?=$centro?>" id="centro" onChange="showLimpar();">
        </div>

-->
        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>

      </div>

    </form>

  </section>

  <section>

    
    <?php echo $resultados; ?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?php echo $paginacao; ?>
      </div>
    </div>
  </section>
</main>




