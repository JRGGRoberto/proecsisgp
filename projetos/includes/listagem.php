<?php

require '../includes/msgAlert.php';

class Blocos
{
    public $pos;
    public $cor;

    public function __construct($pos, $cor)
    {
        $this->pos = $pos;
        $this->cor = $cor;
    }
}

$qnt1 = 0;
$col = '';
$LastV = '';

include './includes/funcoes.php';

$resultados =
'<div id="accordion">';

foreach ($projetos as $proj) {
    ++$qnt1;
    $apvov = false;
    if ($proj->aprov == 1) {
        $apvov = true;
    } elseif ($proj->aprov == 0) {
        $apvov = false;
    } else {
        echo 'indefinido';
    }

    if ($apvov) {
        $btnRelatorio = 'BtnRelatorio';
        // '<a href="../relatorio/index.php?id='.$proj->id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório(s) Parcial/Final</button></a> ';
    }

    $resultados .= '
  <div class="card mt-2">
    <div class="card-header">
        <div class="row">
          <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$proj->id.'">📃 '.$proj->titulo.'</a></div>
          <div class="col-sm-4">'.$proj->titulo.'</div>
          <div class="col-sm-1"><span class="badge badge-info"> </span> </div>
          <div class="col-sm-1"><span class="badge badge-warning "> </span></div>
          
        </div>
    </div>
    <div id="p'.$proj->id.'" class="collapse" data-parent="#accordion">
      <div class="d-flex flex-row-reverse ">
        <div class="p-1"></div>
        <div class="p-1"></div>
            
        <div class="p-1"></div>
       
        <div class="p-1"> 
          <a href="./avaliar.php?id=" target="" class="btn btn-success btn-sm mb-2">Visualizar/Avaliar relatorio</a>
          <a href="../projetos/visualizar.php?id='.$proj->id.'&v='.$proj->ver.'&w=nw" target="_blank" class="btn btn-success btn-sm mb-2">📄'.($proj->ver + 1).'</a>
      </div>
     </div>
  </div>';
}
$resultados .=
'</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>


<main>
  <h2 class="mt-0">Meus projetos</h2>
  
  <?php echo $msgAlert; ?> 
  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col-5">
          <label>Titulo</label> 
          <input type="text" name="titulo" class="form-control form-control-sm" value="<?php echo $titulo; ?>"  id="titulo"   onchange="showLimpar();">
        </div>

        <div class="col">
          <label>Palavra chave</label> 
          <input type="text" name="palavra" class="form-control form-control-sm" value="<?php echo $palavra; ?>"  id="palavra"   onchange="showLimpar();">
        </div>


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
      <div class="col" >
        <!-- <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a> -->
        <div class="dropup">
          <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
            Novo
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=4">Novo Programa</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=5">Novo Projeto</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=3">Nova Prestação de Serviço</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=1">Novo Curso</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=2">Novo Evento</a>

          </div>
        </div>

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
          

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id="modalFooter">
          
        </div>
        
      </div>
    </div>
  </div>
  <!-- The Modal -->

<?php
  echo '<script>';
echo 'const optspara = `';
echo $coolSelectSend;
echo '`;';
echo '</script>';
