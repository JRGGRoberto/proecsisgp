<?php

include '../includes/header.php';

?>

<div class="container">
    <div class="form-group">
      <label>
        <h5>Título: Texto 1</h5>
      </label>
      <div id="texto1"></div>
    </div>

    <div class="form-group">
      <label>
        <h5>Título: Texto 2</h5>
      </label>
      <div id="texto2"></div>
    </div>

    <button type="button" class="btn btn-primary btn-sm" onclick="formAddEquipe()">Preencher dados</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="listar()">Exibir dados</button>
    

    <p id="demo">A CARREGAR</p>

  </div>
  <script>
    $('#texto1').summernote({
      placeholder: 'Hello Bootstrap 4 - texto 1',
      tabsize: 2,
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
    });



    $('#texto2').summernote({
      placeholder: 'Hello Bootstrap 4 - texto 2',
      tabsize: 2
    });


    function formAddEquipe() {
      $('#texto1').summernote('pasteHTML', '<h1>Hello, world</h1>I am here! <hr>bye!');
    }


    function listar(){
      if ($('#texto1').summernote('isEmpty')) {
        alert('editor content is empty');
      } else {
        alert($('#texto1').summernote('code'));
      }
    }
  </script>


<?php


include '../includes/footer.php'; 
