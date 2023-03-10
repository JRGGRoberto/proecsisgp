<?php

  require('../includes/msgAlert.php');

  use \App\Entity\Colegiado;
  use \App\Entity\Avaliacoes;

  $qnt1 = 0;
  $col;

  $resultados = '<div id="accordion">';
  foreach($projetos as $proj){
    $qnt1++;

    is_null($proj->colegiado) ? $col = 'A definir' : $col = $proj->colegiado;



   /*****************/ 

    $progresso = 
    '<span class="badge badge-light">Processo<br>
      <div class="btn-group">';
   
  for($i = 1; $i <= $proj->etapas; $i++){
    if ($i == $proj->fase_seq){
      if($proj->last_result == 'r'){
        $cor = 'danger';
      }else{
        $cor = 'warning';
      }
    } elseif ($i < $proj->fase_seq){
      $cor = 'success';
    } else {
      $cor = 'secondary';
    }
    $progresso .= '<button type="button" class="btn btn-'. $cor .'" disabled></button>';
  }
  $progresso .= 
    '  </div>
    </span>';

   /*****************/ 

    
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
        
        <div class="col-sm-6"><strong>Área de extensão:</strong> '.$proj->area_extensao.'</div> 
        <div class="col-sm-6"><strong>Linha de extensão:</strong> '.$proj->linh_ext.'</div>
    </div>
  </div>


  
    <div id="p'. $proj->id  .'" class="collapse" data-parent="#accordion">
      <div class="card-body">

        <h5>Resumo</h5>
        <p>'. $proj->resumo  .'</p>

        <h5>Descricao</h5>
        <p>'. $proj->descricao  .'</p>

        <h5>Objetivos</h5>
        <p>'. $proj->objetivos  .'</p>

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
          $btnSub = '<button id="Alt'. $proj->id . 'v'. $proj->ver . '" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Enviar alterações</button>';
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

   $where = 'id_proj = "'. $proj->id. '"';
   $order = "ver desc, fase_seq desc";
   $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);
   $LastV = 
      '<table class="table table-bordered table-sm">
       <thead class="thead-dark">
         <tr>
           <th>Projeto</th>
           <th>Relatório</th>
           <th>Parte</th>
         </tr>
       </thead>
       <tbody>';
    $a =0;
    foreach($ListaVerAnts as $la){
      $a++;
      $class = '';
      $td = '';
      switch ($la->resultado){
        case 'a': 
          $class = "table-success"; 
          $td = '<td><a href="../forms/'. $la->form .'/vista.php?p='. $proj->id.  '&v='. $la->ver . '" target="_blank">📄 </a></td>';
          break;
        case 'r': 
          $class = "table-danger"; 
          $td = '<td><a href="../forms/'. $la->form .'/vista.php?p='. $proj->id.  '&v='. $la->ver . '" target="_blank">📄 </a></td>';
          break;
        default: 
          $class = "table-warning"; 
          $td = '<td>➖</td>';
      }
      $LastV .=
      '<tr class="'.$class.'">
        <td><a href="../projetos/visualizar.php?id='. $proj->id. '&v='. $la->ver . '&w=nw" target="_blank">📄 <span class="badge badge-info">'.($la->ver +1).'</span></a></td>'
        
        . $td .
        
        '<td>'.$la->fase_seq.'/'.$la->etapas.'</td>
       </tr>';
    }
    $LastV .=
      '</tbody>
    </table>';

    if($a==0){
      $LastV = '';
    }
  

        $resultados .=  
      '<hr>
        
        Projeto postado para o colegiado de <span class="badge badge-success">'. $nomecol->nome . '</span> 
            <div class="row my-2">
              <div class="col-2">
              '. $LastV .'
              </div>
              <div class="col">
               
              </div>
            </div>
  
            
        
        <div class="d-flex flex-row-reverse ">
          <a href="visualizar.php?id='. $proj->id . '&v='. $proj->ver . '&w=1"><button class="btn btn-success btn-sm mb-2">👀 Visualizar</button></a>
        </div>';

      }

     $resultados .=  '
      </div>
    </div>
  </div>';

  }
  $resultados .= '</div>';


  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


  //GETS
  unset($_GET['status']);
  unset($_GET['pagina']);
  $gets = http_build_query($_GET);

  //Paginação
  $paginacao = '';
  $paginas   = $obPagination->getPages();
  $paginacao .= '<nav aria-label="Page navigation example">
                  <ul class="pagination pagination-sm">'; 

  foreach($paginas as $key=>$pagina){
    $class = $pagina['atual'] ? 'page-item active': 'page-item';
    $paginacao .= 
      '<li class="'.$class.'">
        <a class="page-link" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'
        .$pagina['pagina']
      .'</a>
       </li>';
  }

  $paginacao .= '</ul>
  </nav>
  ';

?>


<main>
  <h2 class="mt-0">Meus projetos</h2>
  
  <?=$msg?> 

  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col">
          <label>Titulo</label> 
          <input type="text" name="titulo" class="form-control form-control-sm" value="<?=$titulo?>"  id="titulo"  onchange="showLimpar();">
        </div>

        <div class="col">
          <label>Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="<?=$colegiado?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Área de extensão</label>
          <input type="text" name="area" class="form-control form-control-sm" value="<?=$area?>" id="area" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Linha de extensão</label>
          <select name="linh_ext" id="linh_ext" class="form-control form-control-sm">
            <option value="-1"></option>
            <?=$propOptions?>
          <select>

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
      <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a>
      </div>
    </div>
  </section>
</main>





<!-- The Modal -->
  <div class="modal" id="modalSub">
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
          <p>Estás confirmar que realizaste as solicitações de adequasões as quais foram propostas, feito isto, terás tudo para que seu projeto avance para o próximo etapa. Ele será reavaliado pelas instâncias competentes.</p>
          <p>Não será mais possível editá-lo a não ser que haja uma solicitação para isso.</p>
          <p>Concordando com o informado, clique em Submeter.</p>
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
  const data = await fetch(`https://${location.host}/sis/api/proj.php?prj=${id}`)
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
  const modal = document.querySelector("dialog")

  btnOpen.onclick = function(){
    modal.showModa();
  }


  document.getElementById('limpar').hidden = true;

  
  function showLimpar(){
    var titulo    = document.getElementById('titulo').value;
    var colegiado = document.getElementById('colegiado').value;
    var area      = document.getElementById('area').value;
    var linh_ext  = document.getElementById('linh_ext').value;

    if((titulo.length > 0 ) | (colegiado.length > 0)| (area.length > 0)| (linh_ext.length > 0) ) {

      document.getElementById('limpar').hidden = false;
    }
  }

  showLimpar();
  
</script>
