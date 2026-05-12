<section>
  <hr>

<form  method="post" enctype="multipart/form-data">

    
    <div class="form-group">
      <h3></h3>
      <input type="hidden" name="origem" value="invite">  
      <input type="hidden" name="id_proj" value="<?=$proj->id_proj ?>">
      <input type="hidden" name="id_campus" value="<?=$bossM->id_campus ?>">

    <br>
      
    </div>
    <div class="form-group">
        <label><strong>Selecione um professor para realizar um parecer ou recuse o trabalho<strong></label>
          <select name="resultado" id="resultado"class="form-control" onchange="ativaBTN();">
            <option value="0">Selecione uma opção</option>
            <option value="-1">Rejeitar</option>
            <?=$optLista  ?>
          <!--  <option value="p">Pendente</option>  -->
          </select>
    </div>

    <script type="text/javascript">
      function ativaBTN() {
        var btn = document.getElementById('btnOk');
        var op = document.getElementById("resutado");
        if (op != 0 ){
          btn.disabled=false;    
        }
        
        
      }
    </script>

    <div class="form-group">
      <button id="btnOk" type="submit" class="btn btn-success" disabled>Enviar</button>

      <a href="../avaliar"><button class="btn btn-success">Voltar</button></a>
    </div>

  </form>
  <p>
    <p></p>
    <p>.</p>
    <p><hr></p>
  </p>

</section>
