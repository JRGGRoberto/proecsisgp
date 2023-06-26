<?php

include '../includes/header.php';

use \App\Entity\Projeto;

$obProjeto = new Projeto();
$id = '34743057-c966-4a55-9db3-76b060d9b2dd';
$ver = 0;
$obProjeto = Projeto::getProjeto($id, $ver);



if (isset($_POST['resumo'])) {
  $obProjeto->resumo       =  $_POST['resumo'];
  $obProjeto->atualizar();
  echo '<p>INFORMAÇÃO SALVA</p>';
}

?>

<div class="container">

  <form name="formFormat" id="formFormat" method="POST" enctype="multipart/form-data">
    
    <hr>
    
    <div class="form-group">
      <label>
        <h5><?= $n = 1 ?>. Título da proposta</h5>
      </label>
      <input type="text" class="form-control" name="titulo" id="titulo" value="<?= $obProjeto->titulo ?>" required>
    </div>
    

    <hr>

    <div class="form-group">
      <label>
        <h5><?= ++$n ?>. Coordenador(a)</h5>
      </label>
      <input type="text" class="form-control" name="coordNome" readonly value="<?= $obProjeto->nome_prof ?>">
    </div>


    <div class="form-group">
      <label>
      <h5><?= ++$n ?>. Título: Texto 1</h5>
      </label>
      <div id="texto1"></div>
    </div>

    <textarea class="form-control" name="resumo" rows="10" id="resumo" hidden><?= $obProjeto->resumo ?></textarea>

    </form>

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
    var resumo = document.getElementById("resumo");
    resumo.value = $('#texto1').summernote('code');
    document.formFormat.submit();
    //  }
  }

  CarregarDados();
</script>


<?php


include '../includes/footer.php';
