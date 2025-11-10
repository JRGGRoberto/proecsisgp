<?php

require '../includes/msgAlert.php';

function tipo($tipo)
{
    switch ($tipo) {
        case 'fi':
            return ['Final', 'f'];
            break;
        case 'pr':
            return ['Final com pedido de prorrogação', 'f'];
            break;
        case 're':
            return ['Final com pedido de renovação', 'f'];
            break;
        case 'pa':
            return ['Parcial', 'p'];
            break;
        default:
            return ['não definido', 0];
            break;
    }
}

$resultados = '';

foreach ($relatorios as $relf) {
    $tipo = tipo($relf->tipo);
    $msgPublicadoFinal = '';
    $btns = '';

    if ($relf->tramitar == 1) {
        $btns = '<a href="editar'.$tipo[1].'.php?id='.$relf->id.'" class="card-link">Visualizar</a> ';

        if ($relf->publicado == 1) {
            $msgPublicadoFinal = ' <span class="badge badge-success">Publicado</span>';
        } else {
            $msgPublicadoFinal = '<span class="badge badge-warning">Aguardando análise(s) - ('.$relf->etapa.'/'.$relf->etapas.')</span>';
            // if($relf->last_result = 'n'){}
        }
    } else {
        $btns = '<a href="editar'.$tipo[1].'.php?id='.$relf->id.'" class="card-link">Editar</a> ';
        $btns .= '<a href="#" onclick="printDel(\''.$relf->id.$tipo[1].'\')" class="card-link">Excluir</a> ';
        chEstado('fi', $opcoes);

        if ($relf->last_result == 'n') {
            $msgPublicadoFinal = '<span class="badge badge-secondary">Não submetido - ('.$relf->etapa.'/'.$relf->etapas.')</span>';
        } elseif ($relf->last_result == 'r') {
            $msgPublicadoFinal = '<span class="badge badge-danger">Adequações solicitadas - ('.$relf->etapa.'/'.$relf->etapas.')</span>';
        } else {
            $msgPublicadoFinal = '<span class="badge badge-info">?? etapas('.$relf->etapa.'/'.$relf->etapas.') tramitar('.$relf->tramitar.') result('.$relf->last_result.')</span>';
        }
    }

    $resultados .= '<div class="card">';
    $resultados .= '<div class="card-body">';
    $resultados .= $msgPublicadoFinal;
    $resultados .= '<h5 class="card-title">Relatório '.$tipo[0].'</h5>';
    $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades realizadas</h6>';
    //  $resultados .= '<p class="card-text">'.$relf->atividades.'</p>';
    $resultados .= $btns;
    $resultados .= '</div>';
    $resultados .= '</div>';
}

?>


<main>
  <h2 class="mt-0">Relatórios</h2>
  <hr>
  
  <div class="form-group">
    <div>
      <h5>Título da proposta</h5>
      <input type="text" class="form-control" value="<?php echo $obProjeto->titulo; ?>" readonly><br>
    </div>
    <div class="row">

          <div class="col-3">
            <div class="form-group">
              <label>Modalidade</label>
              <input type="text" class="form-control" value="<?php echo $tipoE; ?>" readonly>
              
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" class="form-control" value="<?php echo substr($obProjeto->vigen_ini, 0, 10); ?>" readonly>
            </div>
          </div>
          
          <div class="col-2">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" class="form-control" value="<?php echo substr($obProjeto->vigen_fim, 0, 10); ?>" readonly>
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
               <label>Projeto</label><br>
                <a href="../projetos/visualizar.php?id=<?php echo $obProjeto->id; ?>&amp;v=<?php echo $obProjeto->ver; ?>&amp;w=1" target="_blank">
                  <button class="btn btn-success btn-sm mb-2">Visualizar</button>
                </a>
            </div>
          </div>

         </div>
         <hr>
         
  </div>
  
  <?php echo $msgAlert; ?> 

  <section>
    
    <?php echo $resultados; ?>
    
  </section>

<?php

// se não houver opções de relatórios, não exibe o botão
if (sizeof($opcoes) > 0) {
    $novoBTNs = '<section>
            <div class="row mt-2 align-bottom">
              <div class="col" >
    
                <div class="dropup">
                  <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
                    Novo
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">';

    foreach ($opcoes as $key => $value) {
        $novoBTNs .= $value;
    }

    $novoBTNs .= '</div>
                </div>
              </div>
            </div>
          </section>
        ';
}

echo $novoBTNs;

?>
  <div class="form-group">
    <a href="../projetos/" class="btn btn-success btn-sm mb-2">Voltar</a>&nbsp; &nbsp;  <?php echo $msgInfoEstado; ?>
  </div>

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

<script>

function printDel(id){
//    event.preventDefault(); 
    console.log(id);
    // excluir1.php
   modalTitle.innerText = 'Confirmação de exclusão';
    modalBody.innerHTML =  
    `<h4>Tem certeza que deseja apagar o registro de relatório?</h4>
        <p class="justify-content-center"></p><span class="badge badge-warning float-right" ><span class="badge badge-light">⚠️</span>Atenção! O processo não pode ser revertido</span>`;
    modalFooter.innerHTML = `
            <a href="excluir.php?id=${id}" class="btn btn-danger    btn-sm mb-2">🗑  Excluir</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }


</script>







