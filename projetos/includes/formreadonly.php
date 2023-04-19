<main>

<?php

if ($jan != 0) { ?>

<section>
    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>

<?php
} 

$anexoII = [3, 4, 5];
$anexoIII = [1, 2];
$t = $obProjeto->tipo_exten;

switch($t) {
  case 1: 
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE CURSO');
    break;
  case 2:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE EVENTO');
    break;
  case 3:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PRESTAÇÃO DE SERVIÇO');
    break;
  case 4:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMA');
    break;
  case 5:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROJETO');
    break;
  default:
    header('location: index.php?status=error');
    exit;
}

?>

  <h2 class="mt-3"><?=TITLE?></h2>

  <form  id="upload" method="" enctype="">
        <hr>
    <h4>Dados Cadastrais</h4>
    
    <div class="form-group">
      <label>Coordenador</label>
      <input type="text" class="form-control" name="coordNome" value="<?=$obProjeto->nome_prof?>" readonly disabled>
    </div>

    <hr>
    <h4>Título</h4>
    <div class="form-group">
      <label>Título</label>
      <input type="text" class="form-control" name="titulo" value="<?=$obProjeto->titulo?>"  readonly disabled>
    </div>

    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label>Proposta</label>
          <select name="tipo_exten" class="form-control"  readonly disabled>
            <?= $propOptions ?>
          </select>
        </div>
      </div>
      
      <div class="col-1.5">
        <div class="form-group">
          <label>TIDE</label>
          <select name="tide" class="form-control" readonly disabled>
            <option value="s" <?= ($obProjeto->tide=='s')? 'selected': ' ' ?> >Sim</option> 
            <option value="n" <?= ($obProjeto->tide=='n')? 'selected': ' ' ?> >Não</option>
          </select>
        </div>
      </div>
    </div>
<hr>
<h4> Período de Realização e Carga Horária</h4>
    <div class="row">
          <div class="col-3">
        <div class="form-group">
          <label>Início vigência</label>
          <input type="date" name="vigen_ini" class="form-control" value="<?= substr ($obProjeto->vigen_ini,0, 10) ?>"  readonly disabled>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label>Fim vigência</label>
          <input type="date" name="vigen_fim" class="form-control" value="<?= substr ($obProjeto->vigen_fim,0, 10) ?>"  readonly disabled>
        </div>
      </div>
     

      <div class="col">
        <div class="form-group">
          <label>Carga semanal (h)</label>
          <input type="number"  min=0 max=44 class="form-control" name="ch_semanal" value="<?=$obProjeto->ch_semanal?>"  readonly disabled>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Carga total (h)</label>
          <input type="number"  min=0 max=1000 class="form-control" name="ch_total" value="<?= $obProjeto->ch_total ?>"  readonly disabled>
        </div>
      </div>

    </div>

    <hr>
    <h4>Classificação do Projeto ou Programa</h4>

    <div class="row">

      <div class="col">
        <div class="form-group">
          <label for="area_cnpq">Área de Conhecimento CNPQ</label>
          <select name="area_cnpq" class="form-control"  readonly disabled>
            <?=$selectAreaCNPQ?>
          </select>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="area_tema1">Área Temática</label>
          <select name="area_tema1" class="form-control" readonly disabled>
            <?=$areaOptions?>
          </select>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="area_tema2">Área Temática Secundária</label>
          <select name="area_tema2" class="form-control" readonly disabled>
          <?=$areaOptions2?>
          </select>
        </div>
      </div>


    </div>

    <div class="row">

      <div class="col">
        <div class="form-group">
          <label for="area_extensao">Área de extensão</label>
          <select name="area_extensao" class="form-control" readonly disabled>
            <?=$area_ext_Opt?>
          </select>
        </div>
      </div>


      <div class="col">
        <div class="form-group">
          <label for="linh_ext">Linhas de  extensão</label>
          <select name="linh_ext" class="form-control" readonly disabled>
            <?=$area_ext_Opt?>
          </select>
        </div>
      </div>
    </div>

    <hr>
    <h4>Dados Técnicos</h4>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="resumo">Resumo do Projeto</label>
          <textarea class="form-control" name="resumo" rows="10" readonly disabled
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
          <label for="descricao">Problema e Justificativa</label>
          <textarea class="form-control" name="descricao" rows="10" readonly disabled
          placeholder="(Identificar o problema e justificaro projeto). 20 linhas máximo"
          ><?=$obProjeto->descricao?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="objetivos">Objetivo Geral e Objetivos Específicos</label>
          <textarea class="form-control" name="objetivos" rows="10" readonly disabled
          placeholder="(O Objetivo Geral é a ação macro que se quer alcançar. E os Objetivos Específicos são as ações fracionadas, para se alcançar o Objetivo Geral). 10 linhas máximo."
          ><?=$obProjeto->objetivos?></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="public_alvo">Publico Alvo</label>
          <textarea class="form-control" name="public_alvo" rows="10" readonly disabled
          placeholder="(Mencionar de forma sucinta os beneficiários e a(s) região(ões) de abrangência do projeto). 5 linhas máximo."
          ><?=$obProjeto->public_alvo?></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="metodologia">Metodologia para Execução do Projeto</label>
          <textarea class="form-control" name="metodologia" rows="10" readonly disabled
          placeholder="(Explicar os procedimentos necessários para a execução do projeto destacando o método, ou seja, a explicação do delineamento do estudo, amostra, procedimentos para a coleta de dados, bem como, o plano para a análise de dados). 20 linhas máximo."
          ><?=$obProjeto->metodologia?></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="prodserv_espe">Produtos/Serviços Esperados</label>
          <textarea class="form-control" name="prodserv_espe" rows="10" readonly disabled
          placeholder="(Relacionar neste tópico os produtos, equipamentos, bens, serviços, patentes e/ou registros resultantes deste projeto). 10 linhas máximo"
          ><?=$obProjeto->prodserv_espe?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="contribuicao">Contribuição Científica, Tecnológica e de Inovação</label>
          <textarea class="form-control" name="contribuicao" rows="10" readonly disabled
          placeholder="(Identificar de que forma os resultados esperados do projeto contribuirão no cenário científico, tecnológicoe cultural  ). 10 linhas máximo"
          ><?=$obProjeto->contribuicao?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="contrap_nofinac">Contrapartida não Financeira da Instituição Proponente</label>
          <textarea class="form-control" name="contrap_nofinac" rows="10" readonly disabled
          placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"
          ><?=$obProjeto->contrap_nofinac?></textarea>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group">
          <label for="municipios_abr">Listar os Municípios Abrangidos pelo Projeto</label>
          <textarea class="form-control" name="municipios_abr" rows="10"  readonly disabled
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
          <input type="number"  min=0 max=200 class="form-control" default="0" name="n_cert_prev" value="<?= $obProjeto->n_cert_prev? $obProjeto->n_cert_prev : 0 ?>" readonly disabled> 
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
          placeholder=""  readonly disabled
          ><?=$obProjeto->outs_info?></textarea>
        </div>
      </div>
    </div>


    <hr>

    

    

    <div class="row">

      <div class="col-3">
        <div class="form-group">
          <label>Data</label>
          <input type="date" name="data" class="form-control" id="dateAssing" value="<?= substr ($obProjeto->data, 0 ,10) ?>"  readonly disabled>
        </div>
      </div>
    </div>
    


    
    <div class="form-group">
      <h4>Anexos</h4>
      <ul id="anexos"></ul>
      <?=$anex?>
    </div>

<?php

if ($jan != 0) { ?>

    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>

<?php
} 
?>
    <div class="row">
      <div class="col">
        <div class="form-group">
          <p><br><br></p>
        </div>
      </div>
    </div>
  

  </form>



</main>


 