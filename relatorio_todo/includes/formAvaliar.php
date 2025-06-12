
<hr>
<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label>
            <h4>Avaliação do <?=  $tituloHeader ?></h4>
            <h5>Se o relatório estiver atendendo o especificado, clique em <strong>Aceite</strong> para dar prosseguimento para a publicação.</h5>
            <h5>Se não, informe as adequações e clique em <strong>Solicitar adequações</strong></h5>
            <h5>Proposta executada: <strong> <?= $obProjeto->titulo; ?> </strong></h5>
        </label>
    </div>
        
  <div class="form-group">
   <input type="hidden" name="id_relatorio" value="<?= $relatorio->id; ?>">
   <input type="hidden" name="tp_avaliador" value="<?= $tp_avaliador; ?>">
   <input type="hidden" name="id_instancia" value="<?= $id_instancia; ?>">
   <input type="hidden" name="etapa" value="<?= $relatorio->etapa; ?>">
   <input type="hidden" name="etapas" value="<?= $relatorio->etapas; ?>">
    <div class="form-group row">
      
        <div class="form-group col-md-6">
            <label for="avaliador">Aceite</label><br>
            <input type="radio" class="btn btn-success btn-sm" id="age2" name="resultado" value="a">
        </div>
        
        <div class="form-group col-md-6">
            <label for="avaliador">Solicitar adequações</label><br>
            <input type="radio" class="btn btn-success btn-sm" id="age3" name="resultado" value="r">
        </div>

    </div>
    

    <textarea id="ava_comentario" name="ava_comentario" rows="8" cols="100" hidden></textarea>
    <input type="hidden" name="tp_relatorio" value="<?= $tipo_rela; ?>" >

  
  </div>
      <input class="btn btn-success btn-sm" id="submit" type="submit" value="Efetivar" disabled>
    <a href="./index.php?">
      <button class="btn btn-warning btn-sm">Voltar</button>
    </a>
</form>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="resultado"]');
    const submitButton = document.getElementById('submit');


    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'r') {
                document.getElementById('ava_comentario').removeAttribute('hidden');
            } else {
                document.getElementById('ava_comentario').setAttribute('hidden', true);
                document.getElementById('ava_comentario').value = ''; // Clear the textarea if 'Aceite' is selected
            }
            submitButton.disabled = false; // Enable the submit button
        });
    });             
}     
 );
</script>