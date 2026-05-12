<section>
  <h3>Dados do projeto</h3>
  <p><hr></p>

  <h5>
    <p>
      <strong>Título:</strong> <?=$proj->titulo ?></p>
      <input type="hidden" name="tabela" value="avaliacoes">
    <p>
      <strong>Coordenador:</strong> <?=$proj->coord ?></p>
    <p>
      <strong>Ação extensionista:</strong> <?=$proj->tipo_extensao ?> | 
      <strong>TIDE:</strong> <?=$proj->tide ?>
    </p>
    <p>
      <strong>Início de vigência:</strong> <?=$proj->vigen_ini ?> | 
      <strong>Fim de vigência:</strong> <?=$proj->vigen_fim ?> |
      <strong>Carga semanal:</strong> <?=$proj->ch_semanal ?> |
      <strong>Carga total:</strong> <?=$proj->ch_total ?> 
    </p>
    <p>
      <strong>Área CNPQ</strong> <?=$proj->area_cnpq ?> |
      <strong>Área temática</strong> <?=$proj->area_tema2 ?>
      <strong>Área temática secundára</strong> <?=$proj->area_tema2 ?>
    </p>
    <p>
    <strong>Área de extensão</strong> <?=$proj->area_extensao ?>
    <strong>Linha de extensão</strong> <?=$proj->linha_ext ?>
    </p>
    <p><strong>Resumo</strong> <?=$proj->resumo ?></p>
    <p><strong>Descrição</strong> <?=$proj->descricao ?></p>
    <p><strong>Objetivos</strong> <?=$proj->objetivos ?></p>
    <p><strong>Metodologia</strong> <?=$proj->metodologia ?></p>
    <p><strong>Produtos/serviços esperados</strong> <?=$proj->prodserv_espe ?></p>
    <p><strong>Contribuição</strong> <?=$proj->contribuicao ?></p>
    <p><strong>Contra partida financeira</strong> <?=$proj->contrap_nofinac ?></p>
    <p>
      <strong>Número de certificados a serem gerados</strong> <?=$proj->n_cert_prev ?>
    </p>
    <p>
      <strong>Outras informações</strong> <?=$proj->outs_info ?>
    </p>
    <p>
      <!--<strong>Local</strong> <=$proj->local ?>  -->
      
      <strong>Data</strong> <?=$proj->data ?>
    </p>
  </h5>

  <hr><h5>Anexos do projeto</h5>
  <?=$anex?>
</section>