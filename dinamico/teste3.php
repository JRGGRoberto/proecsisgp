<?php

include '../includes/header.php';


use \App\Entity\Projeto;
use \App\Entity\RegrasDef;

//VALIDAÇÃO DO ID
if(!isset($_GET['id'] /*, $_GET['v']*/)){
  header('location: index.php?status=error');
  exit;
}
$id = $_GET['id'];
$ver = 0;//$_GET['v'];


//CONSULTA AO PROJETO
$prj = new Projeto();
$where = '(id, ver) = ("' .$id.'", '.$ver.') ';
$prj = Projeto::getRegistros($where);
$prj = $prj[0];

//VALIDAÇÃO DA TIPO
if(!$prj instanceof Projeto){
  header('location: ../index.php?status=error');
  exit;
}

//-------------
$where = 'id_reg = "' . $prj->regras . '"';
$order = 'sequencia';
$rules = RegrasDef::getRegistros($where, $order);


$i = 0;
$navTabs = '';
$tabPanes = '';


foreach($rules as $r){
    $i++;
    $active = $i == 1 ? "active" : "";
    $fade   = $active == "active" ? "active" : "fade";

    $conteudo = '';

    ob_start();
    require '../forms/' .$r->form.'.php';
    $tmp = ob_get_clean();
    $conteudo .= $tmp;

  /**
   * 
    $file = file_get_contents('../forms/' .$r->form.'.php');
    $conteudo = eval("?>$file");
   */
  
    $navTabs .= 
    "<li class='nav-item'>
      <a class='nav-link ". $active ."' data-toggle='tab' href='#lk_". $r->sequencia ."'>". $r->nome."</a>
    </li>";
  

    $tabPanes .= 
    "<div id='lk_". $r->sequencia ."' class='container tab-pane ". $fade ."'><br>
      <p>" . $r->form ." | " . $r->tp_avaliador . " </p> ".
      $conteudo . "
    </div>";

}
?>


<br><br>

<?=100/$i?>

<div class="container">

  <ul class="nav nav-tabs nav-justified" role="tablist">
     <?=$navTabs?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <?=$tabPanes?>
  </div>

</div>

</body>
</html>
