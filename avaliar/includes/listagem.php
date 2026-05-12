<?php

require '../vendor/autoload.php';

  $mensagem = '';
  if(isset($_GET['status'])){
    switch ($_GET['status']) {
      case 'success':
        $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
        break;

      case 'error':
        $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
        break;
    }
  }

  $toPublicar = '';
  if ($bossM->nivel_adm == 1){
    foreach($projToPublicarL4 as $proj){
      $toPublicar .= '<tr>
                        <td>'.$proj->titulo.'</td>
                        <td>'.$proj->tipo_extensao.'</td>
                        <td>'.$proj->area_cnpq.'</td>
                        <td>'.date('d/m/Y',strtotime($proj->vigen_ini)).'</td>
                        <td>'.date('d/m/Y',strtotime($proj->vigen_fim)).'</td>
                        <td><a href="proj_av.php?id='.$proj->id_proj.'">
                    <button type="button" class="btn btn-primary">Avaliar</button></a>
                      </tr>';
    }

    $toPublicar = strlen($toPublicar) ? $toPublicar : '<tr>
                                                         <td colspan="8" class="text-center">
                                                                Nenhum registro encontrado
                                                         </td>
                                                      </tr>';
  }



  $resultados = '';

  foreach($projAvaliar as $proj){

    $resultados .= '<tr>
                      <td>'.$proj->titulo.'</td>
                      <td>'.$proj->tipo_extensao.'</td>
                      <td>'.$proj->area_cnpq.'</td>
                      <td>'.date('d/m/Y',strtotime($proj->vigen_ini)).'</td>
                      <td>'.date('d/m/Y',strtotime($proj->vigen_fim)).'</td>
                      <td><a href="proj_av.php?id='.$proj->id_proj.'">
                  <button type="button" class="btn btn-primary">Avaliar</button></a>
                    </tr>';
  }

  $resultados = strlen($resultados) ? $resultados : '<tr>
                                                       <td colspan="8" class="text-center">
                                                              Nenhum registro encontrado
                                                       </td>
                                                    </tr>';

  $jav = '';
  foreach ($projAvaliados as $prja){
    $jav .=  '<tr>
                 <td><a href="proj_ava.php?id='.$prja->id_proj.'" class="btn btn-outline-info btn-block">'. $prja->titulo .'</a></td>
             </tr>';
  }

  if($jav == ''){
    $jav .=  '<td colspan="6" class="text-center">
                 <td>Nenhum registro encontrado</td>
             </tr>';
  }



?>
<main>

  <?=$mensagem?>

  <?php  if ($bossM->nivel_adm == 1){ ?>
  <section>
  <h2>Projetos a avaliar (Publicar)</h2>
    <table class="table bg-light mt-3 table-hover">
        <thead class="table-light">
          <tr>
            <th>Titulo</th>
            <th>Proposta</th>
            <th>Grande Área</th>
            <th>Início</th>
            <th>Término</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
            <?=$toPublicar?>
        </tbody>
    </table>
    <hr>
    <section>


    <?php  } ?>

  <section>
  <h2>Projetos a avaliar</h2>
    <table class="table bg-light mt-3 table-hover">
        <thead class="table-light">
          <tr>
            <th>Titulo</th>
            <th>Proposta</th>
            <th>Grande Área</th>
            <th>Início</th>
            <th>Término</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
            <?=$resultados?>
        </tbody>
    </table>
    <hr>
    <section>

    <table class="table table-light table-borderless">
        <thead class="table-light">
          <tr>
            <th>Projetos já avaliados</th>
          </tr>
          
        </thead>
        <tbody>
          <?=$jav?>
            
        </tbody>
    </table>

  </section>

    

</main>