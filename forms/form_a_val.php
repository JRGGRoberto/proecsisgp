<?php
use \App\Entity\Avaliacoes;

//VALIDAÇÃO DO POST
if(isset($_POST['resultado'])){
  $id_ava1  = $_GET['i'];
  $ava1 = Avaliacoes::getRegistro($id_ava1);
  if(($ava1->id_proj == $id_proj) and ($ava1->ver == $ver_proj)) {
    echo $_POST['tp_proposta'];
    echo $_POST['r3_1'];  echo '<br>';
    echo $_POST['r3_2'];  echo '<br>';
    echo $_POST['r3_3'];  echo '<br>';
    echo $_POST['r3_4'];  echo '<br>';
    echo $_POST['r3_5'];  echo '<br>';
    echo $_POST['r3_6'];  echo '<br>';
    echo $_POST['r3_6'];  echo '<br>';
    echo '<hr>';
    echo $_POST['r4_1'];  echo '<br>';
    echo $_POST['r4_2'];  echo '<br>';
    echo $_POST['r4_3'];  echo '<br>';
    echo $_POST['r4_4'];  echo '<br>';
    echo $_POST['r4_5'];  echo '<br>';
    echo '<hr>';
    echo $_POST['sol_adq'];  echo '<br>';
    echo $_POST['parecer'];  echo '<br>';
    echo $_POST['cideade'];  echo '<br>';
    echo $_POST['dateAssing'];  echo '<br>';
    echo $_POST['resultado'];  echo '<br>';
    echo $id_proj; echo '<BR>';
    echo $id_ava; echo '<BR>';
    echo $ver_proj; echo '<BR>';
    $isTouch = isset($_POST['r3_1']);
    var_dump($isTouch);

    // header('location: ../avalareal/index.php?status=success');
    exit; 
  }
}