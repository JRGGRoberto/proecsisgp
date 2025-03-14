<main>
  
  <script>
    let formulario = 2;
  </script>

  <section>
    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>
  <hr>
  <h4 style="text-align: center">ANEXO IV</h4>
  <h3 class="mt-3" style="text-align: center"><?php echo TITLE; ?></h3>

  <form name="formAnexo" id="formAnexo" method="POST" enctype="multipart/form-data">
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
        <h5><?php echo ++$n; ?>. Período de vigência</h5>
      </label>
      <div class="row">
        <div class="col-3">
          <div class="form-group">
            <label>Início vigência</label>
            <input type="date" name="vigen_ini" id="vigen_ini" class="form-control" value="<?php echo substr($obProjeto->vigen_ini, 0, 10); ?>" required>
          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Fim vigência</label>
            <input type="date" name="vigen_fim" id="vigen_fim" class="form-control" value="<?php echo substr($obProjeto->vigen_fim, 0, 10); ?>" required>
          </div>
        </div>

        
      </div>

      <hr>

      <label>
        <h5><?php echo ++$n; ?>. Equipe da prosposta</h5>
      </label>
      <?php
      include './includes/equipeProposta.php';
  ?>

      <hr>

      <div class="form-group">
        <h5><label><?php echo ++$n; ?>. Resumo do Projeto e Palavras-chaves</label></h5>

        <label for="resumo">Resumo do Projeto</label>
        <div id="sumnot_resumo"><?php echo $obProjeto->resumo; ?></div>
        <textarea id="resumo" name="resumo" rows="10" hidden></textarea>
        <label for="palavras">Palavras-chave
          <div class="row">
            <div class="col-4">
              <input type="text" class="form-control" name="palav1" id="palav1" value="<?php echo $palav1; ?>">
            </div>
            <div class="col-4">
              <input type="text" class="form-control" name="palav2" id="palav2" value="<?php echo $palav2; ?>">
            </div>
            <div class="col-4">
              <input type="text" class="form-control" name="palav3" id="palav3" value="<?php echo $palav3; ?>">
            </div>
          </div>
        </label>

      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="justificativa">
              <h5><?php echo ++$n; ?>. Problema e justificativa da proposta</h5>
            </label>
            <div id="sumnot_justificativa"><?php echo $obProjeto->justificativa; ?></div>
            <textarea id="justificativa" name="justificativa" rows="10" hidden></textarea>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Objetivo Geral e Objetivos Específicos</h5>
            </label>
            <div id="sumnot_objetivos"><?php echo $obProjeto->objetivos; ?></div>
            <textarea id="objetivos" name="objetivos" rows="10" hidden></textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="metodologia">
              <h5><?php echo ++$n; ?>. Metodologia para Execução da Proposta</h5>
            </label>
            <div id="sumnot_metodologia"><?php echo $obProjeto->metodologia; ?></div>
            <textarea id="metodologia" name="metodologia" rows="10" hidden></textarea>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="contribuicao">
              <h5><?php echo ++$n; ?>. Contribuição Científica, Tecnológica e de Inovação</h5>
            </label>
            <div id="sumnot_contribuicao"><?php echo $obProjeto->contribuicao; ?></div>
            <textarea id="contribuicao" name="contribuicao" rows="10" hidden></textarea>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="cronograma">
              <h5><?php echo ++$n; ?>. Cronograma da proposta</h5>
            </label>
            <div id="sumnot_cronograma"><?php echo $obProjeto->cronograma; ?></div>
            <textarea id="cronograma" name="cronograma" rows="10" hidden></textarea>
          </div>
        </div>
      </div>


      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="obs">
              <h5><?php echo ++$n; ?>. Observação</h5>
            </label>
            <div id="sumnot_obs"><?php echo $obProjeto->obs; ?></div>
            <textarea id="obs" name="obs" rows="10" hidden></textarea>
          </div>
        </div>
      </div>


      <hr>
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="referencia">
              <h5><?php echo ++$n; ?>. Referências</h5>
            </label>
            <div id="sumnot_referencia" style="text-align: justify"><?php echo $obProjeto->referencia; ?></div>
            <textarea id="referencia" name="referencia" rows="10" hidden></textarea>
          </div>
        </div>
      </div>


      <hr>
      <div class="form-group">
        <h5 id="attc"><?php echo ++$n; ?>. Anexos</h5>
        <ul id="anexos"></ul>
        <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
        <?php echo $anex; ?>
      </div>
      <hr>
      <div class="row" hidden>

        <div class="col-3">
          <div class="form-group">
            <label>Data</label>
            <input type="date" name="data" class="form-control" id="dateAssing" value="<?php echo substr($obProjeto->data, 0, 10); ?>" requiredd>
          </div>
        </div>
      </div>


      <div class="form-group">
        <a href="javascript: submitSalvar()" class="btn btn-primary  btn-sm">✔️ Salvar, para submeter depois</a>
        <a href="javascript: submitSumbeter()" class="btn btn-success btn-sm" hidden>↗️ Submeter agora</a>
        <button type="button" class="btn btn-warning btn-sm" onclick="history.back()"> ↩️ Voltar</button>
      </div>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <p><br><br></p>
          </div>
        </div>
      </div>

      <input id="equipeJS" name="equipeJS" type="text" hidden>
      <input id="anexosJS" name="anexosJS" type="text" hidden>


  </form>

  <?php
include './includes/modalMembro.php';
  ?>
  <?php echo $scriptVars; ?>



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

 



</main>
<script src="equipe.js"></script>
<script src="forms.js"></script>