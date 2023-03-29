<?php

require '../vendor/autoload.php';

use \App\Entity\Projetostb;
use \App\Db\Pagination;

//Filtros
$coord  = filter_input(INPUT_GET, 'coord', FILTER_SANITIZE_STRING);
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$ano    = filter_input(INPUT_GET, 'ano', FILTER_SANITIZE_STRING);

//Condições SQL
$condicoes = [
  strlen($coord) ? 'coordenador LIKE "%'.str_replace(' ','%',$coord).'%"': null,
  strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ','%',$titulo).'%"': null,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($ano) ? "ano = '$ano'": null
];

//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
$qntd = Projetostb::getQntd($where);

//paginação
$obPagination = new Pagination($qntd, $_GET['pagina']?? 1, 10);

$prjs = Projetostb::getList($where, null, $obPagination->getLimite());


include './includes/header.php';

?>
<section>

<form method="get" action="busca.php">

  <div class="row my-4">

  <div class="col">
      <label>Nome do coordenador(ª)</label>
      <input type="text" name="coord" class="form-control" value="<?=$coord?>"  style="text-transform: uppercase">
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

<?php
include './includes/footer.php';
