<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$res = '';

foreach ($lista as $l) {
    $prj1 = explode(' ', trim($l->prj1));
    $prj2 = explode(' ', trim($l->prj2));
    $prj3 = explode(' ', trim($l->prj3));
    //    $prj4 = explode(' ', trim($l->prj4));

    $do1 = '';
    $do2 = '';
    $do3 = '';
    $do4 = '';

    $qntProj = 0;
    $qntProjDone = 0;

    if (isset($prj1[1])) {
        ++$qntProj;
        if ($prj1[1] == 1) {
            $do1 = '<div class="col"><button type="button" class="btn btn-success" >'.strtoupper(substr($prj1[0], 0, -4)).'</button><br><sup>'.$prj1[2].'/100</sup></div>';
            ++$qntProjDone;
        } else {
            $do1 = '<div class="col"><button type="button" class="btn btn-outline-secondary">'.strtoupper(substr($prj1[0], 0, -4)).'</button></div>';
        }
    } else {
        $do1 = '<div class="col"></div>';
    }

    if (isset($prj2[1])) {
        ++$qntProj;
        if ($prj2[1] == 1) {
            $do2 = '<div class="col"><button type="button" class="btn btn-success" >'.strtoupper(substr($prj2[0], 0, -4)).'</button><br><sup>'.$prj2[2].'/100</sup></div>';
            ++$qntProjDone;
        } else {
            $do2 = '<div class="col"><button type="button" class="btn btn-outline-secondary">'.strtoupper(substr($prj2[0], 0, -4)).'</button></div>';
        }
    } else {
        $do2 = '<div class="col"></div>';
    }

    if (isset($prj3[1])) {
        ++$qntProj;
        if ($prj3[1] == 1) {
            $do3 = '<div class="col"><button type="button" class="btn btn-success">'.strtoupper(substr($prj3[0], 0, -4)).'</button><br><sup>'.$prj3[2].'/100</sup></div>';
            ++$qntProjDone;
        } else {
            $do3 = '<div class="col"><button type="button" class="btn btn-outline-secondary">'.strtoupper(substr($prj3[0], 0, -4)).'</button></div>';
        }
    } else {
        $do3 = '<div class="col"></div>';
    }

    if (isset($prj4[1])) {
        ++$qntProj;
        if ($prj4[1] == 1) {
            $do4 = '<div class="col"><button type="button" class="btn btn-success">'.$prj4[0].'</button><br><sup>'.$prj4[2].'/100</sup></div>';
            ++$qntProjDone;
        } else {
            $do4 = '<div class="col"><button type="button" class="btn btn-outline-secondary">'.$prj4[0].'</button></div>';
        }
    } else {
        $do4 = '<div class="col"></div>';
    }

    $res .= '<div class="row">';
    $res .= '<div class="col-5"><strong>'.$l->nome.'</strong> ('.$qntProjDone.'/'.$qntProj.')<br><sub>'.$l->campus.' - '.$l->colegiado.'</sub><br><sup><a href="mailto:'.$l->email.'" target="_blank">'.$l->email.'</a></sup></div>';
    $res .= $do1;
    $res .= $do2;
    $res .= $do3;
    $res .= $do4;

    $res .= '</div><div><hr></div>';
}

?>
<main>
  <h2 class="mt-0">ADM - Avaliadores - projetos Microcredênciais</h2>
  
  <section>

  <hr>
    <?php echo $res; ?>
    
  </section>
  
</main>






