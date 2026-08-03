<?php

require '../includes/msgAlert.php';
use App\Entity\Avaliacoes;

$qnt1 = 0;
$resultados = '';
foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $estiloD = '';
    $cor = '';

    $info = 'Etapa '.$ava->fase_seq.' ['.$ava->tp_instancia.']';

    if ($ava->resultado == 'r') {
        $cor = 'warning';
        $progresso = '<span class="badge badge-warning"> ↩️ Solicitação de revisão <br>'.$info.'</span>';
    } elseif ($ava->resultado == 'a') {
        $progresso = '<span class="badge badge-success"> 🆗 Favorável <br>'.$info.'</span>';
        $cor = 'success';
    } else {
        $progresso = '<span class="badge badge-danger">Error</span>';
        $cor = 'danger';
    }

    /* ------------------ */
    $titulo = $ava->titulo;
    if ($ava->ver > 0) {
        $titulo .= ' [Versão: '.($ava->ver + 1).']';
    }

    $where = 'id_proj = "'.$ava->id_proj.'"';
    $order = 'ver desc, fase_seq desc';
    $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);
    $LastV = '
    <table class="table table-bordered table-sm">
      <thead class="thead-dark">
        <tr>
          <th>Projeto</th>
          <th>Relatório <a href="../prnRelatorios/index.php?id='.$ava->id_proj.'" target="_blank"><span class="badge badge-secondary">Prn All🖨️</span></a></th>
          <th>Parte</th>
        </tr>
      </thead>
      <tbody>
    ';
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
         <td><a href="../propostas/visualizar.php?id='.$ava->id_proj.'&v='.$la->ver.'&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver + 1).'</span></a></td>'

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
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id_ava.'">📃 '.$titulo.'</a></div>
        <div class="col-sm-7">
           '.
           $progresso
           .'

            <div class="d-flex flex-row-reverse ">
              <div class="p-1"></div>
              <a href="../forms/'.$ava->form.'/vista.php?p='.$ava->id_proj.'&v='.$ava->ver.'" target="_blank"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Ver avaliação</button></a>
              <div class="p-1"></div>
              <a href="../propostas/visualizar.php?id='.$ava->id_proj.'&v='.$ava->ver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
              <div class="p-1"></div>
            </div>
           

        </div>
     </div>
     <div id="p'.$ava->id_ava.'" class="collapse" data-parent="#accordion">
        <div class="card-body">hi
        </div>
     </div>
     
  </div>



</div>    

          
';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

$resultados .=
'<section>
    <div class="row mt-2 align-bottom">
      <div class="col">'
        .$paginacao.
'      </div>
    </div>
  </section>';

?>

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


