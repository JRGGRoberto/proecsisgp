<hr>
Srº(ª) Prof.º(ª) <?= $obProjeto->nome_prof?><br>
Identificamos que por um erro, o projeto o qual é coordenador(ª), <?= $obProjeto->titulo?>,não foi registrado as seguintes informações de que área de extensão ele pertence e quanto a linha de extensão.
Pedimos desculpas pelo o corrido. 
Solicitamos que por meio deste formulário as informações possam ser completadas.

<label> Plano Nacional de Extensão Universitária (ver <a href="https://proec.unespar.edu.br/menu-extensao/orientacoes" target="_blank">https://proec.unespar.edu.br/menu-extensao/orientacoes)</a> </label>
<div class="row">

  <div class="col">
    <div class="form-group">
      <label for="area_extensao">Área de extensão</label>
      <select name="area_extensao" id="area_extensao" class="form-control">
        <?php echo $area_ext_Opt; ?>
      </select>
    </div>
  </div>


  <div class="col">
    <div class="form-group">
      <label for="linh_ext">Linhas de extensão</label>
      <select name="linh_ext" id="linh_ext"  class="form-control">
        <?php echo $areaOptions; ?>
      </select>
    </div>
  </div>
</div>

<hr>