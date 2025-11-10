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
echo $voltarUrl;
 
$id = $_GET['id'];

$tipo = substr($id,-1);
$id =  substr($id, 0, 36);

switch ($tipo){
    case 'p':
        if ( ($relatorio = RelParcial::get($id)) instanceof RelParcial) {
            echo 'Relatório PARCIAL encontrado: <br>';
            $obProjeto = (object) Projeto::getProjetoLast($relatorio->idproj);
            if($obProjeto->id_prof == $user['id']){
                $relatorio->excluir();
                header('location: index.php?id='.$obProjeto->id);
            } else {
                header('location: index.php?id='.$obProjeto->id.'&msg=ERRORowner');
                
            }
        } else {
            header('location: index.php?id='.$obProjeto->id.'&msg=RelIsnotInstance');
        }
        exit;
        break;
    case 'f':
         if ( ($relatorio = RelFinal::get($id)) instanceof RelFinal ) {
            $relatorio = (object)$relatorio;
            echo 'Relatório FINAL encontrado: <br>';
            $obProjeto = (object) Projeto::getProjetoLast($relatorio->idproj);
            if($obProjeto->id_prof == $user['id']){
                $relatorio->excluir();
                header('location: index.php?id='.$obProjeto->id);
            } else {
                header('location: index.php?id='.$obProjeto->id.'&msg=ERRORowner');
            }
        break;  
        } else {
            header('location: index.php?id='.$obProjeto->id.'&msg=RelIsnotInstance');
            exit;
        }
    default:
        header('location: index.php?id='.$obProjeto->id.'&msg=ERRORundefined');
        exit;
}

