<?php

include '../includes/header.php';

use \App\Entity\Projeto;
$obProjeto = new Projeto();
$id = '34743057-c966-4a55-9db3-76b060d9b2dd';
$ver = 0;
$obProjeto = Projeto::getProjeto($id, $ver);

?>

<div class="container">

  <label>
    <h5><?= ++$n ?>. Parcerias</h5>
  </label>
  <div class="row">
    <div class="col-1">
      <label>
        <h6>Parcerias?</h6>
      </label>
      <select name="parceria" id="parceria" class="form-control" >
        <option value="S">Sim</option>
        <option value="N">Não</option>
      </select>
    </div>
    <div class="col-6" id="parcaEntidades">
      <label>
        <h6>Nome(s) da(s) Entidade(s)</h6>
      </label>
      <input type="text" class="form-control" id="par_entidades" name="parcanomes">
    </div>
    <div class="col-5" id="AtribuEnti">
      <label>
        <h6>Atribuição(ões) da(s) Entidade(s)</h6>
      </label>
      <input type="text" class="form-control" id="par_atribu" name="parcaatribuic" >
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



  <div class="form-group">
    <label>
      <h5>Título: Texto 1</h5>
    </label>
    <div id="texto1"></div>
  </div>

  <!--
  <div class="form-group">
    <label>
      <h5>Título: Texto 2</h5>
    </label>
    <div id="texto2"></div>
  </div>

    -->

  
  <button type="button" class="btn btn-primary btn-sm" onclick="listar()">Exibir dados</button>


  <p id="demo">A CARREGAR</p>

  <textarea class="form-control" name="resumo" rows="10" id="resumo" hidden><?= $obProjeto->resumo ?></textarea>

</div>



<script>
  $('#texto1').summernote({
    placeholder: 'Hello Bootstrap 4 - texto 1',
    tabsize: 2,
    toolbar: [
      // [groupName, [list of button]]
      ['style', ['style']],
      ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontname', ['fontname']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'picture']]
    ]
  });



  $('#texto2').summernote({
    placeholder: 'Hello Bootstrap 4 - texto 2',
    tabsize: 2,
    toolbar: [
      // [groupName, [list of button]]
      ['style', ['style']],
      ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontname', ['fontname']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'picture']]
    ]
  });


  function CarregarDados() {
    var resumo = document.getElementById("resumo").value;
    $('#texto1').summernote('pasteHTML', resumo);
  }


  function toSalve() {
   /* if ($('#texto1').summernote('isEmpty')) {
      alert('editor content is empty');
    } else {
*/
      var resumo = document.getElementById("resumo")
      resumo.value = $('#texto1').summernote('code');
  //  }
  }

  CarregarDados();
</script>


<?php


include '../includes/footer.php';
