<?php

require '../vendor/autoload.php';
use App\Session\Login;

$user = Login::getUsuarioLogado();

require '../includes/msgAlert.php';

$opcoes = [
    'p1' => ['dataproj1.php', 'proj1.php'],
    'p2' => ['dataproj2.php', 'proj2.php'],
    'r1' => ['datarel1.php', 'rel1.php'],
    'r2' => ['datarel2.php', 'rel2.php'],
];

echo '
<script>
   var vaInicial =  "'.$tpAvaliacao.'";
</script>
';

$resultados = '';
include './includes/data/'.$opcoes[$tpAvaliacao][0];
include './includes/'.$opcoes[$tpAvaliacao][1];

?>



<main>
  <div class="row">
    <div class="col"><h2 class="mt-0">Avaliações de</h2></div>
    <div class="col">
      <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="btnP" data-toggle="pill" href="#propostas" onclick="trocarPagina('p')">Propostas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="btnR" data-toggle="pill" href="#relatorios" onclick="trocarPagina('r')">Relatorios</a>
          </li>
        </ul>
    </div>
    <div class="col-7"></div>
  </div>

  <div class="tab-content">
    <div id="propostas" class="container tab-pane active">
      <label for="listar_projetos">Listagem de:</label>
      <select id="listar_projetos" class="custom-select custom-select-sm w-auto" role="button" onchange="trocarPagina(this)"> 
          <option value="p1" selected="">
              Propostas a avaliar
          </option>

          <option value="p2">
              Propostas avaliadas
          </option>

      </select>
    </div>
    
    <div id="relatorios" class="container tab-pane fade">
      <label for="listar_relatorios">Listagem de:</label>
      <select id="listar_relatorios" class="custom-select custom-select-sm w-auto" role="button" onchange="trocarPagina(this)"> 
          <option value="r1" selected="">
              Relatórios a avaliar
          </option>

          <option value="r2">
              Relatórios avaliados
          </option>
      </select>
    </div>
    
  </div>
  <hr>
<script>

  function goToTpAvaliacao(a){
    location.href = './index.php?tpAva=' + a;  
  }

  function trocarPagina(e){
    if(e == 'p'){ // vindo dos botões
      sel = document.getElementById('listar_projetos');
      goToTpAvaliacao(sel.value)
    } else if(e == 'r'){ // vindo dos botões
      sel = document.getElementById('listar_relatorios');
      goToTpAvaliacao(sel.value)
    } else {
      goToTpAvaliacao(e.value);
    }
  }

  function setInitialValues(){
    console.log(vaInicial);
    btnP = document.getElementById('btnP');
    btnR = document.getElementById('btnR');
    propostas = document.getElementById('propostas');
    relatorios = document.getElementById('relatorios');

    listar_projetos = document.getElementById('listar_projetos');
    listar_relatorios = document.getElementById('listar_relatorios');

    if ((vaInicial == 'p1')||(vaInicial == 'p2')){
      btnP.classList.add('active');
      btnR.classList.remove('active');

      propostas.classList.add('active');
      propostas.classList.remove('fade');
      relatorios.classList.remove('active');
      relatorios.classList.add('fade');

      listar_projetos.value = vaInicial;

    } else if ((vaInicial == 'r1')||(vaInicial == 'r2')){
      btnR.classList.add('active');
      btnP.classList.remove('active');
      
      relatorios.classList.add('active');
      relatorios.classList.remove('fade');
      propostas.classList.remove('active');
      propostas.classList.add('fade');

      
      listar_relatorios.value = vaInicial;
    }
  }
  
  setInitialValues()

</script>
  
  
  <?php echo $msgAlert; ?>

  <section>
    <form method="get">
      <div class="row my-2">
         <input hidden name="tpAva" value="<?php echo $tpAvaliacao; ?>">

        <div class="col-4">
          <label>Buscar por titulo</label> 
          <input type="text" name="tituloB" class="form-control form-control-sm" 
              value="<?php echo $tituloB; ?>"   id="tituloB"  onchange="showLimpar();">
        </div>

        <div class="col-4">
          <label>Coordenador</label>
          <input type="text" name="nome_profB" class="form-control form-control-sm"
                value="<?php echo $nome_profB; ?>" id="nome_profB" onchange="showLimpar();">
        </div>
          
        <div class="col-2">
          <label>Protocolo</label>
          <input type="text" name="protocoloB" class="form-control form-control-sm"
                value="<?php echo $protocoloB; ?>" id="protocoloB" onchange="showLimpar();">
        </div>
 
        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <button id="limpar" class="btn btn-primary btn-sm mr-2" onclick="Limpar()">x</button>
        </div>

      </div>
    </form>
  </section>

  <section>
    <?php echo $resultados; ?>
  </section>
</main>

<script>

  const btnX      = document.getElementById("limpar");
  const titulo    = document.getElementById('tituloB');
  const nome_prof = document.getElementById('nome_profB');
  const protocolo = document.getElementById('protocoloB');

  function Limpar(){
    titulo.value = '';
    nome_prof.value = '';
    protocolo.value = '';
    btnX.hidden = true;
  }
  
  function showLimpar(){

   console.log('a');

    if((titulo.length > 0 ) | (nome_prof.length > 0)| (protocolo.length > 0)) {
        btnX.hidden = true;
    }
  }
 
  
</script>


