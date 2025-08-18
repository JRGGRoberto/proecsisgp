<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\Inscricao;
use App\Entity\Outros;

$iduser = $user['id'];

$qrySelProg = '
select 
   p.id, p.prog , COUNT(s.id_can) ok,  count(i.id_can) inscritos
from 
   divulga_proj p
   left join inscricao i on i.id_prog  = p.id 
   left join inscricao s on s.id_prog  = p.id and s.cancelado = 0 AND s.classif = 1
where 
idprof = "'.$iduser.'"
group by 1;
';
$programas = Outros::qry($qrySelProg);
$candidatos = '';

$btnsProgs = '<form method="post" name="getProg">';
foreach ($programas as $prog) {
    $corClass = '';
    if ($prog->ok > 0) {
        $corClass = 'success';
    } else {
        $corClass = 'warning';
    }
    $btnsProgs .= '<button type="submit" class="btn btn-'.$corClass.' btn-sm mr-2" name="acao" value="'.$prog->id.'">'.$prog->prog.
    ' Inscritos: '.$prog->inscritos.'</button>';
}

$btnSalvar = '';
$btnsProgs .= '</form>';

$candidatos = '[]';

if (isset($_POST['altDados'])) {
    $inscricoesAlt = $_POST['altDados'];
    $arrayInsc = json_decode($inscricoesAlt, true);

    foreach ($arrayInsc as $key => $i) {
        if ($i['cancelado'] == 1) {
            $insc1 = Inscricao::get($i['id_can'], $i['id_prog']);
            $insc1->cancel();
        }

        if ($i['cancelado'] == 0) {
            $insc1 = Inscricao::get($i['id_can'], $i['id_prog']);
            $insc1->posicao($i['classif']);
        }
    }
}

if (isset($_POST['acao'])) {
    $idP = $_POST['acao'];
    $qry = 'select 
               p.idprof,  p.prog,
               c.nome, c.cidade, c.curso, c.uf, c.tel1, c.email,
               DATE_FORMAT(i.created_at, "%d/%m/%Y %H:%i") dt_insc,
               i.id_prog, i.id_can, i.classif, i.cancelado, i.obs
              from 
                 candidatos c 
                 inner join inscricao i on i.id_can = c.id
                 inner join divulga_proj p on p.id =  i.id_prog  
              where 
                  p.idprof = "'.$iduser.'"  and
                  p.id = "'.$idP.'" 
              order by i.cancelado, i.classif, i.created_at ';

    $candidatos = json_encode(Outros::qry($qry));
    $btnSalvar = '<button id="btnSalvar" class="btn btn-success btn-sm float-right" hidden onclick="salvaInfos()">Salvar classificação</button><hr>';
}

include '../includes/header.php';
echo '<script> 
   var dados = '.$candidatos.';
</script>';

include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
