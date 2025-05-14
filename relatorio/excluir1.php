<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\RelParcial;
use App\Entity\RelFinal;
// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$voltarUrl = $_SERVER['HTTP_REFERER'];
 
$id = $_GET['id'];
echo substr($id,0,1).'<br>';

switch (substr("$id",0,1)){
    case 'p':
        if ( ($relatorio = RelParcial::get(substr("$id",1,strlen($id)-1))) instanceof RelParcial) {
            echo 'Relatório PARCIAL encontrado: <br>';
            $obProjeto = (object) Projeto::getProjetoLast($relatorio->idproj);
            if($obProjeto->id_prof == $user['id']){
                $relatorio->excluir();              
                header('location: index.php?id='.$obProjeto->id);
                exit;
            } else {
                header('location: index.php?id='.$obProjeto->id.'&msg=ERRORowner');
                exit;
            }
        } else {
            header('location: index.php?id='.$obProjeto->id.'&msg=ERROR401');
            exit;
        }
        break;
    case 'f':
         if ( ($relatorio = RelFinal::get(substr("$id",1,strlen($id)-1)) instanceof RelFinal) ) {
            $relatorio = (object)$relatorio;
            echo 'Relatório FINAL encontrado: <br>';
            $obProjeto = (object) Projeto::getProjetoLast($relatorio->idproj);
            if($obProjeto->id_prof == $user['id']){
                $relatorio->excluir();
                header('location: index.php?id='.$obProjeto->id);
                exit;
            } else {
                header('location: index.php?id='.$obProjeto->id.'&msg=ERRORowner');
                exit;
            }
        break;  
        } else {
            header('location: index.php?id='.$obProjeto->id.'&msg=ERROR401');
            exit;
        }
    default:
        header('location: index.php?id='.$obProjeto->id.'&msg=ERRORundefined');
        exit;
}

