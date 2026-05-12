<?php

require '../vendor/autoload.php';
use App\Session\Login;

$obUsuario = Login::getUsuarioLogado();
$array = $_POST['resultado'];
$dados = json_decode($array, true);

echo 'TESTE';
echo '<hr>';
foreach($dados as $key => $lin){
  echo "insert into nome_tabela(nome, cpf, convenio, id_prof) values
       (". $lin['Nome'] . "', '" . $lin['CPF'] .'" , "' . $lin['Convênio'] ."', '". $obUsuario['id']. "'); <br>";
}   

echo '<a href="index.php">Voltar</a>';