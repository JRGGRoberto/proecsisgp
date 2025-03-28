<?php

  require('../includes/msgAlert.php');

  $resultados = '';
  if ($relQnt == 0){
    $resultados = 'Não há relatórios de execução realizados.';
  } else {
    foreach($relatorios as $rel){
      $excluir = '';
      $editar = '<a href="editar1.php?id='.$rel->id.'" class="card-link">Editar</a>';
      if($rel->tramitar == 0){
        $excluir = '<a href="excluir1.php?id='.$rel->id.'" class="card-link">Excluir</a>';
      } else {
        if(is_null($rel->ava_comentario)){
          $excluir = ' Relatório espera de avaliação';
          $editar = ' <a href="editar1.php?id='.$rel->id.'" class="card-link">Visualizar</a> ';
        }
      }
      
      $resultados .= '<div class="card">';
      $resultados .= '<div class="card-body">';
      $resultados .= '<h5 class="card-title">Relatório Parcial referente '. formatData($rel->periodo_ini).' à '. formatData($rel->periodo_fim).'</h5>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades realizadas</h6>';
      $resultados .= '<p class="card-text">'.$rel->atvd_per.'</p>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Alterações</h6>';
      $resultados .= '<p class="card-text">'.$rel->alteracoes.'</p>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades para o próximo período</h6>';
      $resultados .= '<p class="card-text">'.$rel->atvd_prox_per.'</p>';
      $resultados .= '<p class="card-text"><small class="text-muted">Cadastrado em '.formatData($rel->created_at).'</small></p>';
      $resultados .= $editar;
      $resultados .= $excluir; 
      $resultados .= '</div>';
      $resultados .= '</div>';
    }

  }

?>


<main>
  <h2 class="mt-0">Relatórios</h2>
  <hr>

  
  <div class="form-group">
    <div>
      <h5>Título da proposta</h5>
      <input type="text" class="form-control" value="<?=$obProjeto->titulo; ?>" readonly><br>
    </div>
    <div class="row">

          <div class="col-3">
            <div class="form-group">
              <label>Modalidade</label>
              <input type="text" class="form-control" value="<?=$tipo; ?>" readonly>
              
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_ini, 0, 10); ?>" readonly>
            </div>
          </div>
          
          <div class="col-2">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_fim, 0, 10); ?>" readonly>
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
               <label>Projeto</label><br>
                <a href="../projetos/visualizar.php?id=<?=$obProjeto->id; ?>&amp;v=<?=$obProjeto->ver; ?>&amp;w=1" target="_blank">
                  <button class="btn btn-success btn-sm mb-2">Visualizar</button>
                </a>
            </div>
          </div>

         </div>
         <hr>
         
  </div>
  
  <?=$msgAlert?> 

  <section>
    
    <?=$resultados?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col" >
        <!-- <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a> -->
        <div class="dropup">
          <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
            Novo
          </button>
          <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item btn-sm" href="./cadastrar1.php?t=1&i=<?=$obProjeto->id; ?>">Relatório parcial</a>
              <a class="dropdown-item btn-sm" href="./cadastrar2.php?t=2&i=<?=$obProjeto->id; ?>">Relatório final</a>

          </div>
        </div>

      </div>
    </div>
  </section>
</main>










