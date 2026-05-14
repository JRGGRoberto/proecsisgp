<?php

require '../includes/msgAlert.php';
use App\Entity\Outros;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();
// print_r($user["adm"]);

$qnt1 = 0;

$resultados = '<div id="accordion">';

foreach ($projetosParados as $proj) {
    ++$qnt1;

    // $query = "select * from relatorios r where r.publicado = 1 and r.idproj = '".$proj->id."'";
    // $relatorios = Outros::qry($query);

    $collapseId = 'p'.$proj->protocolo.$proj->fase_seq;

    $resultados .= '
    <div class="card mt-2">
      <div class="card-header" style="background-color: #e9ecef">
        <div class="row">
            <div class="col-sm-12">📃 <strong>Título: </strong>
              <a class="collapsed card-link" data-toggle="collapse" href="#">
                <strong>'.$proj->titulo.'</strong>
              </a>
            </div>
        </div>
        <div class="row">
          <div class="col-sm-7"><strong>Coordenador: </strong>'.$proj->nome_prof.'</div>
        </div>
        <div class="row">
          <div class="col-sm-5"><strong>Tipo de Proposta:</strong> '.$proj->tipo_exten.'</div>
        </div>
        <div class="row">
          <div class="col-sm-5"><strong>Protocolo: </strong>'.$proj->protocolo.'</div>
        </div>

      </div>
      
      <div id="'.$collapseId.'" class="collapse show" data-parent="#accordion">
        <div class="card-body">
    ';

    if ($proj->fase_seq > 1) {
        $resultados .= '';
    } else {
        $resultados .= '
            <table class="table table-bordered table-sm mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>Fase</th>
                        <th>Instância</th>
                        <th>Avaliador</th>
                        <th>Resultado</th>
                        <th>Dias em tramitação</th>
                        <th>Recebido</th>
                        <th>Enviado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($fasesDoProjeto as $fases) {
            $instancia = '';
            switch ($fases->tp_instancia) {
                case 'ca': $instancia = 'Chefe de Divisão';
                    break;
                case 'ce': $instancia = 'Diretor de Centro de Área';
                    break;
                case 'co': $instancia = 'Coordenador de colegiado';
                    break;
                case 'pf': $instancia = 'Professor';
                    break;
                case 'dc': $instancia = 'Diretor de Campus';
                    break;
            }

            // echo '<pre>';
            // print_r($fases);
            // echo '</pre>';
            $resultadoAvaliacao = '';
            switch ($fases->resultado) {
                case 'a': $resultadoAvaliacao = 'Aprovado';
                    break;
                case 'r': $resultadoAvaliacao = 'Solicitação de alterações';
                    break;
                case 'e': $resultadoAvaliacao = 'Em análise';
                    break;
            }

            if ($fases->id == $proj->id) {
                $resultados .= '
                    <tr>
                        <td class="text-center">'.$fases->fase_seq.'</td>
                        <td>'.$instancia.'</td>
                        <td>'.$fases->quem.'</td>
                        <td class="resultado-tb">'.$resultadoAvaliacao.'</td>
                        <td>'.$fases->dias.'</td>
                        <td>'.$fases->chegada.'</td>
                        <td>'.$fases->saida.'</td>
                    </tr>';
            }
        }

        $resultados .= '
                </tbody>
            </table>
            
            <a href="../propostas/visualizar.php?id='.$proj->id.'&v='.$proj->ver.'&w=1" target="_blank">
              <button class="btn btn-success btn-sm mb-2">Projeto 📃</button>
            </a>
        ';
    }

    $resultados .= '
        </div> <!-- card-body -->
      </div> <!-- collapse -->
    </div> <!-- card -->
    ';
}
$resultados .= '</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>

<main>
  <h2 class="mt-0">Projetos parados</h2>
  
  <?php echo $msgAlert; ?> 
  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col-4">
          <label>Titulo</label> 
          <input type="text" name="titulo" class="form-control form-control-sm" value="<?php echo $titulo; ?>"  id="titulo"   onchange="showLimpar();">
        </div>

        <div class="col-4">
          <label>Coordenador</label> 
          <input type="text" name="nome_prof" class="form-control form-control-sm" value="<?php echo $nome_prof; ?>"  id="nome_prof"   onchange="showLimpar();">
        </div>

        <div class="col-4">
        <label for="campus">Campus:</label>
          <select name="campus" id="campus" class="form-control form-control-sm" onchange="showLimpar()">
            <option value="">Todos</option>
            <option value="AP" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'AP') ? 'selected' : ''; ?>>Apucarana</option>
            <option value="CM" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'CM') ? 'selected' : ''; ?> >Campo Mourão</option>
            <option value="CA" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'CA') ? 'selected' : ''; ?>>Curitiba I (EMBAP)</option>
            <option value="CB" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'CB') ? 'selected' : ''; ?>>Curitiba II (FAP)</option>
            <option value="PG" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'PG') ? 'selected' : ''; ?>>Paranaguá</option>
            <option value="PV" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'PV') ? 'selected' : ''; ?>>Paranavaí</option>
            <option value="UV" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'UV') ? 'selected' : ''; ?>>União da Vitória</option>
            <option value="LO" <?php echo (isset($_GET['campus']) && $_GET['campus'] == 'LO') ? 'selected' : ''; ?>>Loanda</option>
          </select>
        </div>
        
        <div class="col-2">
          <label>Fase</label>
          <select name="fase_seq" class="form-control form-control-sm" onchange="showLimpar();">
            <option value="0">Todas</option>
            <option value="1" <?php echo (isset($_GET['fase_seq']) && $_GET['fase_seq'] == '1') ? 'selected' : ''; ?>>Fase 1</option>
            <option value="2" <?php echo (isset($_GET['fase_seq']) && $_GET['fase_seq'] == '2') ? 'selected' : ''; ?>>Fase 2</option>
            <option value="3" <?php echo (isset($_GET['fase_seq']) && $_GET['fase_seq'] == '3') ? 'selected' : ''; ?>>Fase 3</option>
            <option value="4" <?php echo (isset($_GET['fase_seq']) && $_GET['fase_seq'] == '4') ? 'selected' : ''; ?>>Fase 4</option>
            <option value="5" <?php echo (isset($_GET['fase_seq']) && $_GET['fase_seq'] == '5') ? 'selected' : ''; ?>>Fase 5</option>
          </select>
        </div>

      
        <div class="col-4 d-flex align-items-center mt-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="diasParados7" id="diasParados7" value="7" style="height: 20px;"
              <?php echo isset($_GET['diasParados7']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="filtroMais7dias">
              Projetos parados mais do que 7 dias
            </label>
          </div>
        </div>

        <div class="col-4 d-flex align-items-center mt-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="diasParados30" id="diasParados30" value="30" 
              <?php echo isset($_GET['diasParados30']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="filtroMais30dias">
              Projetos parados mais do que 30 dias
            </label>
          </div>
        </div>

        
        <!-- 
          <div class="col-3">
            <label>Palavra chave</label> 
            <input type="text" name="palavra" class="form-control form-control-sm" value="<?php echo $palavra; ?>"  id="palavra"   onchange="showLimpar();">
          </div>
         -->

        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>
      </div>
    </form>

  </section>

  <section>
    <?php echo $resultados; ?>
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?php echo $paginacao; ?>
      </div>
    </div>
  </section>
</main>





<!-- The Modal -->
  <div class="modal fade" id="modalSub">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Título</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="modalBody">
            <p>teste</p>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id="modalFooter">
          
        </div>
        
      </div>
    </div>
  </div>
  <!-- The Modal -->

  <?php
//    echo '<script>';
// echo 'const optspara = `';
// echo $coolSelectSend;
// echo '`;';
// echo '</script>';

?>



<script>

  //Cores da tabela
  const corVerde = '#c3e6cb';
  const corVermelha = '#f5c6cb';
  const corAmarela = '#ffeeba';

  const resultados = document.querySelectorAll('.resultado-tb');

  resultados.forEach(td => {
    const valor = td.textContent.trim(); 
    console.log(valor);

    switch (valor) {
      case 'Aprovado':
        td.style.backgroundColor = corVerde;
        td.style.border = '1px solid #8fd19e';
        break;

      case 'Solicitação de alterações':
        td.style.backgroundColor = corVermelha;
        td.style.border = '1px solid #ed969e';
        break;

      case 'Em análise':
        td.style.backgroundColor = corAmarela;
        td.style.border = '1px solid #ffdf7e';
        break;
    }
  });

  const btnLimpar = document.getElementById('limpar');

  btnLimpar.hidden = true;

  function showLimpar(){
    var titulo    = document.getElementById('titulo').value;
    var palavra   = document.getElementById('palavra').value;
    var campus = document.getElementById('campus').value;

    if((titulo.length > 0 ) || (campus.length > 0 ) || (palavra.length > 0 ) ) {
      btnLimpar.hidden = false;
    } 
  }

  showLimpar();
</script>
