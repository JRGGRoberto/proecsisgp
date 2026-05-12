
<section>
  <hr>
<h4>Avaliação</h4>
  <hr>

<form  id="upload"  method="post" enctype="multipart/form-data">

  <input type="hidden" name="origem" value="avaliar">
  <input type="hidden" name="id_proj" value="<?=$proj->id_proj ?>">
  <input type="hidden" name="id_avaliador" value="<?=$bossM->id_avaliador ?>">
  <div class="form-group">
    <h3></h3>
      
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
   <div class="row">
    <div class="col">
      <div class="form-group">
           <h5>Anexos</h5>
           <ul id="anexos"></ul>
           <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </div>
  
     <br>
 
 
     <div class="row">
       <div class="col">
         <div class="form-group">
           <label for="resu_ata"><strong>Despacho</strong></label>
           <textarea class="form-control" name="resu_ata" rows="10" 
           placeholder=""></textarea>
         </div>
       </div>
     </div>
 
       
     </div>
     <div class="form-group">
         <label><strong>Avaliação<strong></label>
           <select name="resultado" id="resultado"class="form-control" onchange="ativaBTN();">
             <option value="0">Selecione uma opção</option>
             <option value="a">Aprovado</option>
             <option value="r">Rejeitar</option>
        
           </select>
     </div>
   
  <button id="btnOk" type="submit" class="btn btn-success" disabled>Enviar</button>
      <a href="../avaliar"><button class="btn btn-success">Voltar</button></a>
    </div>
  </form>
  <p>
    <p></p>
    <p>&nbsp</p>
    
  </p>

</section>
