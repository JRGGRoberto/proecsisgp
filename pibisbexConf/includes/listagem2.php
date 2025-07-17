<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$res = '';

foreach ($lista as $l) {
    $prj1 = explode(' ', $l->prj1);
    $prj2 = explode(' ', $l->prj2);
    $prj3 = explode(' ', $l->prj3);
    $prj4 = explode(' ', $l->prj4);

    $do1 = '';
    $do2 = '';
    $do3 = '';
    $do4 = '';
    /*
        $do1 = $prj1[1] == '1' ? 'success' : '';
        $do2 = $prj2[1] == '1' ? 'success' : '';
        $do3 = $prj3[1] == '1' ? 'success' : '';
        $do4 = $prj4[1] == '1' ? 'success' : '';
    */
    $res .= '<div class="row">';
    $res .= '<div class="col-4"><strong>'.$l->nome.'</strong><br><sub>'.$l->campus.' - '.$l->colegiado.'</sub><br><sup><a href="'.$l->email.'">'.$l->email.'</a></sup></div>';
    $res .= '<div class="col"><button type="button" class="btn btn-'.$do1.'">'.$prj1[0].'</button></div>';
    $res .= '<div class="col"><button type="button" class="btn btn-'.$do2.'">'.$prj2[0].'</button></div>';
    $res .= '<div class="col"><button type="button" class="btn btn-'.$do3.'">'.$prj3[0].'</button></div>';
    $res .= '<div class="col"><button type="button" class="btn btn-'.$do4.'">'.$prj4[0].'</button></div>';
    $res .= '</div><div><hr></div>';
}

// id, nome, email, campus, colegiado, prj1, prj2, prj3, prj4

?>
<main>
  <h2 class="mt-0">ADM - Avaliadors - projetos PIBIS / PIBEX</h2>
  
  <section>

  <hr>
    <?php echo $res; ?>
    
  </section>
  
</main>




