<?php

require '../vendor/autoload.php';
use App\Entity\Candidato;
use App\Entity\Inscricao;
use App\Entity\Outros;

$options = '';
$idCand = '';

$qryListaProg = "
    select p.id id, concat( p.prof, ' [',p.prog, '] ', p.campus   ) data
from 
  divulga_proj p ";

$programasInscritos = '';

$cpf = $_POST['cpf'];
$cand = Candidato::getCPF($_POST['cpf']);

if (!$cand) {
    $cand = new Candidato();
    $evento = 'cadastrar';
} else {
    $evento = 'editar';
    $cand2 = (object) Candidato::getCPF($_POST['cpf']);
    $idCand = $cand2->id;

    $qryListaProg .= " where p.id not in ( 
  select if_prog from inscricao where id_can = '".$idCand."'   )
";

    $qryCurInsc = '
        select 
          p.prof, p.prog, p.campus, p.colegiado, DATE_FORMAT(i.created_at, "%d/%m/%Y") em
        from
          inscricao i
          inner join divulga_proj p on i.if_prog = p.id
        where i.id_can = "'.$idCand.'"
        ';
    $curInscritos = Outros::qry($qryCurInsc);
    $programasInscritos = '
    <div class="row">
      <div class="col">
        <div class="form-group">';
    foreach ($curInscritos as $program) {
        $programasInscritos .= '<button type="button" class="btn btn-outline-success">'.$program->prog.' - '.$program->prof.' - '.$program->campus.' - '.$program->colegiado.'. Inscrição realizada em '.$program->em.'</button>';
    }
    $programasInscritos .= '      
        </div>
      </div>
    </div>
';
}

$listaProg = Outros::qry($qryListaProg);
foreach ($listaProg as $prog) {
    $options .= '<option value="'.$prog->id.'">'.$prog->data.'</option>';
}

if (isset($_POST['nome'])) {
    $cand->nome = $_POST['nome'];
    $cand->rg = $_POST['rg'];
    $cand->cpf = $_POST['cpf'];
    $cand->dt_nasc = $_POST['dt_nasc'];
    $cand->ender = $_POST['ender'];
    $cand->bairro = $_POST['bairro'];
    $cand->cidade = $_POST['cidade'];
    $cand->uf = $_POST['uf'];
    $cand->cep = $_POST['cep'];
    $cand->tel1 = $_POST['tel1'];
    $cand->tel2 = $_POST['tel2'];
    $cand->email = $_POST['email'];
    $cand->curso = $_POST['curso'];
    $cand->serie = $_POST['serie'];

    if ($evento == 'cadastrar') {
        $idCand = $cand->cadastrar();
    } else {
        $cand->atualizar();
    }

    if ($_POST['inscricao'] != -1) {
        $inscricao = new Inscricao();
        $inscricao->id_can = $idCand;
        $inscricao->if_prog = $_POST['inscricao'];
        $inscricao->cadastrar();
        header('location: index.php');

        // insert into inscricao(id_can, if_prog) value('67119620-76d5-11f0-8589-ee060fc70170' ,'b807ef99-76b8-11f0-953e-3a9832f2c2cb')
    }
}

include '../includes/headers.php';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';
