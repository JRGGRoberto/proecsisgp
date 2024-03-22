<?php
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();
use \App\Entity\Professor;
use \App\Entity\Vinculo;
use \App\Entity\disciplinas;

use \App\Entity\Outros;

//VALIDAÇÃO DO ID
if(!isset($_GET['id']) ){
    header('location: index.php?status=error');
    exit;
}

if (!$user['adm'] == 1){
  header('location: ../index.php?status=error');
  exit;
}


$obProfessor = new Professor();
$obProfessor = $obProfessor::getProfessor($_GET['id']);

//VALIDAÇÃO DA TIPO
if(!$obProfessor instanceof Professor){
  header('location: ../index.php?status=error');
  exit;
}

$sql = '
SELECT * 
FROM pad_sucinto 
WHERE 
   id_prof  = "'. $obProfessor->id .'" ' ;
$ativspad = Outros::qry($sql);


$ano = '2024';
$vinculo = Vinculo::getByAnoProf($obProfessor->id, $ano);
define('TITLE','Remover do vinculo '. $ano);
$readonly = ' readonly ';

if(isset($_POST['nome'])){

  $vinculo->excluir();
 
    
  header('location: ../professor/index.php?status=success');
    
  exit;
}

include '../includes/header.php';
echo '<h2 class="mt-3">Remover do vinculo 2024</h2>';
echo '
<table id="tabelaPADS" name="tabelaPADS" class="table table-bordered table-sm  table-hover">
  <thead class="thead-light" style="background: white; position: sticky; top: 0; z-index: 10;">
    <tr>
      <th class="align-top">Professor(ª)</th>
      <th class="align-top" style="text-align: center; width: 35px;">PAD</th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Ativ. 2.1</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Ativ. 2.2</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Ativ. 2.3</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Ativ. 3</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Ativ. 4</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">CH<br><sup>Total att</sup></th>
      <th class="align-top" style="text-align: center; width: 75px;">RT</th>
      <th class="align-top" style="text-align: center; width: 45px;">🖊️</th>
    </tr>
  </thead>
  <tbody>
';
foreach($ativspad as $atv){
  $usado = $atv->a21 + $atv->a22 + $atv->a23 + $atv->a3 + $atv->a4;

  $aprovado = $atv->assing_co == null? 'ainda não aprovado': 'aprovado';
  echo '<tr>';
    echo '<td>'. $atv->nome .'</td>';
    echo '<td><a href="https://sistemaproec.unespar.edu.br/epad/padstoprn/index.php?id='. $atv->id .'" target="_blank">📄</a> </td>';
    echo '<td>'. $atv->a21 .'h </td>';
    echo '<td>'. $atv->a22 .'h</td>';
    echo '<td>'. $atv->a23 .'h </td>';
    echo '<td>'. $atv->a3  .'h</td>';
    echo '<td>'. $atv->a4 .'h </td>';
    echo '<td>'. $usado .'</td>';
    echo '<td>'. $atv->rt .'</td>';
    echo '<td>'. $aprovado .'</td>';
  echo '</tr>';
}
echo '
  </tbody>
</table>

<form method="post" id="formprof">
      <input type="text" class="form-control" name="nome" maxlength="60"  value="'. $atv->id .'" readonly hidden>
    <div class="form-group">
      <button type="submit" class="btn btn-danger">Remover</button>
      <a href="../professor/editar.php?id='. $atv->id_prof .'"  class="btn btn-warning">Voltar</a>
    </div>
  </form>


';


include '../includes/footer.php';
  