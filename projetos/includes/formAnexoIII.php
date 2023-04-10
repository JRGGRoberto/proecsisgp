<main>


  <!--//$anexoII  = [3, 4, 5]; // Programa / Projeto / Serviço -->


  <section>
    <a href="index.php">
      <button class="btn btn-success btn-sm float-right">Voltar</button>
    </a>
  </section>

  <h3 class="mt-3"><?= TITLE ?></h2>

    <form id="upload" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_prof" value="<?= $obProjeto->id_prof ?>">
      <input type="hidden" name="tabela" value="projetos">
      <hr>
      <div class="form-group">
        <label>
          <h5><?= $n = 1 ?>. Título da proposta</h5>
        </label>
        <input type="text" class="form-control" required name="titulo" value="<?= $obProjeto->titulo ?>">
      </div>

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
        <select name="vinculo" class="form-control col-1">
          <option value="s" <?= ($obProjeto->vinculo == 's') ? 'selected' : ' ' ?>>Sim</option>
          <option value="n" <?= ($obProjeto->vinculo == 'n') ? 'selected' : ' ' ?>>Não</option>
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
            <select name="vinc_prog_ec" id="vinc_prog_ec" class="form-control col-8" onchange="showTitProg();">
              <option value="s" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Sim</option>
              <option value="n" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-10" id="titProgDIV">
            <label>
              <h6>Título do Programa de vinculação</h6>
            </label>
            <input type="text" class="form-control" name="titulo_progvinc" id="titulo_progvinc" value="<?= $obProjeto->titulo ?>">
          </div>

          <script type="text/javascript">
            const titProgDIV = document.getElementById('titProgDIV');
            const Tex_Prog_vinc = document.getElementById('titulo_progvinc');
            const opcao = document.getElementById('vinc_prog_ec');

            function showTitProg() {

              if (opcao.value == 's') {
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
          <h5><?= ++$n ?>. Classificação do Projeto ou Programa</h5>
        </label>
        <label><?= $n ?>.1. Área de Conhecimento CNPQ (Ver classificaçõa do CNPQ)</label>

        <div class="row">

          <div class="col">
            <div class="form-group">
              <label for="area_cnpq">Grande Área</label>
              <select name="area_cnpq" class="form-control">
                <?= $selectAreaCNPQ ?>
              </select>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label for="area_tema1">Área</label>
              <select name="area_tema1" class="form-control">
                <?= $areaOptions ?>
              </select>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label for="area_tema2">Subária</label>
              <select name="area_tema2" class="form-control">
                <?= $areaOptions2 ?>
              </select>
            </div>
          </div>


        </div>

        <label><?= $n ?>.2. Plano Nacional de Extensão Universitária (ver <a href="https://proec.unespar.edu.br/menu-extensao/orientacoes" target="_blank">https://proec.unespar.edu.br/menu-extensao/orientacoes)</a> </label>
        <div class="row">

          <div class="col">
            <div class="form-group">
              <label for="area_extensao">Área de extensão</label>
              <select name="area_extensao" class="form-control">
                <?= $area_ext_Opt ?>
              </select>
            </div>
          </div>


          <div class="col">
            <div class="form-group">
              <label for="linh_ext">Linhas de extensão</label>
              <select name="linh_ext" class="form-control">
                <?= $area_ext_Opt ?>
              </select>
            </div>
          </div>
        </div>

        <hr>
        <label>
          <h5><?= ++$n ?>. Período de vigência</h5>
        </label>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" name="vigen_ini" class="form-control" value="<?= substr($obProjeto->vigen_ini, 0, 10) ?>" required>
            </div>
          </div>

          <div class="col-3">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" name="vigen_fim" class="form-control" value="<?= substr($obProjeto->vigen_fim, 0, 10) ?>" required>
            </div>
          </div>
 
          <div class="col-3">
            <div class="form-group">
              <label>Carga semanal*:</label>
              <input type="number" min=0 max=44 class="form-control" name="ch_semanal" value="<?= $obProjeto->ch_semanal ?>">
              
            </div>
          </div>

          <div class="col-3">
            <div class="form-group">
              <label for="tide">TIDE</label>
              <select name="tide" class="form-control">
                <option value="s" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Sim</option>
                <option value="n" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Não</option>
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
            <select name="financiamento" id="financiamento" class="form-control" onchange="showFinac();">
              <option value="s" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Sim</option>
              <option value="n" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-5" id="orgaoFinac">
            <label>
              <h6>Órgão de Financiamento</h6>
            </label>
            <input type="text" class="form-control" id="orgao_finacInput" name="orgao_finac" value="<?= $obProjeto->orgao_finac ?>">
          </div>
          <div class="col-5" id="valorFinac">
            <label>
              <h6>Valor do Financiamento</h6>
            </label>
            <input type="text" class="form-control" id="valor_finacInput" name="valor_finac" value="<?= $obProjeto->valor_finac ?>">
          </div>

          <script type="text/javascript">
            const divFinac1 = document.getElementById('orgaoFinac');
            const divFinac2 = document.getElementById('valorFinac');
            const opcaoF = document.getElementById('financiamento');

            function showFinac() {

              if (opcaoF.value == 's') {
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
            <select name="parcerias" id="parcerias" class="form-control" onchange="showParcas();">
              <option value="s" <?= ($obProjeto->parcerias == 's') ? 'selected' : ' ' ?>>Sim</option>
              <option value="n" <?= ($obProjeto->parcerias == 'n') ? 'selected' : ' ' ?>>Não</option>
            </select>
          </div>
          <div class="col-6" id="parcaEntidades">
            <label>
              <h6>Nome(s) da(s) Entidade(s)</h6>
            </label>
            <input type="text" class="form-control" id="par_entidades" name="par_entidades" value="<?= $obProjeto->par_entidades ?>">
          </div>
          <div class="col-5" id="AtribuEnti">
            <label>
              <h6>Atribuição(ões) da(s) Entidade(s)</h6>
            </label>
            <input type="text" class="form-control" id="par_atribu" name="par_atribu" value="<?= $obProjeto->par_atribu ?>">
          </div>

          <script type="text/javascript">
            const divParcas1 = document.getElementById('parcaEntidades');
            const divParcas2 = document.getElementById('AtribuEnti');
            const opcaoParcas = document.getElementById('parcerias');

            function showParcas() {

              if (opcaoParcas.value == 's') {
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
              <div class="form-group">
                <label for="resumo">Resumo do Projeto</label>
                <textarea class="form-control" name="resumo" rows="10" placeholder="Descrever o resumo da ação de extensão (no máximo 250 palavras), destacando sua relevância na perspectiva acadêmica e social, o público a que se destina e o resultado esperado. Este texto poderá ser publicado na homepage da PROEC, portanto, recomenda-se revisá-lo corretamente."><?= $obProjeto->resumo ?></textarea>
<br>
                <label for="palavras">Palavras-chave: (até três)</label>
                <input type="text" class="form-control" id="palavras" name="palavras" value="<?= $obProjeto->palavras ?>">
                <div class="form-group">
            </div>
          
            

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="justificativa">
                <h5><?= ++$n ?>. Problema e Justificativa</h5>
              </label>
              <textarea class="form-control" name="justificativa" rows="10" placeholder="(Identificar o problema e justificaro projeto). 20 linhas máximo"><?= $obProjeto->justificativa ?></textarea>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>
                <h5><?= ++$n ?>. Objetivo Geral e Objetivos Específicos</h5>
              </label>
              <textarea class="form-control" name="objetivos" rows="10" placeholder="(O Objetivo Geral é a ação macro que se quer alcançar. E os Objetivos Específicos são as ações fracionadas, para se alcançar o Objetivo Geral). 10 linhas máximo."><?= $obProjeto->objetivos ?></textarea>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="metodologia">
                <h5><?= ++$n ?>. Metodologia para Execução da Proposta</h5>
              </label>
              <textarea class="form-control" name="metodologia" rows="10" placeholder="(Explicar os procedimentos necessários para a execução do projeto destacando o método, ou seja, a explicação do delineamento do estudo, amostra, procedimentos para a coleta de dados, bem como, o plano para a análise de dados). 20 linhas máximo."><?= $obProjeto->metodologia ?></textarea>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="contribuicao">
                <h5><?= ++$n ?>. Contribuição Científica, Tecnológica e de Inovação</h5>
              </label>
              <textarea class="form-control" name="contribuicao" rows="10" placeholder="(Identificar de que forma os resultados esperados do projeto contribuirão no cenário científico, tecnológicoe cultural  ). 10 linhas máximo"><?= $obProjeto->contribuicao ?></textarea>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="cronograma">
                <h5><?= ++$n ?>. Cronorama da proposta</h5>
              </label>
              <textarea class="form-control" name="cronograma" rows="10" placeholder="(considerar o período de vigência do projeto)"><?= $obProjeto->cronograma ?></textarea>
            </div>
          </div>
        </div>


        <hr>
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="referencias">
                <h5><?= ++$n ?>. Referências</h5>
              </label>
              <textarea class="form-control" name="referencias" rows="10" ><?= $obProjeto->referencias ?></textarea>
            </div>
          </div>
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
        <!--
    <div class="form-group">
      <h4>Anexos</h4>
      <ul id="anexos"></ul>
      <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
      <?= $anex ?>
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
    
  <!-- The Modal -->
  <div class="modal fade" id="modalEquipe">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
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
              <label for="telefone">Telefone</label>          <input type="text" class="form-control" id="telefone">
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