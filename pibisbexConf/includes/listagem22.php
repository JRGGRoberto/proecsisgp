<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$tblOculta = '
<table id="tbl1" hidden>
    <thead>
      <tr>
        <th>proj</th>
        <th>avaliador</th>
        <th>email</th>
        <th>feito</th>
        <th>q1[0/50]</th>
        <th>q2[0/40]</th>
        <th>q3[0/15]</th>
        <th>q4[0/40]</th>
        <th>q5[0/15]</th>
        <th>q6[0/20]</th>
        <th>q7[0/10]</th>
        <th>Total[0/190]</th>
      </tr>
    </thead>
    <tbody>';

$resultados = '
<table class="table table-hover table-responsive-sm">
    <thead>
      <tr>
        <th>Nº</th>
        <th>Proj</th>
        <th>Avaliador</th>
        <th>Q.1</th>
        <th>Q.2</th>
        <th>Q.3</th>
        <th>Q.4</th>
        <th>Q.5</th>
        <th>Q.6</th>
        <th>Q.7</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>';
$count = 0;
foreach ($data as $d) {
    // $class = $d->doit == 1 ? 'class="table-success"' : 'class="table-warning"';
    $tblOculta .= '
         <tr>
          <td>'.$d->projeto.'</td>
          <td>'.$d->avaliador.'</td>
          <td>'.$d->email.'</td>
          <td>'.$d->doit.'</td>
          <td>'.$d->qn1.'</td>
          <td>'.$d->qn1.'</td>
          <td>'.$d->qn2.'</td>
          <td>'.$d->qn3.'</td>
          <td>'.$d->qn4.'</td>
          <td>'.$d->qn5.'</td>
          <td>'.$d->qn6.'</td>
          <td>'.$d->qn7.'</td>
          <td>'.$d->total.'</td>
        </tr>';

    $class = '';
    $rowspan = '';

    if ($d->doit == 1) {
        $class = 'class="table-success"';
        $rowspan = ' rowspan="2" ';
        $maisInfo = ' 
            </tr>
          </tr>
          <tr>
            <td colspan="8">  
                <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#j'.$d->ordem.'">Justificativa</button>
                <div id="j'.$d->ordem.'" class="collapse">
                 '.$d->justificativa.'
                </div>

              </td>
          </tr>';
    } else {
        $class = 'class="table-warning"';
        $rowspan = '';
        $maisInfo = '';
    }

    $resultados .=
     ' <tr >
        <td '.$class.$rowspan.' style="text-align: center;"><a href="../pibisbex/docs/all/'.$d->link.'" target="_blank">'.$d->projeto.'</a></td>
        <td '.$rowspan.'>'.$d->avaliador.'<br><span class="badge badge-light">'.$d->local.
            '</span><br><span class="badge badge-link">'.$d->email.'</span>
        </td>';

    if ($d->doit == 1) {
        $resultados .= '
          <td><button type="button" class="btn btn-outline-success">'.$d->qn1.'/50</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn2.'/40</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn3.'/15</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn4.'/40</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn5.'/15</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn6.'/20</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->qn7.'/10</button></td>
          <td><button type="button" class="btn btn-outline-success">'.$d->total.'/190</button></td>';
    } else {
        $resultados .= '<td colspan="8"><div class="badge badge-warning">Ainda não avaliado</div></td>';
    }
    $resultados .= '</tr>'.$maisInfo;
}
$resultados .= '
    </tbody>
  </table>';

$tblOculta .= '</tbody>
  </table>';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<main>
  <h2 class="mt-0">ADM - Lista de projetos PIBIS / PIBEX</h2>
  


  <section>

    <?php echo $tblOculta; ?><button onclick="exportToExcel('tbl1')" class="btn btn-success btn-sm">Exportar para Excel 📄</button>
    <?php echo $resultados; ?>
    
  </section>


</main>
    <script>
        function exportToExcel(tab) {
            var tabela = document.getElementById(tab);
            var planilha = XLSX.utils.table_to_book(tabela, {sheet: "Sheet 1"});
            XLSX.write(planilha, {bookType: 'xlsx', bookSST: true, type: 'binary'});
            XLSX.writeFile(planilha, 'exportacao.xlsx');
        }
    </script>



