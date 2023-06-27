<main>
 
  <!--//$anexoIII  = [1, 2]; // Programa / Projeto / Serviço -->

  <section>
    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>

  <hr>
  <h4  style="text-align: center">ANEXO III</h4>
  <h3 class="mt-3" style="text-align: center"><?= TITLE ?></h3>
  
    <form name="formAnexo" id="formAnexo"  method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id_prof" value="<?= $obProjeto->id_prof ?>">
      <input type="hidden" name="tabela" value="projetos">
      <hr>
      <div class="form-group">
        <label>
          <h5><?= $n = 1 ?>. Título da proposta</h5>
        </label>
        <input type="text" class="form-control" name="titulo" id="titulo" value="<?= $obProjeto->titulo ?>" required>
      </div>
      <input type="hidden" name="tabela" value="projetos">

      <hr>

      <div class="form-group">
        <label>
          <h5><?= ++$n ?>. Coordenador(a)</h5>
        </label>
        <input type="text" class="form-control" name="coordNome" readonly value="<?= $obProjeto->nome_prof ?>">
      </div>

      <hr>

      <label>
        <h5><?= ++$n ?>. Contato do Coordenador</h5>
      </label>
      <div class="row">
        <div class="form-group col">
          <label>
            <h6><?= $n ?>.1. Telefone</h6>
          </label>
          <input type="text" class="form-control" name="tel" readonly value="<?= $dadosProf->telefone ?>">
        </div>

        <div class="form-group col">
          <label>
            <h6><?= $n ?>.2. Email</h6>
          </label>
          <input type="text" class="form-control" name="email" readonly value="<?= $dadosProf->email ?>">
        </div>
      </div>

      <hr>

      <div class="form-group">
        <label>
          <h5><?= ++$n ?>. A proposta está vinculada a alguma disciplina do curso de Graduação ou Pós-Graduação (ACEC II)</h5>
        </label>
        <select name="acec" class="form-control col-1">
          <option value="S" <?= ($obProjeto->acec == 'S') ? 'selected' : ' ' ?>>Sim</option>
          <option value="N" <?= ($obProjeto->acec == 'N') ? 'selected' : ' ' ?>>Não</option>
        </select>
      </div>

      <hr>

      <div class="form-group">
        <label>
          <h5><?= ++$n ?>. Vinculação à Programa de Extensão e Cultura</h5>
        </label>
        <div class="row">
          <div class="col-2">
            <label>
              <h6>É vinculado?</h6>
            </label>
            <select name="vinculo" id="vinculo" class="form-control col-8" onchange="showTitProg();">
              <option value="S" <?= ($obProjeto->vinculo == 'S') ? 'selected' : ' ' ?>>Sim</option>
              <option value="N" <?= ($obProjeto->vinculo == 'N') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-10" id="titProgDIV">
            <label>
              <h6>Título do Programa de vinculação</h6>
            </label>
            <input type="text" class="form-control" name="tituloprogvinc" id="tituloprogvinc" value="<?= $obProjeto->tituloprogvinc ?>">
          </div>

          <script type="text/javascript">
            const titProgDIV = document.getElementById('titProgDIV');
            const Tex_Prog_vinc = document.getElementById('tituloprogvinc');
            const opcao = document.getElementById('vinculo');

            function showTitProg() {

              if (opcao.value == 'S') {
                titProgDIV.hidden = false;
              } else {
                Tex_Prog_vinc.value = '';
                titProgDIV.hidden = true;
              }
            }
          </script>
        </div>

        <hr>

        <label>
          <h5><?= ++$n ?>. Período de vigência</h5>
        </label>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" name="vigen_ini" id="vigen_ini" class="form-control" value="<?= substr($obProjeto->vigen_ini, 0, 10) ?>" required>
            </div>
          </div>
          
          <div class="col-3">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" name="vigen_fim" id="vigen_fim" class="form-control" value="<?= substr($obProjeto->vigen_fim, 0, 10) ?>" required>
            </div>
          </div>
 
          <div class="col-3">
            <div class="form-group">
              <label>Carga Horária total:</label>
              <input type="number" min=0 max=44 class="form-control" name="ch_total" value="<?= $obProjeto->ch_total ?>">
              
            </div>
          </div>

          <div class="col-3">
            <div class="form-group">
              <label for="tide">TIDE</label>
              <select name="tide" class="form-control">
                <option value="S" <?= ($obProjeto->tide == 'S') ? 'selected' : ' ' ?>>Sim</option>
                <option value="N" <?= ($obProjeto->tide == 'N') ? 'selected' : ' ' ?>>Não</option>
              </select>
            </div>
          </div>
          <span class="badge badge-light">* Indicar a CH a ser computada no PAD, cf. regulamento próprio de distribuição de carga horária da Unespar.</span>
        </div>

        <hr>

        <label>
          <h5><?= ++$n ?>. Dimensão</h5>
        </label>
       
        <div class="form-group">
          <label>Publico Alvo</label>
          <input type="text" name="public_alvo" class="form-control" value="<?= $obProjeto->public_alvo ?>">
        </div>
    
        <div class="form-group">
          <label for="municipios_abr">Abrangência (região e/ou municípios)</label>
          <input type="text" name="municipios_abr" class="form-control" value="<?= $obProjeto->municipios_abr ?>">
        </div>
       
        <hr>

        <label>
          <h5><?= ++$n ?>. Previsão de Financiamento</h5>
        </label>
        <div class="row">
          <div class="col-2">
            <label>
              <h6>Financiamento?</h6>
            </label>
            <select name="finac" id="finac" class="form-control" onchange="showFinac();">
              <option value="S" <?= ($obProjeto->finac == 'S') ? 'selected' : ' ' ?>>Sim</option>
              <option value="N" <?= ($obProjeto->finac == 'N') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-5" id="orgaoFinac">
            <label>
              <h6>Órgão de Financiamento</h6>
            </label>
            <input type="text" class="form-control" id="orgao_finacInput" name="finacorgao" value="<?= $obProjeto->finacorgao ?>">
          </div>
          <div class="col-5" id="valorFinac">
            <label>
              <h6>Valor do Financiamento</h6>
            </label>
            <input type="number" class="form-control" id="valor_finacInput" name="finacval" value="<?= $obProjeto->finacval?? 0 ?>" step=0.01>
          </div>

          <script type="text/javascript">
            const divFinac1 = document.getElementById('orgaoFinac');
            const divFinac2 = document.getElementById('valorFinac');
            const opcaoF = document.getElementById('finac');

            function showFinac() {

              if (opcaoF.value == 'S') {
                divFinac1.hidden = false;
                divFinac2.hidden = false;
              } else {
                document.getElementById('orgao_finacInput').value = '';
                document.getElementById('valor_finacInput').value = '';
                divFinac1.hidden = true;
                divFinac2.hidden = true;
              }
            }
          </script>
        </div>

        <hr>

        <label>
          <h5><?= ++$n ?>. Parcerias</h5>
        </label>
        <div class="row">
          <div class="col-1">
            <label><h6>Parcerias?</h6></label>
            <select name="parceria" id="parceria" class="form-control" onchange="showParcas();">
              <option value="S" <?= ($obProjeto->parceria == 'S') ? 'selected' : ' ' ?>>Sim</option>
              <option value="N" <?= ($obProjeto->parceria == 'N') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-6" id="parcaEntidades">
            <label>
              <h6>Nome(s) da(s) Entidade(s)</h6>
            </label>
            <input type="text" class="form-control" id="par_entidades" name="parcanomes" value="<?= $obProjeto->parcanomes ?>">
          </div>
          <div class="col-5" id="AtribuEnti">
            <label>
              <h6>Atribuição(ões) da(s) Entidade(s)</h6>
            </label>
            <input type="text" class="form-control" id="par_atribu" name="parcaatribuic" value="<?= $obProjeto->parcaatribuic ?>">
          </div>

          <script type="text/javascript">
            const divParcas1 = document.getElementById('parcaEntidades');
            const divParcas2 = document.getElementById('AtribuEnti');
            const opcaoParcas = document.getElementById('parceria');

            function showParcas() {

              if (opcaoParcas.value == 'S') {
                divParcas1.hidden = false;
                divParcas2.hidden = false;
              } else {
                document.getElementById('par_entidades').value = '';
                document.getElementById('par_atribu').value = '';
                divParcas1.hidden = true;
                divParcas2.hidden = true;
              }
            }
          </script>
        </div>

        <hr>

        <label>
          <h5><?= ++$n ?>. Equipe da prosposta</h5>
        </label>
        <div class="form-group table-responsive-sm">
          <table id="tabela-equipe" class="table table-bordered table-sm">
            <thead class="thead-light">
              <tr>
                <th>N</th>
                <th>Nome</th>
                <th>Instituição</th>
                <th>Formação</th>
                <th>Função na equipe</th>
                <th>Telefone</th>
                <th style="width:20px"><button type="button" class="btn btn-primary btn-sm" onclick="formAddEquipe()">Adicionar</button></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

        <hr>
       
        <div class="form-group">
          <label><h5><?= ++$n ?>. Resumo do Projeto e Palavras-chaves</h5></label>
          
        <label for="resumo">Resumo do Projeto</label>
        <div id="sumnot_resumo"><?= $obProjeto->resumo ?></div>
        <textarea id="resumo" name="resumo" rows="10" hidden ></textarea>
        <label for="palavras">Palavras-chave
          <div class="row"> 
            <div class="col-4">
                <input type="text" class="form-control" name="palav1" id="palav1" value="<?= $palav1 ?>">
            </div>
            <div class="col-4">
                <input type="text" class="form-control" name="palav2" id="palav2" value="<?= $palav2 ?>">
            </div>
            <div class="col-4">
                <input type="text" class="form-control" name="palav3" id="palav3" value="<?= $palav3 ?>">
            </div>
          </div>
            </label>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="justificativa">
                <h5><?= ++$n ?>. Justificativa da proposta</h5>
              </label>
              <div id="sumnot_justificativa"><?= $obProjeto->justificativa ?></div>
              <textarea id="justificativa" name="justificativa" rows="10" hidden ></textarea>
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>
                <h5><?= ++$n ?>. Objetivo Geral e Objetivos Específicos</h5>
              </label>
              <div id="sumnot_objetivos"><?= $obProjeto->objetivos ?></div>
              <textarea id="objetivos" name="objetivos" rows="10" hidden ></textarea>
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="metodologia">
                <h5><?= ++$n ?>. Metodologia para Execução da Proposta</h5>
              </label>
              <div id="sumnot_metodologia"><?= $obProjeto->metodologia ?></div>
              <textarea id="metodologia" name="metodologia" rows="10" hidden ></textarea>
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="contribuicao">
                <h5><?= ++$n ?>. Contribuição Científica, Tecnológica e de Inovação</h5>
              </label>
              <div id="sumnot_contribuicao"><?= $obProjeto->contribuicao ?></div>
              <textarea id="contribuicao" name="contribuicao" rows="10" hidden></textarea>
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="cronograma">
                <h5><?= ++$n ?>. Cronorama da proposta</h5>
              </label>
              <div id="sumnot_cronograma"><?= $obProjeto->cronograma ?></div>
              <textarea id="cronograma" name="cronograma" rows="10" hidden></textarea>
            </div>
          </div>
        </div>


        <hr>
      
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="referencia">
                <h5><?= ++$n ?>. Referências</h5>
              </label>
              <div id="sumnot_referencia"><?= $obProjeto->referencia ?></div>
              <textarea id="referencia" name="referencia" rows="10" hidden></textarea>
            </div>
          </div>
        </div>

        <hr>
        <div class="form-group">
          <h5 id="attc"><?= ++$n ?>. Anexos</h5>
          <ul id="anexos"></ul>
          <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
          <?= $anex ?>
        </div>

        <hr>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label>Data</label>
              <input type="date" name="data" class="form-control" id="dateAssing" value="<?= substr($obProjeto->data, 0, 10) ?>" requiredd>
            </div>
          </div>
        </div>

        <div class="form-group">
          <a href="javascript: submitSalvar()" class="btn btn-success btn-sm" >✔️ Salvar</a>
          <button type="button" class="btn btn-warning btn-sm" onclick="history.back()">↩️ Voltar</button>
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
    
  <!-- The Modal -->
  <div class="modal fade" id="modalEquipe">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: #3385ff; color: white">
          <h4 class="modal-title" id="titleMemb">Adicionar membros a equipe</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form class="form-group">
      
              <label for="nome">Nome</label>                  <input type="text" class="form-control" id="nome">
              <label for="instituicao">Instituição</label>    <input type="text" class="form-control" id="instituicao">
              <label for="formacao">Formação</label>          <input type="text" class="form-control" id="formacao">
              <label for="funcao">Função na equipe</label>    <input type="text" class="form-control" id="funcao">
              <label for="tel">Telefone</label>               <input type="text" class="form-control" id="tel">
              <BR><center>
              <button type="button" class="btn btn-secondary btn-sm" onclick="fecharModalEquipe()">Fechar</button>
              <button type="button" id="addMemb" class="btn btn-primary btn-sm" onclick="adicionarContato()">Adicionar</button>
              <button type="button" name="altMemb" class="btn btn-primary btn-sm" onclick="updatMembro(this)">Alterar</button></center>
              
        </form>
        </div>
        

        
      </div>
    </div>
  </div>
<!-- The Modal Fim-->
<?=$scriptVars?>

</main>
<script src="equipe.js"></script>
<script src="forms.js"></script>