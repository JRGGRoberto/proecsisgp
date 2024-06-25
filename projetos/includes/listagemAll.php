<?php

  require('../includes/msgAlert.php');

  use \App\Entity\Colegiado;
  use \App\Entity\Avaliacoes;

  class Blocos {
    public $pos;
    public $cor;

    function __construct($pos, $cor) {
      $this->pos = $pos;
      $this->cor = $cor;
    }
  }
  

  $qnt1 = 0;
  $col= '';
  $LastV = '';

  function resumirTexto(string $texto, int $limite = 256): string
  {
      $textoLimpo = trim(strip_tags($texto));
      if (mb_strlen($textoLimpo) <= $limite) {
          return $textoLimpo;
      }
      return (substr($textoLimpo, 0, $limite) . ' <span class="badge badge-pill badge-success">(continua...)</span>');
   }



  $resultados = '<div id="accordion">';
  foreach($projetos as $proj){
    $qnt1++;

    if(
      ($proj->regras == 'e341e624-0715-11ef-b2c8-0266ad9885af') && 
      ($proj->para_avaliar == -1) && 
      ($proj->last_result == 'a') &&
      ($proj->edt ==  0)
    ){

      $progresso = '<span class="badge badge-success ">Em execução/Excutado</span>';

    } else {

      is_null($proj->colegiado) ? $col = 'A definir' : $col = $proj->colegiado;

      $where = 'id_proj = "'. $proj->id. '"';
      $order = "ver desc, fase_seq desc";
      $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);
      $LastV = 
         '<table class="table table-bordered table-sm">
          <thead class="thead-dark">
            <tr>
              <th>Projeto</th>
              <th>Parecere(s)</th>
              <th>Parte</th>
            </tr>
          </thead>
          <tbody>';
   
       
       $a =0;
       $etapas = 0;
       $btnStatus = [];
       foreach($ListaVerAnts as $la){
         
         $a++;
         $class = '';
         $td = '';
         switch ($la->resultado){
           case 'a': 
             $class = "table-success"; 
             $td = '<td><a href="../forms/'. $la->form .'/vista.php?p='. $proj->id.  '&v='. $la->ver . '" target="_blank">📄 </a></td>';
   
             array_push($btnStatus, new Blocos($la->fase_seq,'success'));
             break;
           case 'r': 
             $class = "table-danger"; 
             $td = '<td><a href="../forms/'. $la->form .'/vista.php?p='. $proj->id.  '&v='. $la->ver . '" target="_blank">📄 </a></td>';
   
             array_push($btnStatus, new Blocos($la->fase_seq,'danger'));
             break;
           default: 
             $class = "table-warning"; 
             $td = '<td><span class="badge badge-light">Espera de parecer...</span></td>';
   
             array_push($btnStatus, new Blocos($la->fase_seq,'warning'));
         }
         $LastV .=
         '<tr class="'.$class.'">
           <td><a href="../projetos/visualizar.php?id='. $proj->id. '&v='. $la->ver . '&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver +1).'</span></a></td>'
           
           . $td .
           
           '<td>'.$la->fase_seq.'/'.$la->etapas.'</td>
          </tr>';
   
          $etapas = $la->etapas;
   
       }
       $LastV .=
         '</tbody>
       </table>';
   
       if($a==0){
         $LastV = '';
         $progresso = '<span class="badge badge-warning">Não submetido</span>';
       } else {
   
         $btnStatus = array_reverse($btnStatus);
   
         $btnS = [];  /// criando todos os blocos em CINZA
         for ($x = 0; $x <= $etapas -1; $x++) {
           array_push($btnS, new Blocos($x,'secondary'));
         }
   
         $progresso = 
          '<span class="badge badge-light">Processo<br>
            <div class="btn-group">';
   
         foreach($btnStatus as $btn){
           $btnS[$btn->pos -1] = $btn;
         }
   
   
         foreach($btnS as $btn){
   
           $progresso .= '<button type="button" class="btn btn-'. $btn->cor .'" disabled></button>';
         }
   
        $progresso .= 
          ' </div>
          </span>';
   
       }

    }


   /********************/
    
    $resultados .=  '
<div class="card mt-2">
  <div class="card-header">
    <div class="row">
        <div class="col-sm-5">📃 <strong>Título: </strong><a class="collapsed card-link" data-toggle="collapse" href="#p'. $proj->id .'"><strong>'. $proj->titulo .'</strong></a></div>
        <div class="col-sm-5"><strong>Tipo de Proposta:</strong> '. $proj->tipo_exten .'</div>
        <div class="col-sm-2">'. $progresso .'</div>
    </div>
    <div class="row">
        <div class="col-sm"><strong>Enviado para o colegiado de:</strong> '.$col.'</div> 
    </div>
    <div class="row">
        <div class="col-sm">
          Coordenador: '.$proj->nome_prof. '
        </div>
        <div class="col-sm">
          Campus: '.$proj->campus. '
        </div>
        <div class="col-sm">
          TIDE: '.$proj->tide. '
        </div>
    </div>
  </div>


  
    <div id="p'. $proj->id  .'" class="collapse" data-parent="#accordion">
      <div class="card-body">

        <div class="row">
          <div class="col-9">
            <p><strong>Resumo:</strong> '. resumirTexto($proj->resumo)  .'</p>
            <p><strong>Objetivos:</strong> '. resumirTexto($proj->objetivos)  .'</p>
          </div>
          <div class="col">
          '. $LastV .'
          </div>
        </div>

        ';

       $verAnt = $proj->ver - 1;
//Btn Submeter ou 
      $btnSub;        
      if($proj->para_avaliar < 0){
        $btnSub = 
        '<button id="sub'. $proj->id . 'v'. $proj->ver . '" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter</button>
         <div class="p-1"></div>
         <button id="del'. $proj->id . 'v'. $proj->ver . '" class="btn btn-danger  btn-sm mb-2" onclick="writeNumber(this)">🗑 Excluir</button>';
      }else {
        if($proj->last_result == 'r'){
          $btnSub = '<a href="../forms/'.$proj->form.'/vista.php?p='. $proj->id .'&v='. $verAnt .'"><button class="btn btn-danger btn-sm mb-2" >📑 Informações de adequações</button></a>';
        } else {
          $btnSub = '<button id="Alt'. $proj->id . 'v'. $proj->ver . '" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter novamente</button>';
        }
      }


      if ($proj->edt == 1){
         $resultados .=  
      '<hr>
         <div class="d-flex flex-row-reverse ">'  
          . $btnSub .   
         '
          <div class="p-1"></div>
          <a href="editar.php?id='. $proj->id . '&v='. $proj->ver . '"><button class="btn btn-success btn-sm mb-2">📄 Editar</button></a>
        </div>';
      } else {
        $nomecol = Colegiado::getRegistro($proj->para_avaliar);

   
        $resultados .=  
      '<hr>
        
        <div class="d-flex flex-row-reverse ">
          <a href="visualizar.php?id='. $proj->id . '&v='. $proj->ver . '&w=1" target="_blank"><button class="btn btn-success btn-sm mb-2">Visualizar</button></a>
        </div>';
      }

     $resultados .=  '
      </div>
    </div>
  </div>';

  }
  $resultados .= '</div>';


  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


include '../includes/paginacao.php';


?>

<main>
  <h2 class="mt-0">Meus projetos</h2>
  
  <?=$msgAlert?> 
  <section>

    <form method="get">

      <div class="row my-2">

      <div class="col-4">
          <label>Titulo</label> 
          <input type="text" name="titulo" class="form-control form-control-sm" value="<?=$titulo?>"  id="titulo"   onchange="showLimpar();">
        </div>

        <div class="col-4">
          <label>Coordenador</label> 
          <input type="text" name="nome_prof" class="form-control form-control-sm" value="<?=$nome_prof?>"  id="nome_prof"   onchange="showLimpar();">
        </div>

        <div class="col-3">
          <label>Palavra chave</label> 
          <input type="text" name="palavra" class="form-control form-control-sm" value="<?=$palavra?>"  id="palavra"   onchange="showLimpar();">
        </div>


        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>

      </div>

    </form>

  </section>

  <section>

    
    <?=$resultados?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?=$paginacao?>
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
   echo 'const optspara = `' ;
   echo $coolSelectSend; 
   echo '`;';
   echo '</script>';
  
  ?>



<script>

  const modalTitle  = document.getElementById('modalTitle');
  const modalBody   = document.getElementById('modalBody');
  const modalFooter = document.getElementById('modalFooter');

  const btnLimpar = document.getElementById('limpar');

  btnLimpar.hidden = true;

  function showLimpar(){
    var titulo    = document.getElementById('titulo').value;
    var palavra   = document.getElementById('palavra').value;

    if((titulo.length > 0 ) || (palavra.length > 0 ) ) {
      btnLimpar.hidden = false;
    } 
  }

  showLimpar();
  
  function ativaBTN() {
    var btn = document.getElementById('btnSubmit');
    var opt = document.getElementById('selPara');
    var b = document.getElementById('selecOpt');
    b.value = opt.value;
  
    
    if((opt.value != -1 ) ){
      btn.disabled=false;
      
    } else {
      btn.disabled=true;
  
    }
  }


  function printDel(data){
    modalTitle.innerText = 'Confirmação de exclusão';
    modalBody.innerHTML =  `<h4>Tem certeza que deseja apagar o registro abaixo?</h4><p class="justify-content-center"> ${data.titulo}</p><span class="badge badge-warning float-right" ><span class="badge badge-light">⚠️</span>Atenção! O processo não pode ser revertido</span>`;
    modalFooter.innerHTML = `
            <a href="excluir.php?id=${data.id}&v=${data.created_at}" 
                                  class="btn btn-danger    btn-sm mb-2">🗑  Excluir</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }



  function printSubAlt(data){
    modalTitle.innerText = 'Reenvio do projeto à PROEC';
    modalBody.innerHTML = `
          <div class="modal-body" id="modalBody">
            <h4>${data.titulo}</h4>
            <p>Ao confirmar que realizou as solicitações de alterações, clique para submeter a nova versão.</p>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="para_avaliar">Colegiado de </label>
                    <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                      <option value="${data.para_avaliar}" selected>${data.colegiado}</option>
                    </select>
                  </div>
                </div>
             </div>
          </div>
    `;
    modalFooter.innerHTML = data.innerHTML = `
            <form method="post" action="submeter.php?">
                <input type="hidden" name="modIDprj"   value="${data.id}">
                <input type="hidden" name="selecOpt"   value="${data.para_avaliar}" id="selecOpt">
                <input type="hidden" name="modVerPrj"  value="${data.ver}">
                <input type="hidden" name="modCreated" value="${data.created_at}">
                <button type="submit" class="btn btn-primary btn-sm mb-2" id="btnSubmitN">📤 Submeter nova versão</button>
            </form>                    
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }



  function printSub(data){
    modalTitle.innerText = 'Submissão de projeto';
    modalBody.innerHTML = `
          <div class="modal-body" id="modalBody">
            <h4>${data.titulo}</h4>
            <p>Ao submeter o projeto à PROEC, estás a aceitar que este será avaliado pelas instâncias competentes.</p>
            <p>Não será mais possível editá-lo a não ser que haja uma solicitação para isso.</p>
            <p>Concordando com o informado, selecione o colegiado o qual julga ser relacionado a ele e clique em Submeter.</p>
            
            
             <div class="row">
               <div class="col-12">
                 <div class="form-group">
                    <label for="para_avaliar">Enviar para o colegiado de </label>
                    <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                      <option value="-1">Selecione</option>
                      ${optspara}
                    </select>
                 </div>
               </div>
             </div>
          </div>
    `;
  
    modalFooter.innerHTML = data.innerHTML = `
            
            <form method="post" action="submeter.php?">
                <input type="hidden" name="modIDprj"   value="${data.id}">
                <input type="hidden" name="selecOpt"   value="" id="selecOpt">
                <input type="hidden" name="modVerPrj"  value="${data.ver}">
                <input type="hidden" name="modCreated" value="${data.created_at}">
                <button type="submit" class="btn btn-primary btn-sm mb-2" id="btnSubmit" disabled>📤 Submeter</button>
            </form>                    
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }

  const getProjDados = async(id) => {
    const oper = id.substr(0,3);
    const data = await fetch(`../api/proj.php?prj=${id}`)
      .then(resp => resp.json()).catch(error => false);
  
    if(!data) return;
    
    printDel(data);
  
    if(oper == 'del'){
      printDel(data);
    } else if(oper == 'sub'){
      printSub(data);
    } else if(oper == 'Alt'){
      printSubAlt(data);
    } else {
      return;
    }
  }
  
  function writeNumber(elementId) {
    var outputValueTo =   elementId.id;
    getProjDados(outputValueTo);
  
  }

  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  

  btnOpen.onclick = function(){
    modal.showModa();
  }


</script>
