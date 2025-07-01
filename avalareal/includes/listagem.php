<?php

// require '../vendor/autoload.php';
// use \App\Entity\Colegiado;

use App\Entity\Avaliacoes;
use App\Session\Login;

$user = Login::getUsuarioLogado();

function dt($dt)
{
    return substr($dt, 8, 2).'/'.substr($dt, 5, 2).'/'.substr($dt, 0, 4).'<br>'.substr($dt, -9);
}

require '../includes/msgAlert.php';

$qnt1 = 0;
$resultados = '<div id="accordion">';
foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $estiloD = '';

    if ($ava->ver == 0) {
        $progresso = '<span class="badge badge-info">Versão inicial</span>';
    } else {
        $progresso = '<span class="badge badge-info">'.($ava->ver + 1).'° versão</span>';
    }

    $where = 'id_proj = "'.$ava->id_proj.'"';
    $order = 'ver desc, fase_seq desc';
    $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);
    $LastV =
       '<table class="table table-bordered table-sm">
        <thead class="thead-dark">
          <tr>
            <th>Projeto</th>
            <th>Relatório <a href="../prnRelatorios/index.php?id='.$ava->id_proj.'" target="_blank"><span class="badge badge-secondary">Prn All🖨️</span></a></th>
            <th>Parte</th>
          </tr>
        </thead>
        <tbody>';
    $a = 0;
    $tp_proposta = ['?', 'Curso', 'Evento', 'Prestação de serviço', 'Programa', 'Projeto'];
    foreach ($ListaVerAnts as $la) {
        ++$a;
        $class = '';
        $td = '';
        switch ($la->resultado) {
            case 'a':
                $class = 'table-success';
                $td = '<td><a href="../forms/'.$la->form.'/vista.php?p='.$ava->id_proj.'&v='.$la->ver.'" target="_blank">📄 </a></td>';
                break;
            case 'r':
                $class = 'table-danger';
                $td = '<td><a href="../forms/'.$la->form.'/vista.php?p='.$ava->id_proj.'&v='.$la->ver.'" target="_blank">📄 </a></td>';
                break;
            default:
                $class = 'table-warning';
                $td = '<td>➖</td>';
        }
        $LastV .=
        '<tr class="'.$class.'">
         <td><a href="../projetos/visualizar.php?id='.$ava->id_proj.'&v='.$la->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver + 1).'</span></a></td>'

          .$td.

          '<td>'.$la->fase_seq.'/'.$la->etapas.'</td>
        </tr>';
    }
    $LastV .=
      '</tbody>
     </table>';

    if ($a == 0) {
        $LastV = '';
    }

    $resultados .= '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id_ava.'">📃 '.$ava->titulo.'</a></div>
        <div class="col-sm-5">Submetido para o colegidado de <span class="badge badge-success">'.$ava->colegiado.'</span></div>
        <div class="col-sm-1">
           '.
           $progresso
           .'
        </div>
        <div class="col-sm-1"><span class="badge">'.dt($ava->created_at).'</span></div>

     </div>
  </div>
    <div id="p'.$ava->id_ava.'" class="collapse" data-parent="#accordion">
      <div class="card-body">


        <h5>Tipo de Proposta</h5>

        <div class="form-group">
            <input type="text" class="form-control" name="tp_proposta" value="'.$tp_proposta[$ava->tipo_exten].'" readonly>
        </div>
      
  
        <h5>Identificação da Proposta</h5>
     
        <div class="form-group">
          <label>Título</label>
          <input type="text" class="form-control" name="coordNome" value="'.$ava->titulo.'" readonly="">
        </div>
      
        <div class="form-group">
          <label>Proponente</label>
          <input type="text" class="form-control" name="coordNome" value="'.$ava->nome_prof.'" readonly="">
        </div>
      
        <div class="form-group">
          <label>Colegiado de Curso</label>
          <input type="text" class="form-control" name="coordNome" value="'.$ava->colegiado.'" readonly="">
        </div>
        
        <div class="row">
        
          <div class="col">
            <div class="form-group">
              <label for="area_extensao">Área de extensão</label>
              <input type="text" class="form-control" value="'.$ava->area_extensao.'" readonly>
            </div>
          </div>
        
          <div class="col">
            <div class="form-group">
              <label for="linh_ext">Linha de  extensão</label>
              <input type="text" class="form-control" value="'.$ava->linh_ext.'" readonly>
            </div>
          </div>
    
        </div>    


        <div class="row my-2">
        <div class="col-2">
        '.$LastV.'
        </div>
        <div class="col">
         
        </div>
      </div>





        <hr>
        
          <div class="d-flex flex-row-reverse ">
            <div class="p-1"></div>
            <a href="../forms/index.php?i='.$ava->id_ava.'&p='.$ava->id_proj.'&v='.$ava->ver.'"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Avaliar</button></a>
            <div class="p-1"></div>
            <a href="../projetos/visualizar.php?id='.$ava->id_proj.'&v='.$ava->ver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar</button></a>
            <div class="p-1"></div>
          </div>
          
          
      </div>
    </div>
           
        </div>';
}
$resultados .= '</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Avaliações a serem realizadas</h2>
  
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
          <input type="text" name="colegiado" class="form-control form-control-sm" value="<?php echo $colegiado; ?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="<?php echo $centro; ?>" id="centro" onChange="showLimpar();">
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


  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Confirmação de exclusão</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Não é possível excluir este registro.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- The Modal -->



<script>
  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  const btnX = document.getElementById("limpar");

  btnOpen.onclick = function(){
    modal.showModa();
  }


  

  btnX.hidden = true;
  
  function showLimpar(){
    var titulo      = document.getElementById('titulo').value;
  //  var campus    = document.getElementById('campus').value;
  //  var centro     = document.getElementById('centro').value;
  //  var colegiado = document.getElementById('colegiado').value;

  //  if((titulo.length > 0 ) | (campus.length > 0)| (centro.length > 0)| (colegiado.length > 0) ) {
  if( titulo.length > 0 ) {
      btnX.hidden = true;
    }
  }

  showLimpar();
  
</script>


