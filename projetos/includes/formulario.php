<main>

<?php
$anexoII  = [3, 4, 5]; // Programa / Projeto / Serviço
$anexoIII = [1, 2];    // Curso / Evento
$t = $obProjeto->tipo_exten;

?>
  <section>
    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>

  <h3 class="mt-3"><?=TITLE?></h2>

  <form  id="upload" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_prof" value="<?=$obProjeto->id_prof ?>">
    <input type="hidden" name="tabela" value="projetos">
    <hr>
    <div class="form-group">
      <label><h5><?=$n = 1?>. Título da proposta</h5></label>
      <input type="text" class="form-control" required name="titulo" value="<?=$obProjeto->titulo?>" >
    </div>
    
    <div class="form-group">
      <label><h5><?=++$n?>. Coordenador(a)</h5></label>
      <input type="text" class="form-control" name="coordNome" readonly value="<?=$obProjeto->nome_prof?>">
    </div>

    <label><h5><?=++$n?>. Contato do Coordenador</h5></label>
    <div class="row">
      <div class="form-group col">
        <label><h6><?=$n?>.1. Telefone</h6></label>
          <input type="text" class="form-control" name="tel" readonly value="<?=$dadosProf->telefone?>">
      </div>
      
      <div class="form-group col">
        <label><h6><?=$n?>.2. Email</h6></label>
          <input type="text" class="form-control" name="email" readonly value="<?=$dadosProf->email?>">
      </div>
    </div>
<?php
    if (in_array($t, $anexoII)) {
?>
    
      <div class="form-group">
          <label><h5><?=++$n?>. A proposta está vinculada a alguma disciplina do curso de Graduação ou Pós-Graduação (ACEC II)</h5></label>
            <select name="tide" class="form-control">
              <option value="s" <?= ($obProjeto->tide=='s')? 'selected': ' ' ?> >Sim</option> 
              <option value="n" <?= ($obProjeto->tide=='n')? 'selected': ' ' ?> >Não</option>
            </select>
          </div>
 <?php
  }
?>


<div class="form-group">
  <label><h5><?=++$n?>. Vinculação à Programa de Extensão e Cultura</h5></label>
  <div class="row">
    <div class="col-3">
      <label><h6>É vinculado?</h6></label>
      <select name="vinc_prog_ec" id="vinc_prog_ec" class="form-control" onchange="showTitProg();">
        <option value="s" <?= ($obProjeto->tide=='s')? 'selected': ' ' ?> >Vinculado</option> 
        <option value="n" <?= ($obProjeto->tide=='n')? 'selected': ' ' ?> >Não vinculado</option>
      </select>
    </div>
    <div class="col-9" id="titProgDIV" >
      <label><h6>Título do Programa de vinculação</h6></label>
      <input type="text" class="form-control"  name="titulo_progvinc" id="titulo_progvinc" value="<?=$obProjeto->titulo?>" >
    </div>

<script type="text/javascript">
  const titProgDIV     = document.getElementById('titProgDIV');
  const Tex_Prog_vinc  = document.getElementById('titulo_progvinc');
  const opcao          = document.getElementById('vinc_prog_ec');
     
  function showTitProg() {
    
    if(opcao.value == 's'){
      titProgDIV.hidden = false;
    } else {
      Tex_Prog_vinc.value = '';
      titProgDIV.hidden = true;          
    }
  }
</script>    
</div>
<hr>
<label><h5><?=++$n?>. Classificação do Projeto ou Programa</h5></label>

<?php
if (in_array($t, $anexoII)) {
?>

    <div class="row">

      <div class="col">
        <div class="form-group">
          <label for="area_cnpq">Área de Conhecimento CNPQ</label>
          <select name="area_cnpq" class="form-control">
            <?=$selectAreaCNPQ?>
          </select>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="area_tema1">Área Temática</label>
          <select name="area_tema1" class="form-control">
            <?=$areaOptions?>
          </select>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="area_tema2">Área Temática Secundária</label>
          <select name="area_tema2" class="form-control">
          <?=$areaOptions2?>
          </select>
        </div>
      </div>


    </div>
<?php
  }
?>

    <div class="row">

      <div class="col">
        <div class="form-group">
          <label for="area_extensao">Área de extensão</label>
          <select name="area_extensao" class="form-control">
            <?=$area_ext_Opt?>
          </select>
        </div>
      </div>


      <div class="col">
        <div class="form-group">
          <label for="linh_ext">Linhas de  extensão</label>
          <select name="linh_ext" class="form-control">
            <?=$area_ext_Opt?>
          </select>
        </div>
      </div>
    </div>

<hr>
<label><h5><?=++$n?>. Período de Realização e Carga Horária</h5></label>
    <div class="row">
          <div class="col-3">
        <div class="form-group">
          <label>Início vigência</label>
          <input type="date" name="vigen_ini" class="form-control" value="<?= substr ($obProjeto->vigen_ini,0, 10) ?>" required>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label>Fim vigência</label>
          <input type="date" name="vigen_fim" class="form-control" value="<?= substr ($obProjeto->vigen_fim,0, 10) ?>" required>
        </div>
      </div>
     
<?php
  if (in_array($t, $anexoII)) {
?>
      <div class="col">
        <div class="form-group">
          <label>Carga semanal (h)</label>
          <input type="number"  min=0 max=44 class="form-control" name="ch_semanal" value="<?=$obProjeto->ch_semanal?>">
        </div>
      </div>

<?php
  }
?>

<?php
  if (in_array($t, $anexoIII)) {
?>

      <div class="col">
        <div class="form-group">
          <label>Carga total (h)</label>
          <input type="number"  min=0 max=1000 class="form-control" name="ch_total" value="<?= $obProjeto->ch_total ?>">
        </div>
      </div>

      


<?php
  }  
  if (in_array($t, $anexoII)) {
?>
    <div class="col">
        <div class="form-group">
          <label for="tide">TIDE</label>
          <select name="tide" class="form-control">
            <option value="s" <?= ($obProjeto->tide=='s')? 'selected': ' ' ?> >Sim</option> 
            <option value="n" <?= ($obProjeto->tide=='n')? 'selected': ' ' ?> >Não</option>
          </select>
        </div>
      </div>


<?php
  }
?>
    </div>



    

<hr>

<div class="row">
      <div class="col">
        <div class="form-group">

          <label for="public_alvo"><h5><?=++$n?>. Publico alvo</h5></label>
          <textarea class="form-control" name="public_alvo" rows="10" 
          placeholder="(Mencionar de forma sucinta os beneficiários e a(s) região(ões) de abrangência do projeto). 5 linhas máximo."
          ><?=$obProjeto->public_alvo?></textarea>
        </div>
      </div>
    </div>
  


----------------------------------------


    <hr>
    <hr>
    <h4>Dados Técnicos</h4>

    <div class="row">
      <div class="col">
        <div class="form-group">
        <label><h5><?=++$n?>. Resumo do Projeto</h5></label>
          <textarea class="form-control" name="resumo" rows="10" 
          placeholder="Descrever o resumo da ação de extensão (no máximo 250 palavras), destacando sua relevância na perspectiva acadêmica e social, o público a que se destina e o resultado esperado. Este texto poderá ser publicado na homepage da PROEC, portanto, recomenda-se revisá-lo corretamente."
          ><?=$obProjeto->resumo?></textarea>
        </div>
      </div>
    </div>

    <hr>
    <h4>Descrição do Projeto</h4>

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label><h5><?=++$n?>. Problema e Justificativa</h5></label>
          <textarea class="form-control" name="descricao" rows="10" 
          placeholder="(Identificar o problema e justificaro projeto). 20 linhas máximo"
          ><?=$obProjeto->descricao?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label><h5><?=++$n?>. Objetivo Geral e Objetivos Específicos</h5></label>
          <textarea class="form-control" name="objetivos" rows="10" 
          placeholder="(O Objetivo Geral é a ação macro que se quer alcançar. E os Objetivos Específicos são as ações fracionadas, para se alcançar o Objetivo Geral). 10 linhas máximo."
          ><?=$obProjeto->objetivos?></textarea>
        </div>
      </div>
    </div>

    
    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="metodologia"><h5><?=++$n?>. Metodologia para Execução do Projeto</h5></label>
          <textarea class="form-control" name="metodologia" rows="10" 
          placeholder="(Explicar os procedimentos necessários para a execução do projeto destacando o método, ou seja, a explicação do delineamento do estudo, amostra, procedimentos para a coleta de dados, bem como, o plano para a análise de dados). 20 linhas máximo."
          ><?=$obProjeto->metodologia?></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="prodserv_espe"><h5><?=++$n?>. Produtos/Serviços Esperados</h5></label>
          <textarea class="form-control" name="prodserv_espe" rows="10" 
          placeholder="(Relacionar neste tópico os produtos, equipamentos, bens, serviços, patentes e/ou registros resultantes deste projeto). 10 linhas máximo"
          ><?=$obProjeto->prodserv_espe?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="contribuicao"><h5><?=++$n?>. Contribuição Científica, Tecnológica e de Inovação</h5></label>
          <textarea class="form-control" name="contribuicao" rows="10" 
          placeholder="(Identificar de que forma os resultados esperados do projeto contribuirão no cenário científico, tecnológicoe cultural  ). 10 linhas máximo"
          ><?=$obProjeto->contribuicao?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="contrap_nofinac"><h5><?=++$n?>. Contrapartida não Financeira da Instituição Proponente</h5></label>
          <textarea class="form-control" name="contrap_nofinac" rows="10" 
          placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"
          ><?=$obProjeto->contrap_nofinac?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="municipios_abr">Listar os Municípios Abrangidos pelo Projeto</label>
          <textarea class="form-control" name="municipios_abr" rows="10" 
          placeholder=""
          ><?=$obProjeto->municipios_abr?></textarea>
        </div>
      </div>
    </div>

   <!-- 
    <div class="form-group">
      <label for="area1">Listar os municípios abrangidos pelo projeto</label>
      <select id="municipio" name="id_munic[]" class="form-control js-example-basic-multiple" rows="3" multiple 
      title="Digite o nome do(s) município(s)">
          < ?=$selMunAten ?>
      </select>
    </div>
-->

<!-- 
    <div class="col-2">
        <div class="form-group">
          <label>Aux. Finac</label>
          <select name="aux_financ" class="form-control">
            <option value="s" < ?= ($obProjeto->aux_financ=='s')? 'selected': ' ' ?> >Sim</option> 
            <option value="n" < ?= ($obProjeto->aux_financ=='n')? 'selected': ' ' ?> >Não</option>
          </select>
        </div>
      </div>

   -->   

    

    <hr>
    <h4>Informações complementares</h4>
    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label>Número de certificados previstos</label>
          <input type="number"  min=0 max=200 class="form-control" default="0" name="n_cert_prev" value="<?= $obProjeto->n_cert_prev? $obProjeto->n_cert_prev : 0 ?>"> 
        </div>
      </div>
      <div class="col"><br><br>0 para que não tenha emissão de certificados.
      </div>
    </div>


    

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="outs_info">Outras informações que julgar importantes</label>
          <textarea class="form-control" name="outs_info" rows="10" 
          placeholder=""
          ><?=$obProjeto->outs_info?></textarea>
        </div>
      </div>
    </div>


    <hr>

    

    

    <div class="row">

      <div class="col-3">
        <div class="form-group">
          <label>Data</label>
          <input type="date" name="data" class="form-control" id="dateAssing" value="<?= substr ($obProjeto->data, 0 ,10) ?>" requiredd>
        </div>
      </div>
    </div>
    
<!--

    <div class="form-group">
      <h4>Anexos</h4>
      <ul id="anexos"></ul>
      <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
      <?=$anex?>
    </div>
-->
    
    <div class="form-group">
      <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <p><br><br></p>
        </div>
      </div>
    </div>
  

  </form>
<?php

if(TITLE == 'Cadastrar projeto'){
  echo "
        <script>
            document.getElementById('dateAssing').valueAsDate = new Date();
        </script>    
          ";
}

?>


</main>


 