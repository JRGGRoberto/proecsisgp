<?php

use \App\Entity\Area1;
use \App\Entity\Area2;
use \App\Entity\Area3;



function obterArea1(){
  $areas1 = Area1::getRegistros(1);
  $json = array();
  foreach($areas1 as $area1){
    $json[] = array(
      'id' => $area1->id,
      'sel' => $area1->sel,
      'nome' => $area1->nome,
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}

function obterArea2($id, $id_sup){
  $areas2 = Area2::getRegistros($id, $id_sup);
  $json = array();
  foreach($areas2 as $area2){
    $json[] = array(
      'id' => $area2->id,
      'sel' => $area2->sel,
      'nome' => $area2->nome,
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}

function obterArea3($id, $id_sup){
  $areas3 = Area3::getRegistros($id, $id_sup);
  $json = array();
  foreach($areas3 as $area3){
    $json[] = array(
      'id' => $area3->id,
      'sel' => $area3->sel,
      'nome' => $area3->nome,
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}

if( isset($_POST['id']) ) {
  $id_sup = $_POST['id'];
  obterArea2($id, $id_sup);
} else if( isset($_POST['id']) ) {
  $id_sup = $_POST['id'];
  obterArea3($id, $id_sup);
} else {
  obterArea1(1);
}