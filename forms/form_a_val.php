<?php
use \App\Entity\Avaliacoes;


use \App\Entity\Form_a;
$form = Form_a::getRegistro($_GET['i'], $_GET['v']);
if(!is_null($form)) {
  $form = new Form_a();
}


//VALIDAÇÃO DO POST
if(isset($_POST['resultado'])){
  $id_ava1  = $_GET['i'];
  $ava1 = Avaliacoes::getRegistro($id_ava1);
  if(($ava1->id_proj == $id_proj) and ($ava1->ver == $ver_proj)) {
    echo $_POST['r3_1'];  echo '<br>';
    echo $_POST['r3_2'];  echo '<br>';
    echo $_POST['r3_3'];  echo '<br>';
    echo $_POST['r3_4'];  echo '<br>';
    echo $_POST['r3_5'];  echo '<br>';
    echo $_POST['r3_6'];  echo '<br>';
    echo $_POST['r3_7'];  echo '<br>';
    
    echo '<hr>';
    echo $_POST['r4_1'];  echo '<br>';
    echo $_POST['r4_2'];  echo '<br>';
    echo $_POST['r4_3'];  echo '<br>';
    echo $_POST['r4_4'];  echo '<br>';
    echo $_POST['r4_5'];  echo '<br>';
    echo '<hr>';

    echo $_POST['solicitacoes'];  echo '<br>';
    echo $_POST['parecer'];  echo '<br>';

    echo $_POST['cidade'];  echo '<br>';
    echo $_POST['dateAssing'];  echo '<br>';
    echo $_POST['whosigns'];  echo '<br>';
    echo $_POST['resultado'];  echo '<br>';
    echo $id_proj; echo '<BR>';
    echo $id_ava; echo '<BR>';
    echo $ver_proj; echo '<BR>';
    

    // header('location: ../avalareal/index.php?status=success');
    exit; 
  }
}