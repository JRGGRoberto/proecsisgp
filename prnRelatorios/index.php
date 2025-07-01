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
     ver, form
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
$textApagar = '<a href="../../projetos" class="btn btn-primary btn-sm mr-2">Voltar</a>';
foreach ($forms as $frm) {
    $resultado .= str_replace(
        $textApagar, '',
        capturar_saida(montaUrl($frm->form), ['p' => $id_proj, 'v' => $frm->ver])
    );
}

echo $resultado;
