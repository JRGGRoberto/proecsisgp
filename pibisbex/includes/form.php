<hr>
<h4>Avaliação do projeto [<?php echo $proj->programa; ?>]: <?php echo $proj->nome; ?>

<a href="."                                               class="btn btn-warning btn-sm float-right" > ↩️ Voltar</button>  <a href="./docs/all/<?php echo $proj->link; ?>" target="_blank" class="btn btn-success btn-sm float-right">📃</a>

</h4>


<form method="post">
    <table class="table table-striped">
        <tr>
            <thead>
                <th colspan="2"><h5>NATUREZA EXTENSIONISTA DA PROPOSTA (RELAÇÃO COM A SOCIEDADE/IMPACTO E TRANSFORMAÇÃO SOCIAL)</h5></th>
            </thead>
        </tr>
        <tr>
            <td>1</td>
            <td>O Projeto ou Programa de Extensão tem abrangência e atende às diretrizes da extensão propostas pelo FORPROEXT? (Pontuação máxima: 50)
                <ol style="list-style-type:lower-alpha">
                    <li>Interação dialógica 
                        <br>O projeto apresenta metodologias que estimulam a participação e democratização do conhecimento, com a contribuição de atores não-universitários em sua produção e difusão?
                        <sub>(Sim: 10 pontos / Não: 0 pontos)</sub>
                    </li>
                    
                    <li>Interdisciplinaridade
                        <br>O projeto apresenta proposta de interação de modelos, conceitos e metodologias de diferentes áreas do conhecimento e/ou constrói alianças intersetoriais, interorganizacionais e interprofissionais?
                        <sub>(Sim: 10 pontos / Não: 0 pontos)</sub>
                    </li>
                    <li>Relação com ensino e pesquisa
                        <br>O projeto apresenta propostas de articulação com a produção de conhecimento (científico e cultural) e com o currículo do curso, e/ou estratégias para apreensão de saberes e práticas ainda não sistematizados?
                        <sub>(Sim: 10 pontos / Não: 0 pontos)</sub>
                    </li>
                    <li>Impacto na formação do estudante
                        <br>O projeto cria oportunidades de aprendizado para além do currículo e/ou oferece condições para os estudantes desenvolverem um protagonismo na sua formação técnica e cidadã?
                        <sub>(Sim: 10 pontos / Não: 0 pontos)</sub>
                    </li>
                    <li>Transformação social
                        <br>O projeto se propõe a uma atuação transformadora, voltada para os interesses e necessidades das comunidades envolvidas e propiciadora do desenvolvimento social e regional?
                        <sub>(Sim: 10 pontos / Não: 0 pontos)</sub>
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn1" name="qn1" min="0" max="50" step="10" value="<?php echo $pontuacao->qn1; ?>" onchange="atualizarValor(this)"> <label for="qn1"><?php echo $pontuacao->qn1; ?></label>
                </div>
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>O Projeto ou Programa de Extensão, com relação às ações principais:
                <ol style="list-style-type:lower-alpha">
                    <li>São realizadas na comunidade externa à Unespar (escolas, associações, etc..):     40</li>
                    <li>São realizadas nos espaços da Unespar com foco na comunidade externa.            10</li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn2" name="qn2" min="10" max="40" step="30" value="<?php echo $pontuacao->qn2; ?>" onchange="atualizarValor(this)"> <label for="qn2"><?php echo $pontuacao->qn2; ?></label>
                </div>
            
        </tr>
        <tr>
            <td>3</td>
            <td>A proposta caracteriza relações entre a Universidade e setores sociais marcadas pelo diálogo e troca de saberes?
                <ol style="list-style-type:lower-alpha">
                    <li>Com mais de dois setores: 15</li>
                    <li>Com dois setores: 10</li>
                    <li>Com um setor: 05</li>
                    <li>Não identifica setor: 0</li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn3" name="qn3" min="0" max="15" step="5" value="<?php echo $pontuacao->qn3; ?>" onchange="atualizarValor(this)"> <label for="qn3"><?php echo $pontuacao->qn3; ?></label>
                </div>
            </td>
        </tr>

        <tr>
            <thead>
                <th colspan="2"><h4>IMPACTO NA FORMAÇÃO DO ESTUDANTE</h4></th>
            </thead>
        </tr>
        <tr>
            <td>4</td>
            <td>O Projeto ou Programa de Extensão conta com:
                <ol style="list-style-type:lower-alpha">
                    <li>Estudantes de Graduação  (10 x nº  de estudantes)</li>
                    <li>Estudantes de Pós-Graduação  (05 x nº  de estudantes)</li>
                    <li>Estudantes Egressos ou participantes da comunidade externa  (05 x nº de participantes)</li>
                </ol>
                Obs. Para este item a pontuação é acumulativa para número de alunos e entre os itens a, b e c, somando no máximo 40 pontos. Os nomes deverão constar no anexo I da proposta.
                <hr>
                <div class="float-right">
                    <input type="range" id="qn4" name="qn4" min="0" max="40"  step="5" value="<?php echo $pontuacao->qn4; ?>" onchange="atualizarValor(this)"> <label for="qn4"><?php echo $pontuacao->qn4; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td>O Projeto ou Programa de Extensão conta com professores, além do(a) coordenador(a),  que atuam na condição de Orientador?
                <ol style="list-style-type:lower-alpha">
                    <li>De 01 a 03  (10 pontos)</li>
                    <li>Mais de 03   (15 pontos)</li>
                </ol>
                Obs.Os nomes deverão constar no anexo I da proposta.
                <hr>
                <div class="float-right">
                    <input type="range" id="qn5" name="qn5" min="0" step="5" max="15" value="<?php echo $pontuacao->qn5; ?>" onchange="atualizarValor(this)"> <label for="qn5"><?php echo $pontuacao->qn5; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <thead>
                <th colspan="2"><h4>ARTICULAÇÃO DA PROPOSTA COM O PLANO DE DESENVOLVIMENTO INSTITUCIONAL (PDI) DA UNESPAR</h4></th>
            </thead>
        </tr>

        <tr>
            <td>6</td>
            <td>O Projeto ou Programa contempla ações de:
                <ol style="list-style-type:lower-alpha">
                    <li>Inclusão Social     (5 pontos)</li>
                    <li>Desenvolvimento Econômico e Social (5 pontos)</li>
                    <li>Defesa e preservação do meio ambiente (5 pontos)</li>
                    <li>Defesa da memória e do patrimônio cultural e incentivo à produção artística (5 pontos)</li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn6" name="qn6" min="0" max="20"  step="5" value="<?php echo $pontuacao->qn6; ?>" onchange="atualizarValor(this)"> <label for="qn6"><?php echo $pontuacao->qn6; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <td>7</td>
            <td>O Projeto ou Programa realiza ações extensionistas com grupos sociais à margem das ações tradicionais da Universidade?
                <ol style="list-style-type:lower-alpha">
                    <li>Sim (10 pontos)</li>
                    <li>Não (0 pontos)</li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn7" name="qn7" min="0" max="10" step="10" value="<?php echo $pontuacao->qn7; ?>" onchange="atualizarValor(this)" > <label for="qn7"><?php echo $pontuacao->qn7; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <label for="justificativa">Justificativa</label>
                <textarea name="justificativa" id="justificativa" maxlength="1500" name="vincobs" id="vincobs" cols="30" class="form-control" rows="8"><?php echo $pontuacao->justificativa; ?></textarea></td>
        </tr>

    </table>
      <button type="submit" class="btn btn-success">Salvar</button>
    </form>
    

<script>
    function soma() {
      const qn1 = parseInt(document.getElementById('qn1').value);
      const qn2 = parseInt(document.getElementById('qn2').value);
      const qn3 = parseInt(document.getElementById('qn3').value);
      const qn4 = parseInt(document.getElementById('qn4').value);
      const qn5 = parseInt(document.getElementById('qn5').value);
      const qn6 = parseInt(document.getElementById('qn6').value);
      const qn7 = parseInt(document.getElementById('qn7').value);

      const total = qn1 + qn2 + qn3 + qn4 + qn5 + qn6 + qn7;
      
    }
    
    function atualizarValor(input) {
      const label = document.querySelector(`label[for="${input.id}"]`);
      
      if (label) {
        label.innerHTML = input.value;
      }
    //  soma();
    }
    

   
  </script>



