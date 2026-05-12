<?php

require '../vendor/autoload.php';

use App\Entity\Projeto;
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

if (!isset($_GET['id'], $_GET['v'])) {
    header('location: index.php?status=error');
    exit;
}
$id = $_GET['id'];
$ver = $_GET['v'];

// CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto = Projeto::getProjeto($id, $ver);

echo '<pre>';
// print_r($obProjeto );
echo '</pre>';
//if (isset($obProjeto->area_extensao) or  isset($obProjeto->linh_ext)){
// }


use App\Entity\Area_Extensao;

$area_ext = Area_Extensao::getRegistros();
$area_ext_Opt = '';
foreach ($area_ext as $aext) {
    $area_ext_Opt .= '<option value="'.$aext->id.'" '.$aext->sel.'>'.$aext->nome.'</option>';
}

use App\Entity\Area_temat;

$area_tem1 = Area_temat::getRegistros();
$areaOptions = '';
foreach ($area_tem1 as $area) {
    $areaOptions .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}


include '../includes/headers.php';

include './includes/form.php';

include '../includes/footer.php';