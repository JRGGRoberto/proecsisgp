<?php

require '../vendor/autoload.php';
use App\Entity\Outros;
use App\Session\Login;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = Login::getUsuarioLogado();


// pagina 2

$pagina = 2;

$id = $user['id'];

$permissao = Outros::qry(
"
select 
   *
from 
    permissoes p 
    inner join  recursotag r on p.recurso = r.id_rec
where 
   p.id_user = '".$id."'  and 
   p.recurso 
like '".$pagina ."%' order by p.recurso "

);




if (count($permissao) == 0) {
    // header('location: ../index.php?status=errorOwner');
    echo 'Acesso Negado!';
    exit;
}

$recursos = '';
$btn = [];  

foreach ($permissao as $per) {
    $recursos .= $per->tag;
    $btn []= $per->recurso;
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h2>Página <?php echo $pagina; ?></h2>
  <?echo $recursos; ?>
</div>

<pre>
<?php 
 

   if(in_array('22', $btn)) {
       echo "<h3>pagina 1 btn1 </h3>";
   }

?>
</pre>



</body>
</html>