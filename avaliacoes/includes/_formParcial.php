<?php $tituloHeader = 'RELATÓRIO PARCIAL'; ?>
<main>
  
  <section>
    <a href="./index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>
  <hr>
  <h4 style="text-align: center">ANEXO IV</h4>
  <h3 class="mt-3" style="text-align: center">RELATÓRIO PARCIAL</h3>

   <input type="hidden" name="id_prof" value="<?php echo $obProjeto->id_prof; ?>">
    <input type="hidden" name="tabela" value="projetos">
    <hr>
    <div class="form-group">
      <label>
        <h5><?php echo $n = 1; ?>. Título da proposta</h5>
      </label>
      <input type="text" class="form-control"  value="<?php echo $obProjeto->titulo; ?>" readonly>
    </div>
    
    <hr>

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

    <label>
      <h5><?php echo ++$n; ?>. Contato do Coordenador</h5>
    </label>
    <div class="row">
      <div class="form-group col">
        <label>
          <h6><?php echo $n; ?>.1. Telefone</h6>
        </label>
        <input type="text" class="form-control" name="tel" readonly value="<?= $obProfessor->telefone; ?>">
      </div>

      <div class="form-group col">
        <label>
          <h6><?php echo $n; ?>.2. Email</h6>
        </label>
        <input type="text" class="form-control" name="email" readonly value="<?= $obProfessor->email; ?>">
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

  <?php 
  $ini = null;
  if(!is_null($relatorio->periodo_ini)){
    $ini = substr($relatorio->periodo_ini, 0, 10);
  } 
  $fim = null;
  if(!is_null($relatorio->periodo_fim)){
    $fim = substr($relatorio->periodo_fim, 0, 10);
  }
  ?>
    <div class="form-group">
      <label>
        <h5><?php echo ++$n; ?>. Período que se refere o Relatório</h5>
      </label>
      <div class="row">
        <div class="col-3">
          <div class="form-group">
            <label>Início</label>
            <input type="date" name="periodo_ini" id="periodo_ini" class="form-control" value="<?= $ini;?>" required readonly >
          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Fim</label>
            <input type="date" name="periodo_fim" id="periodo_fim" class="form-control" value="<?= $fim; ?>" required readonly >
          </div>
        </div>

        
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="atvd_per">
              <h5><?php echo ++$n; ?>. Atividades realizadas no período</h5>
            </label>
            <div id="sumnot_atvd_per"  ><?php echo $relatorio->atvd_per; ?></div>
            <textarea id="atvd_per" name="atvd_per" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Alterações realizadas no período da pesquisa e justificativa</h5>
            </label>
            <div id="sumnot_alteracoes"><?php echo $relatorio->alteracoes; ?></div>
            <textarea id="alteracoes" name="alteracoes" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="atvd_prox_per">
              <h5><?php echo ++$n; ?>. Atividades para o próximo período</h5>
            </label>
            <div id="sumnot_atvd_prox_per"><?php echo $relatorio->atvd_prox_per; ?></div>
            <textarea id="atvd_prox_per" name="atvd_prox_per" rows="10" hidden></textarea>
          </div>
        </div>
      </div>

      <hr>

      <?php 
          if($relatorio->tramitar == 0) {
            if($obProjeto->id_prof != $user['id']) {
              echo '';
            } else {
      ?>
      <div class="form-group">
                 
        <h5 id="">Pronto ser enviado</h5>
        <label for="tramitar">Ao marcar esta <input type="checkbox" id="tramitar" name="tramitar" value="1" > opção, depois de salvo, este relatório ficará visível para aprovação e perderá o modo de edição.</label>
           
      </div>
      <hr>
      <?php }
      }  ?>

      <div class="form-group">
        <h5 id="attc"><?php echo ++$n; ?>. Anexos</h5>
        <ul id="anexos"></ul>
  
        <?php echo $anex; ?>
      </div>
      <hr>

      <div class="row" >

        <div class="col-3">
          <div class="form-group">
            <label>Data</label>
            <input type="date" name="data" class="form-control" id="dateAssing" value="<?php echo substr($relatorio->created_at, 0, 10); ?>" required readonly>
          </div>
        </div>
      </div>

      <div class="form-group">
</main>
<script src="forms.js"></script>