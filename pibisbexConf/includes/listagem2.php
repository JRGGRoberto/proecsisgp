<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$res = '';

foreach ($lista as $l) {
    $prj1 = explode(' ', trim($l->prj1));
    $prj2 = explode(' ', trim($l->prj2));
    $prj3 = explode(' ', trim($l->prj3));
    $prj4 = explode(' ', trim($l->prj4));

    $do1 = '';
    $do2 = '';
    $do3 = '';
    $do4 = '';

    $res .= '<div class="row">';
    $res .= '<div class="col-4"><strong>'.$l->nome.'</strong><br><sub>'.$l->campus.' - '.$l->colegiado.'</sub><br><sup><a href="mailto:'.$l->email.'" target="_blank">'.$l->email.'</a></sup></div>';

    if (isset($prj1[1])) {
        $do1 = ($prj1[1] == 1) ?
           '<div class="col"><button type="button" class="btn btn-success" >'.$prj1[0].'</button><br><sup>'.$prj1[2].'/190</sup></div>' :
           '<div class="col"><button type="button" class="btn btn-outline-secondary">'.$prj1[0].'</button></div>';
    } else {
        $do1 = '<div class="col"></div>';
    }

    if (isset($prj2[1])) {
        $do2 = ($prj2[1] == 1) ?
           '<div class="col"><button type="button" class="btn btn-success"  data-target="#myModal">'.$prj2[0].'</button><br><sup>'.$prj2[2].'/190</sup></div>' :
           '<div class="col"><button type="button" class="btn btn-outline-secondary">'.$prj2[0].'</button></div>';
    } else {
        $do2 = '<div class="col"></div>';
    }

    if (isset($prj3[1])) {
        $do3 = ($prj3[1] == 1) ?
           '<div class="col"><button type="button" class="btn btn-success">'.$prj3[0].'</button><br><sup>'.$prj3[2].'/190</sup></div>' :
           '<div class="col"><button type="button" class="btn btn-outline-secondary">'.$prj3[0].'</button></div>';
    } else {
        $do3 = '<div class="col"></div>';
    }

    if (isset($prj4[1])) {
        $do4 = ($prj4[1] == 1) ?
          '<div class="col"><button type="button" class="btn btn-success">'.$prj4[0].'</button><br><sup>'.$prj4[2].'/190</sup></div>' :
          '<div class="col"><button type="button" class="btn btn-outline-secondary">'.$prj4[0].'</button></div>';
    } else {
        $do4 = '<div class="col"></div>';
    }

    $res .= $do1;
    $res .= $do2;
    $res .= $do3;
    $res .= $do4;

    $res .= '</div><div><hr></div>';
}

// id, nome, email, campus, colegiado, prj1, prj2, prj3, prj4

?>
<main>
  <h2 class="mt-0">ADM - Avaliadores - projetos PIBIS / PIBEX</h2>
  
  <section>

  <hr>
    <?php echo $res; ?>
    
  </section>
  
</main>


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>




