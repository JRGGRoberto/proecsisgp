<?php
$tituloHeader = '';
switch($tf) {
    case 'f':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA';
        break;
    case 'p':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de PRORROGAÇÃO DE PRAZO';
        break;
    case 'r':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de RENOVAÇÃO';
        break;
    default:
        $tituloHeader = 'não definido';
        break;
}

?>
<main>
  
  <section>
    <a href="./index.php?id=<?php echo $obProjeto->id; ?>">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>
  <hr>
  <h4 style="text-align: center">ANEXO V</h4>
  <h3 class="mt-3" style="text-align: center"><?=$tituloHeader?></h3>

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

  
  $periodo_ini1 = substr($obProjeto->vigen_ini, 0, 10);

  $periodo_fim1 = substr($obProjeto->vigen_fim, 0, 10);


  if($tf == 'r'){
    $periodo_ini2 = null;
    if(!is_null($relatorio->periodo_renov_ini)){
      $periodo_ini2 = substr($relatorio->periodo_renov_ini, 0, 10);
    } 
    $periodo_fim2 = null;
    if(!is_null($relatorio->periodo_renov_fim)){
      $periodo_fim2 = substr($relatorio->periodo_renov_fim, 0, 10);
    }
  }

  if($tf == 'p'){
    $periodo_fim3 = null;
    if(!is_null($relatorio->periodo_prorroga_fim)){
      $periodo_fim3 = substr($relatorio->periodo_prorroga_fim, 0, 10);
    }
  }

  ?>
    <div class="form-group">
      <label>
        <h5><?php echo ++$n; ?>. Período que se refere o Relatório</h5>
      </label>
      <br>

      <strong>Inicial - Original</strong>
      <div class="row">
        <div class="col-3">
          <div class="form-group">
            <label>Início</label>
            <input type="date" class="form-control" value="<?= $periodo_ini1; ?>" readonly>
          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Fim</label>
            <input type="date" class="form-control" value="<?= $periodo_fim1; ?>" readonly>
          </div>
        </div>
      </div>
      <br>

      <?php 
      if($tf == 'r'){ ?>
         <strong>Renovação</strong>
         <div class="row">
           <div class="col-3">
             <div class="form-group">
               <label>Início para renovação</label>
               <input type="date" name="periodo_renov_ini" id="periodo_renov_ini" class="form-control" value="<?= $ini;?>" required <?=$editar;?> >
             </div>
           </div>
   
           <div class="col-3">
             <div class="form-group">
               <label>Fim, para renovação</label>
               <input type="date" name="periodo_renov_fim" id="periodo_renov_fim" class="form-control" value="<?= $fim; ?>" required <?=$editar?> >
             </div>
           </div>
         </div>
      <br>
<?php } 

if($tf == 'p'){
?>
      <strong>Prorrogação</strong>
      
        <div class="col-3">
          <div class="form-group">
            <label>Até</label>
            <input type="date" name="periodo_prorroga_fim" id="periodo_prorroga_fim" class="form-control" value="<?= $fim; ?>" required <?=$editar?>  <?=$editar?> >
          </div>
        </div>
        A prorrogação deve ter tempo máximo de 25% do período inicial e final informado no projeto.
      </div>

      <?php } 

?>      
      <hr>
      <div class="form-group">
        <label>
          <h5><?php echo ++$n; ?>. Carga semanal*:</h5>
        </label>
        <input type="number" min=0 max=44 class="form-control col-2" name="ch_semanal" value="<?php echo $relatorio->ch_semanal; ?>" <?=$editar?>>
      </div>

      <hr>
      <div class="form-group">
        <label>
          <h5><?php echo ++$n; ?>. Dimensão do Projeto Executado</h5>
        </label>
        <table>
          <tr>
            <th>Público</th>
            <th>Quantidade</th>
          </tr>
          <tr>
            <th>Membros da comunidade externa</th>
            <td><input type="number" min=0 max=44 class="form-control" name="dim_mem_com_ex" value="<?= $relatorio->dim_mem_com_ex; ?>" <?=$editar?> ></td>
          </tr>
          <tr>
            <th>Discentes</th>
            <td><input type="number" min=0 max=44 class="form-control" name="dim_disc" value="<?= $relatorio->dim_disc; ?>" <?=$editar?> ></td>
          </tr>
          <tr>
            <th>Docentes</th>
            <td><input type="number" min=0 max=44 class="form-control" name="dim_doce" value="<?= $relatorio->dim_doce; ?>"  <?=$editar?> ></td>
          </tr>
          <tr>
            <th>Agentes universitários e Estagiários</th>
            <td><input type="number" min=0 max=44 class="form-control" name="dim_agent_estag" value="<?= $relatorio->dim_agent_estag; ?>"  <?=$editar?> ></td>
          </tr>
        </table>
      </div>

      <hr>
      

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Certificação</h5>
            </label>
            <div>Se deseja solicitar certificados, anexe uma planilha com os seguintes dados:
              <ul>
                <li>Nome do participante</li>
                <li>CPF</li>
                <li>Tipo de participação</li>
                <li>Carga horária total</li>
                <li>Frequência</li>
                <li>Aproveitamento</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="atividades">
              <h5><?= ++$n; ?>. Atividades executadas</h5>
            </label>
            <div id="sumnot_atividades"><?php echo $relatorio->atividades; ?></div>
            <textarea id="atividades" name="atividades" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>

      <hr>
<?php if($tf == 'p'){ ?>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Atividades a serem desenvolvidas no próximo período – quando da solicitação de prorrogação do prazo</h5>
            </label>
            <div id="sumnot_atvd_prox_per"><?php echo $relatorio->atvd_prox_per; ?></div>
            <textarea id="atvd_prox_per" name="atvd_prox_per" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>
      <hr>

<?php } ?>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Relatório técnico-científico do Projeto Executado. </h5>
            </label>
            <div id="sumnot_rel_tec_cien_executado"><?php echo $relatorio->rel_tec_cien_executado; ?></div>
            <textarea id="rel_tec_cien_executado" name="rel_tec_cien_executado" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Divulgação científico-acadêmica e técnico-extensionistas </h5>
            </label>
            <div id="sumnot_divulgacao"><?php echo $relatorio->divulgacao; ?></div>
            <textarea id="divulgacao" name="divulgacao" rows="10" hidden ></textarea>
          </div>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Relatório Financeiro</h5>
            </label>
            <div>Caso haja recursos envolvidos na ação, elaborar o Relatório Financeiro, utilize um modelo fornecido pela Pró-Reitoria de Administração e Finanças
            </div>
            <a href="https://praf.unespar.edu.br/downloads" target="_blank">Modelos PRAF</a>. Depois de preenchido, anexe o arquivo no seção Anexos.
          </div>
        </div>
      </div>

<?php if($tf == 'r'){ ?>
  <div class="row">
        <div class="col">
          <div class="form-group">
            <label>
              <h5><?php echo ++$n; ?>. Relatório Financeiro</h5>
            </label>
            <div>Caso haja recursos envolvidos na ação, elaborar o Relatório Financeiro, utilize um modelo fornecido pela Pró-Reitoria de Administração e Finanças
            </div>
            <a href="https://praf.unespar.edu.br/downloads" target="_blank">Modelos PRAF</a>. Depois de preenchido, anexe o arquivo no seção Anexos.
          </div>
        </div>
      </div>

<?php } ?>
      <div class="form-group">
        <h5 id="attc"><?php echo ++$n; ?>. Anexos</h5>
        <ul id="anexos"></ul>
        <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
        <?php echo $anex; ?>
      </div>
      <hr>
      <?php 
      if($relatorio->tramitar == 0) {
      ?>
      <div class="form-group">
        <h5 id="">Pronto para tramitação</h5>
        <label for="tramitar">Ao marcar esta <input type="checkbox" id="tramitar" name="tramitar" value="1"> opção, depois de salvo, este relatório ficará visível para aprovação e perderá o modo de edição.</label>
           
      </div>
      <hr>
      <?php } else {
        echo '<div class="form-group">
        <h5 id="">Em processo de aceite da Divisão de Extensão e Cultura do Campus</h5>
        <label for="avaliar"></label>
           
      </div>
      <hr>';

      }
      ?>

      <div class="row" >

        <div class="col-3">
          <div class="form-group">
            <label>Data</label>
            <input type="date" name="data" class="form-control" id="dateAssing" value="<?php echo substr($relatorio->created_at, 0, 10); ?>" required <?=$editar?>>
          </div>
        </div>
      </div>

      <div class="form-group">
      <?php
      if($editar == ''){
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
      <input type="hidden" name="tabela" value="relatorios">
      <input id="anexosJS" name="anexosJS" type="text" hidden>


  </form>

</main>
<script src="forms.js"></script>