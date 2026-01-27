<?php
$tituloHeader = '';
switch ($tf) {
    case 'fi':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA';
        break;
    case 'pr':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de PRORROGAÇÃO DE PRAZO';
        break;
    case 're':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de RENOVAÇÃO';
        break;
    default:
        $tituloHeader = 'não definido';
        break;
}

?>
<main>
  
  <section>
    
      <button class="btn btn-success btn-sm float-right" id="backBtn">Voltar</button>
    
  </section>
  <hr>
  <h4 style="text-align: center">ANEXO V</h4>
  <h3 class="mt-3" style="text-align: center"><?php echo $tituloHeader; ?></h3>

  <?php

    /* if(!(
        ( ($relatorio->tramitar == 0)     or is_null($relatorio->tramitar)     or ($relatorio->tramitar == ''))      and
        ( ($relatorio->ava_publicar == 0) or is_null($relatorio->ava_publicar) or ($relatorio->ava_publicar == ''))  and
        (strlen($relatorio->ava_comentario) == 0)
       )
    ){
      echo '
      <div class="form-group">
      <label>
        <h5> Solicitação de ajustes do relatório parcial </h5>
      </label>
        <textarea rows="4" cols="50" readonly class="form-control">
        c:' . $relatorio->ava_comentario . '|t:'. $relatorio->tramitar.'|p:'. $relatorio->ava_publicar.'|
        </textarea>
      </div>

      ';
    //}
*/
?>


  <form name="formAnexo" id="formAnexo" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_prof" value="<?php echo $obProjeto->id_prof; ?>">
    <input type="hidden" name="tabela" value="projetos">
    <input type="hidden" name="valida" value="ok">
    <hr>
    <div class="form-group">
      <label>
        <h5><?php echo $n = 1; ?>. Título da proposta</h5>
      </label>
      <input type="text" class="form-control"  value="<?php echo $obProjeto->titulo; ?>" readonly>
    </div>
    
    
    <hr>
    <?php echo $msgSolicitacoAlteracao; ?>

    <div class="form-group">
      <label>
        <h5><?php echo ++$n; ?>. Protocolo da proposta</h5>
      </label>
      <input type="text" class="form-control" name="protocolo" readonly value="<?php echo $obProjeto->protocolo; ?>">
    </div>

    <hr>

    <div class="form-group">
      <label>
        <h5><?php echo ++$n; ?>. Coordenador(a)</h5>
      </label>
      <input type="text" class="form-control" name="coordNome" readonly value="<?php echo $obProjeto->nome_prof; ?>">
    </div>

    
    <hr>


      <!-- visita tecnica -->
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="visita_tec_qtd">
              <h5><?php echo ++$n; ?>. Quantidade de visitas técnicas realizadas</h5>
            </label>
            <input type="number" id="visita_tec_qtd" name="visita_tec_qtd" class="form-control my-2 w-25" min="0" value="<?php echo $relatorio->visita_tec_qtd; ?>" <?php echo $editar; ?> >
          </div>
        </div>
      </div>

    <hr>

    <label>
      <h5><?php echo ++$n; ?>. Contato do Coordenador</h5>
    </label>
    <div class="row">
      <div class="form-group col">
        <label>
          <h6><?php echo $n; ?>.1. Telefone</h6>
        </label>
        <input type="text" class="form-control" name="tel" readonly value="<?php echo $obProfessor->telefone; ?>">
      </div>

      <div class="form-group col">
        <label>
          <h6><?php echo $n; ?>.2. Email</h6>
        </label>
        <input type="text" class="form-control" name="email" readonly value="<?php echo $obProfessor->email; ?>">
      </div>
    </div>

    <hr>

    <div class="form-group">
      <label>
        <h5><?php echo ++$n; ?>. Colegiado de Curso*/ Setor</h5>
      </label>
      <input type="text" class="form-control" name="cursosetor" readonly value="<?php echo $cursosetor; ?>">
    </div>

    <hr>

    <hr>
      <?php
              if ($relatorio->tramitar == 0) {
                  if ($obProjeto->id_prof != $user['id']) {
                      echo '';
                  } else {
                      ?>
      <div class="form-group">
        <h5 id="">Pronto para tramitação</h5>
        <label for="tramitar">Ao marcar esta <input type="checkbox" id="tramitar" name="tramitar" value="1"> opção, depois de salvo, este relatório ficará visível para aprovação e perderá o modo de edição.</label>
           
      </div>
      <hr>
      <?php }
                  }  ?>

      <div class="row" >

        <div class="col-3">
          <div class="form-group">
            <label>Data</label>
            <input type="date" name="data" class="form-control" id="dateAssing" value="<?php echo (substr($relatorio->created_at, 0, 10)) ?: date('Y-m-d'); ?>" required <?php echo $editar; ?>>
          </div>
        </div>
      </div>

      

      <div class="form-group">
      <?php
                  if ($editar == '') {
                      ?>
          <a href="javascript: submitSumbeter()" class="btn btn-success btn-sm" >↗️ Salvar </a>
      <?php } ?>
         <a href="javascript: history.go(-1)" class="btn btn-warning btn-sm" >↗️ Voltar </a>
      </div>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <p><br><br></p>
          </div>
        </div>
      </div>

      <?php
/*
echo date("l \\t\h\e jS");
echo '<br>';
echo $obProjeto->vigen_ini;
echo '<br>';
echo $obProjeto->vigen_fim;
echo '<br>';

$periodo_fim1 = substr($obProjeto->vigen_ini, 0, 10);
$periodo_fim1 = substr($obProjeto->vigen_fim, 0, 10); */

?>
       
      <input type="hidden" name="tabela" value="relatorios">
      <input id="anexosJS" name="anexosJS" type="text" hidden>


  </form>

</main>
<script src="forms.js"></script>