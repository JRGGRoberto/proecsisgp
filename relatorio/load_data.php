<?php


use \App\Entity\Area1;
use \App\Entity\Area2;
use \App\Entity\Area3;

$areas1 = Area1::getRegistros($obProjeto->id);
$selectArea1 = '';
foreach($areas1 as $area1){
  $selectArea1 .= '<option value="'.$area1->id.'" '.$area1->sel.'>'.$area1->nome.'</option>';
}


$areas2 = Area2::getRegistros($obProjeto->id);
$selectArea2 = '';
foreach($areas2 as $area2){
  $selectArea2 .= '<option value="'.$area2->id.'" '.$area2->sel.'>'.$area2->nome.'</option>';
}


$areas3 = Area3::getRegistros($obProjeto->id);
$selectArea3 = '';
foreach($areas3 as $area3){
  $selectArea3 .= '<option value="'.$area3->id.'" '.$area3->sel.'>'.$area3->nome.'</option>';
}


if (isset($_POST["tipo"])) {
  if ($_POST["tipo"] == "area1") {
    $areas1 = Area1::getRegistros($obProjeto->id);
    foreach($areas1 as $area1){
      $saida[] = array(
        'id' => $area1->id,
        'sel' => $area1->sel,
        'nome' => $area1->nome
      );
    }
    echo json_encode($saida);
  } elseif($_POST["tipo"] == "area2") {
    $cat_id = $_POST["cat_id"];
    $areas2 = Area2::getRegistros($obProjeto->id, $cat_id);
    foreach($areas2 as $area2){
      $saida[] = array(
        'id' => $area2->id,
        'sel' => $area2->sel,
        'nome' => $area2->nome
      );
    }
    echo json_encode($saida);
  } else {
    $cat_id = $_POST["cat_id"];
    $areas3 = Area3::getRegistros($obProjeto->id, $cat_id);
    foreach($areas3 as $area3){
      $saida[] = array(
        'id' => $area3->id,
        'sel' => $area3->sel,
        'nome' => $area3->nome
      );
    }
    echo json_encode($saida);
  }
}
