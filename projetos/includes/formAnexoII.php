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


      <div class="form-group">
        <label>
          <h5><?= ++$n ?>. Coordenador(a)</h5>
        </label>
        <input type="text" class="form-control" name="coordNome" readonly value="<?= $obProjeto->nome_prof ?>">
      </div>

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

      <div class="form-group">
        <label>
          <h5><?= ++$n ?>. A proposta está vinculada a alguma disciplina do curso de Graduação ou Pós-Graduação (ACEC II)</h5>
        </label>
        <select name="vinculo" class="form-control">
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
          <div class="col-3">
            <label>
              <h6>É vinculado?</h6>
            </label>
            <select name="vinc_prog_ec" id="vinc_prog_ec" class="form-control" onchange="showTitProg();">
              <option value="s" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Vinculado</option>
              <option value="n" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Não vinculado</option>
            </select>
          </div>
          <div class="col-9" id="titProgDIV">
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
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>Carga semanal*:</label>
              <input type="number" min=0 max=44 class="form-control" name="ch_semanal" value="<?= $obProjeto->ch_semanal ?>">
              *Indicar a CH a ser computada no PAD, cf. regulamento próprio de distribuição de carga horária da Unespar.
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label for="tide">TIDE</label>
              <select name="tide" class="form-control">
                <option value="s" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Sim</option>
                <option value="n" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Não</option>
              </select>
            </div>
          </div>
        </div>

        <hr>

        <label>
          <h5><?= ++$n ?>. Dimensão</h5>
        </label>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label>Publico Alvo</label>
              <input type="text" name="public_alvo" class="form-control" value="<?= $obProjeto->public_alvo ?>">
            </div>
          </div>

          <div class="col-3">
            <div class="form-group">
              <label for="municipios_abr">Abrangência (região e/ou municípios)</label>
              <input type="text" name="municipios_abr" class="form-control" value="<?= $obProjeto->municipios_abr ?>">
            </div>
          </div>
        </div>
        <hr>

        <label>
          <h5><?= ++$n ?>. Previsão de Financiamento</h5>
        </label>
        <div class="row">
          <div class="col-3">
            <label>
              <h6>Há/haverá financiamento?</h6>
            </label>
            <select name="financiamento" id="financiamento" class="form-control" onchange="showFinac();">
              <option value="s" <?= ($obProjeto->tide == 'n') ? 'selected' : ' ' ?>>Sem Financiamento</option>
              <option value="n" <?= ($obProjeto->tide == 's') ? 'selected' : ' ' ?>>Com Financiamento</option>
            </select>
          </div>
          <div class="col-9" id="orgaoFinac">
            <label>
              <h6>Órgão de Financiamento</h6>
            </label>
            <input type="text" class="form-control" id="orgao_finacInput" name="orgao_finac" value="<?= $obProjeto->orgao_finac ?>">
          </div>
          <div class="col-9" id="valorFinac">
            <label>
              <h6>Valor do Financiamento</h6>
            </label>
            <input type="text" class="form-control" id="valor_finacInput" name="valor_finac" value="<?= $obProjeto->valor_finac ?>">
          </div>

          <script type="text/javascript">
            const diva1 = document.getElementById('orgaoFinac');
            const diva2 = document.getElementById('valorFinac');
            const opcaoPar = document.getElementById('financiamento');

            function showFinac() {

              if (opcaoF.value == 's') {
                div1a.hidden = false;
                div2a.hidden = false;
              } else {
                document.getElementById('orgao_finacInput').value = '';
                document.getElementById('valor_finacInput').value = '';
                diva1.hidden = true;
                diva2.hidden = true;
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
            const divb1 = document.getElementById('parcaEntidades');
            const divb2 = document.getElementById('AtribuEnti');
            const opcaoF = document.getElementById('parcerias');

            function showParcas() {

              if (opcaoF.value == 's') {
                divb1.hidden = false;
                divb2.hidden = false;
              } else {
                document.getElementById('par_entidades').value = '';
                document.getElementById('par_atribu').value = '';
                divb1.hidden = true;
                divb2.hidden = true;
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
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Instituição</th>
                <th>Formação</th>
                <th>Função na equipe</th>
                <th>Telefone</th>
                <th><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Adicionar</button></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>


        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>
                <h5><?= ++$n ?>. Resumo do Projeto</h5>
              </label>
              <textarea class="form-control" name="resumo" rows="10" placeholder="Descrever o resumo da ação de extensão (no máximo 250 palavras), destacando sua relevância na perspectiva acadêmica e social, o público a que se destina e o resultado esperado. Este texto poderá ser publicado na homepage da PROEC, portanto, recomenda-se revisá-lo corretamente."><?= $obProjeto->resumo ?></textarea>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>
                <h5>Palavras-chave: (até três)</h5>
              </label>
              <input type="text" class="form-control" id="par_atribu" name="par_atribu" value="<?= $obProjeto->par_atribu ?>">
            </div>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>
                <h5><?= ++$n ?>. Problema e Justificativa</h5>
              </label>
              <textarea class="form-control" name="descricao" rows="10" placeholder="(Identificar o problema e justificaro projeto). 20 linhas máximo"><?= $obProjeto->descricao ?></textarea>
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
                <h5><?= ++$n ?>. Metodologia para Execução do Projeto</h5>
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
              <label for="contrap_nofinac">
                <h5><?= ++$n ?>. Contribuição científica, tecnológica e de Inovação</h5>
              </label>
              <textarea class="form-control" name="contrap_nofinac" rows="10" placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"><?= $obProjeto->contrap_nofinac ?></textarea>
            </div>
          </div>
        </div>


        <hr>
        <h4>Informações complementares</h4>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              <label>Número de certificados previstos</label>
              <input type="number" min=0 max=200 class="form-control" default="0" name="n_cert_prev" value="<?= $obProjeto->n_cert_prev ? $obProjeto->n_cert_prev : 0 ?>">
            </div>
          </div>
          <div class="col"><br><br>0 para que não tenha emissão de certificados.
          </div>
        </div>




        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="outs_info">Outras informações que julgar importantes</label>
              <textarea class="form-control" name="outs_info" rows="10" placeholder=""><?= $obProjeto->outs_info ?></textarea>
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
    <?php

    if (TITLE == 'Cadastrar projeto') {
      echo "
        <script>
            document.getElementById('dateAssing').valueAsDate = new Date();
        </script>    
          ";
    }
    ?>


  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
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
              <BR>
             <button type="button" class="btn btn-primary btn-sm" onclick="adicionarContato()">Adicionar</button>

        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secundary" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- The Modal Fim-->


<script>
          // Array para armazenar os equipe
          let equipe = [];

          // Função para adicionar um contato na tabela
          function adicionarContato() {
            // Obter os valores dos inputs
            let nome = document.getElementById("nome").value;
            let instituicao = document.getElementById("instituicao").value;
            let formacao = document.getElementById("formacao").value;
            let funcao = document.getElementById("funcao").value;
            let telefone = document.getElementById("telefone").value;

            if( nome.length > 0 ) {
              // Criar um novo objeto de contato
              let novoContato = {
                id: equipe.length + 1,
                nome: nome,
                instituicao: instituicao,
                formacao: formacao,
                funcao: funcao,
                telefone: telefone
              };
  
              // Adicionar o novo contato no array
              equipe.push(novoContato);
  
              // Adicionar uma nova linha na tabela
              let tabela = document.getElementById("tabela-equipe").getElementsByTagName("tbody")[0];
              let novaLinha = tabela.insertRow();
              let celId = novaLinha.insertCell(0);
              let celNome = novaLinha.insertCell(1);
              let celInstituicao = novaLinha.insertCell(2);
              let celFormacao = novaLinha.insertCell(3);
              let celFuncao = novaLinha.insertCell(4);
              let celTelefone = novaLinha.insertCell(5);
              let celDelete = novaLinha.insertCell(6);
              celId.innerHTML = novoContato.id;
              celNome.innerHTML = novoContato.nome;
              celInstituicao.innerHTML = novoContato.instituicao;
              celFormacao.innerHTML = novoContato.formacao;
              celFuncao.innerHTML = novoContato.funcao;
              celTelefone.innerHTML = novoContato.telefone;
              celDelete.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="excluirContato(' + novoContato.id + ')">⛔</button>';

              // Limpar os inputs
              document.getElementById("nome").value = "";
              document.getElementById("instituicao").value = "";
              document.getElementById("formacao").value = "";
              document.getElementById("funcao").value = "";
              document.getElementById("telefone").value = "";
            }
          }

          // Função para excluir um contato da tabela
          function excluirContato(id) {
            // Encontrar o índice do contato no array
            let index = equipe.findIndex(contato => contato.id === id);

            // Remover o contato do array
            equipe.splice(index, 1);

            // Remover a linha correspondente da tabela
            let tabela = document.getElementById("tabela-equipe").getElementsByTagName("tbody")[0];
            tabela.deleteRow(index);
          }
        </script>

</main>