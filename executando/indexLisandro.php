<?php

require '../vendor/autoload.php';

use App\Entity\Outros;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$sql = '
SELECT * from  lisandro
';

$sql = "SELECT 
   p.protocolo,
   p.coord, 
   te.nome tipo,
   p.titulo,
   p.acec,
   DATE_FORMAT(p.vigen_ini, '%d/%m/%Y')vigen_ini,
   DATE_FORMAT(p.vigen_fim, '%d/%m/%Y')vigen_fim,
   p.estado,
   r.tipo,
   p.resumo
FROM   
   projmaster p 
   INNER JOIN tipo_exten te ON te.id = p.tipo_exten 
   LEFT JOIN relats r ON r.idproj  = p.id  AND r.publicado = 1
WHERE
   p.para_avaliar  = 'c3bd0ba4-3b64-11ed-9793-0266ad9885af'";

$tbLISANDRO = '
            <tr>
              <td>'.$c->protocolo.'</td>
              <td>'.$c->coord.'</td>
              <td>'.$c->titulo.'</td>
              <td>'.$c->tipo.'</td>
              <td>'.$c->tp_exten.'</td>
              <td>'.$c->vig_inicio.'</td>
              <td>'.$c->vig_fim.'</td>
              <td>'.$c->relevancia.'</td>
              <td>'.$c->link.'</td>
              <td>'.$c->resumo.'</td>
            </tr>
          ';

$contudo = Outros::qry($sql);
$tb = '';
$qnt = 0;
foreach ($contudo as $c) {
    $tb .= '
            <tr>
              <td>'.$c->protocolo.'</td>
              <td>'.$c->campus.'</td>
              <td>'.$c->coord.'</td>
              <td>'.$c->titulo.'</td>
              <td>'.$c->submetido_para.'</td>
              <td>'.$c->tp_exten.'</td>
              <td>'.$c->vig_inicio.'</td>
              <td>'.$c->vig_fim.'</td>
              <td>'.$c->relevancia.'</td>
              <td>'.$c->link.'</td>
              <td>'.$c->resumo.'</td>
            </tr>
          ';
    ++$qnt;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Página Salva</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
</head>
<body>
    <h1>Projetos [<?php echo $qnt; ?> ] </h1>
    <p><button class="btn btn-success mb-2" onclick="exportToExcel('lisandro')">Exportar 📃</button></p>
    <table  id="lisandro">
        <th>
            <th>protocolo</th><th>campus</th><th>coord</th><th>titulo</th><th>submetido_para</th><th>tp_exten</th><th>vig_inicio</th><th>vig_fim</th><th>relevancia</th><th>link</th><th>resumo</th>
        </tr>
<?php echo $tb; ?>
    </table>

        <script>
        function exportToExcel(tab) {
            var tabela = document.getElementById(tab);
            var planilha = XLSX.utils.table_to_book(tabela, {sheet: "Sheet 1"});
            XLSX.write(planilha, {bookType: 'xlsx', bookSST: true, type: 'binary'});
            XLSX.writeFile(planilha, 'exportacao.xlsx');
        }
    </script>
    
</body>
</html>

