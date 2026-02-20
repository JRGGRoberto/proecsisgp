<?php

require '../vendor/autoload.php';

use App\Entity\Outros;

$id_proj = $id_proj ?? ($_GET['id'] ?? 'Ninguém');

if ($id_proj == 'Ninguém') {
    header('location: index.php?status=error');
    exit;
}

$query = '
  SELECT 
     ver, form, concat(fase_seq, "/",  etapas) etapa, tp_instancia, 
      if(resultado = "a", "aceita", "sol. adequações") resultado,  resultado res,
      DATE_FORMAT(greatest(created_at, updated_at ), "%d/%m/%Y") as realizado
  FROM proj_avaliar p
  WHERE 
    id_proj = "'.$id_proj.'" 
    and resultado <> "e"
  order by 
    ver desc, fase_seq desc;
';

$forms = Outros::qry($query);

/*
$form = [
    ['f' => 'form_d',         'v' => '1'],
    ['f' => 'form_c',         'v' => '1'],
    ['f' => 'form_b',         'v' => '1'],
    ['f' => 'form_b',         'v' => '0'],
    ['f' => 'form_parecer',   'v' => '0'],
    ['f' => 'form_selecprof', 'v' => '0'],
    ['f' => 'form_a',         'v' => '0'],
];
*/

function capturar_saida($arquivo, $parametros = [])
{
    ob_start();
    // Extrai variáveis passadas
    extract($parametros);
    // Inclui o arquivo como se fosse chamado diretamente
    include $arquivo;

    return ob_get_clean();
}

function montaUrl($form)
{
    return '../forms/'.$form.'/vista.php';
}

$resultado = '';
$textApagar = '<a href="../../propostas" class="btn btn-primary btn-sm mr-2">Voltar</a>';
$textApagar2 = '&ensp;&ensp;<span id="xpto141617">&ensp;</span>&ensp;';
if (count($forms) == 0) {
     
    ob_start();
    include '../includes/headers.php';
    $resultado = ob_get_clean();
    $resultado .= '<div class="alert alert-info">Nenhuma avaliação encontrada para este projeto.</div>';
    $resultado .= file_get_contents('../includes/footer.php');
    
} else {
    foreach ($forms as $frm) {
        $cor = $frm->res == 'a' ? 'success' : 'danger';
        $txtAlterado = '
       <span class="badge badge-primary">'.$frm->form.'</span>
       <span class="badge badge-'.$cor.'"> Etapa ['.$frm->etapa.'] '.$frm->resultado.'</span>
       <span class="badge badge-info">'.$frm->realizado.'</span>
        ';
        $resultado .=
            str_replace(
                $textApagar2, $txtAlterado,
                str_replace(
                    $textApagar, '',
                    capturar_saida(montaUrl($frm->form), ['p' => $id_proj, 'v' => $frm->ver])
                )
            );
    }
}

echo $resultado;
