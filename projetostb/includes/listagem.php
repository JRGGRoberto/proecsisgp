<?php

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
  
  $resultados = '';
  foreach($prjs as $prj){
    $a;
    if ($prj->arq_relatorio){
      $a = '<a href="./doc/'.$prj->arq_relatorio.'.pdf" target="_blank"><img src="./imgs/relat.png" alt="Relatório"></a>';
    } else {
      $a = '';
    }
    


    $resultados .= '<tr>
                      <td>'.$prj->coordenador.'</td>
                      <td>'.$prj->campus.'</td>
                      <td>'.$prj->ano.'</td>
                      <td>'.$prj->titulo.'</td>
                      <td class="text-center"><a href="./doc/'.$prj->arq_projeto.'.pdf" target="_blank"><img src="./imgs/relat.png" alt="Projeto"></a>
                      <td class="text-center">'.$a.'</td>
                      

                     

                    </tr>';
  }

  $resultados = strlen($resultados) ? $resultados : '<tr>
                                                       <td colspan="6" class="text-center">
                                                              Nenhuma registro encontrado
                                                       </td>
                                                    </tr>';

  //GETS
  unset($_GET['status']);
  unset($_GET['pagina']);
  $gets = http_build_query($_GET);

  //Paginação
  $paginacao = '';
  $paginas   = $obPagination->getPages();
  $paginacao .= '<nav aria-label="Navegação da paginação">
                  <ul class="pagination">';
  foreach($paginas as $key=>$pagina){
    $class = $pagina['atual'] ? 'page-item active': 'page-item';
    $paginacao .= 
      '<li class="'.$class.'">
        <a class="page-link" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'
        .$pagina['pagina']
      .'</a>
       </li>';
  }

  $paginacao .= '</ul>
  </nav>
  ';

?>
<main>

  <?=$mensagem?>

  

  <section>

    <form method="get">

      <div class="row my-4">

      <div class="col">
          <label>Nome do coordenador(ª)</label>
          <input type="text" name="coord" class="form-control" value="<?=$coord?>" style="text-transform: uppercase">
        </div>


        <div class="col">
          <label>Título</label>
          <input type="text" name="titulo" class="form-control" value="<?=$titulo?>">
        </div>

        <div class="col">
          <label>Campus</label>
          <select name="campus" class="form-control">
            <option value=""></option>
            <option value="APUCARANA"    <?= ($campus == "APUCARANA")? "selected": "" ?>>Apucarana</option>
            <option value="PARANAGUÁ"    <?= ($campus == "PARANAGUÁ")? "selected": "" ?>>Paranaguá</option>
            <option value="CAMPO MOURÃO" <?= ($campus == "CAMPO MOURÃO")? "selected": "" ?> >Campo Mourão</option>
            <option value="CURITIBA I"   <?= ($campus == "CURITIBA I")? "selected": "" ?>>Curitiba I (EMBAP)</option>
            <option value="CURITIBA II"   <?= ($campus == "CURITIBA II")? "selected": "" ?>>Curitiba II (FAP)</option>
            <option value="PARANAVAÍ"    <?= ($campus == "PARANAVAÍ")? "selected": "" ?>>Paranavaí</option>
            <option value="UNIÃO DA VITÓRIA"  <?= ($campus == "UNIÃO DA VITÓRIA")? "selected": "" ?>>União da Vitória</option>
          </select>
        </div>


        <div class="col">
          <label>Ano</label>
          <select name="ano" class="form-control">
            <option value=""></option>

            <?php
 $ano_atual = date("Y") + 1;
  for ($ano = $ano_atual; $ano >= 2018; $ano--) {
    echo '<option value="' . $ano . '" ' . (($ano == $_POST['ano']) ? 'selected' : '') . '>' . $ano . '</option>';
  }
            /*
            <option value="2023" <?= ($ano == "2023")? "selected": "" ?>>2023</option>
            <option value="2022" <?= ($ano == "2022")? "selected": "" ?>>2022</option>
            <option value="2021" <?= ($ano == "2021")? "selected": "" ?>>2021</option>
            <option value="2020" <?= ($ano == "2020")? "selected": "" ?>>2020</option>
            <option value="2019" <?= ($ano == "2019")? "selected": "" ?>>2019</option>
            <option value="2018" <?= ($ano == "2018")? "selected": "" ?>>2018</option>
            */

            ?>
          </select>
        </div>

        <div class="col d-flex align-items-end">
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>

      </div>

    </form>

  </section>
  <SECTion>

    <div><strong><?= $qntd ?></strong> registros encontrados</div>
  </SECTion>

  <section>
  
    <table class="table table-sm bg-light mt-3 table-hover ">
        <thead class="table-light">
          <tr>
            <th>Coordenador(a)</th>
            <th>Campus</th>
            <th>Ano</th>
            <th>Título do projeto/programa</th>
            <th>Projeto</th>
            <th>Relatório</th>
          </tr>
        </thead>
        <tbody>
            <?=$resultados?>
        </tbody>
    </table>
  
  </section>

  <section>
    <?=$paginacao?>
  </section>

</main>
