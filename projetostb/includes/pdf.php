<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Carregar o Composer

require '../../vendor/autoload.php';

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

  <title>Doc</title>
  <style type="text/css">
    @page {
      margin: 1cm 2cm;
    }

    body {
      font-family: sans-serif;
      margin: 4.5cm 0 1.5cm 0;
      text-align: justify;
    }

    #header,
    #footer {
      position: fixed;
      left: 0;
      right: 0;

      font-size: 0.9em;
    }

    #header {
      top: 0;
      height: 100px;
    }

    #footer {
      bottom: 0;
      border-top: 0.1pt solid #aaa;
    }

    #header table,
    #footer table {
      width: 100%;
      border-collapse: collapse;
      border: 1px;
      border-color: black;
    }

    #header td,
    #footer td {
      padding: 0;
      width: 50%;
    }

    .page-number {
      text-align: center;
    }

    .page-number:before {
      content: "Página " counter(page);
    }

    .page-number::after {
      content: " de " counter(page);
    }

    hr {
      page-break-after: always;
      border: 0;
    }

    h1,
    h2,
    h3,
    h4 {
      text-align: center;
    }

    p {
      text-align: left;
    }

  .td1 {
    border: 0;
    border-collapse: collapse;
    text-align: center;
  }

  .time, th, td {
    border: 0.5px solid gray;
    border-collapse: collapse;
    padding: 5px;
  }

  .time {
    width: 100%;
  }
  th {
    background-color: #eeeeee;
    font-weight: lighter;
  }

    
  </style>

</head>

<body>

  <div id="header">
    <table>
      <tr>
        <td class="td1"><img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png"
            width="120px"></td>
      </tr>
    </table>
  </div>

  <div id="footer">
    <div class="page-number"></div>
  </div>

  <h3>ANEXO II</h3>
  <h4>FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMAS,
    PROJETOS OU PRESTAÇÃO DE SERVIÇO</h4>
  <h5>*O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão
    Tramitação: Coordenador → Divisão de Extensão e Cultura → Colegiado de Curso → Conselho de Centro de Área → Divisão
    de Extensão e Cultura.</h5>
  <p><strong>1. Título da Proposta:</strong> O GeoGebra no ensino, na aprendizagem e na pesquisa em
    Educação Matemática</p>
  <p><strong>2. Coordenador(a):</strong> Sérgio Carrazedo Dantas</p>
  <p><strong>3. Contato do Coordenador:</strong>
    Telefone: (43) 99102-6576 E-mail: sergio.dantas@unespar.edu.br</p>
  <p><strong>4. Colegiado de Curso:</strong> Colegiado de Matemática</p>
  <p><strong>5. Campus:</strong> Apucarana</p>
  <p><strong>6. Tipo de proposta: </strong></p>
  ( ) Programa<br>
  ( x ) Projeto<br>
  ( ) Prestação de Serviço<br>
  <p><strong>7. A proposta está vinculada a alguma disciplina do curso de Graduação ou PósGraduação (ACEC II).</strong>
  </p>
  ( ) Sim
  ( x ) Não
  8. Vinculação à Programa de Extensão e Cultura
  ( ) Vinculado ( x ) Não vinculado
  Título do Programa de vinculação: ________________________________________.
  9. Classificação do Projeto ou Programa.
  9.1. Áreas de Conhecimento CNPq
  a) Grande Área: Ciências Exatas e da Terra
  b) Área: Matemática
  c) Subárea: Educação Matemática
  9.2. Plano Nacional de Extensão Universitária
  a) Área de Extensão: Educação
  b) Linha de Extensão: Educação Profissional
  10. Período de vigência:
  ( ) Inicial: 15 / abril / 2023 a 15 / março / 2025

  <p></p>

  <table class="time">
    <thead>
      <tr>
        <th>N</th>
        <th>Nome</th>
        <th>Instituição</th>
        <th>Formação</th>
        <th>Função na equipe</th>
        <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>nintendo</td>
        <td>game</td>
        <td>8 bits</td>
        <td>Teste</td>
        <td></td>
      </tr>
      <tr>
        <td>2</td>
        <td>mega</td>
        <td>sega</td>
        <td>16 bits</td>
        <td>Nice</td>
        <td></td>
      </tr>
      <tr>
        <td>3</td>
        <td>saturn</td>
        <td>sega</td>
        <td>32 bits</td>
        <td></td>
        <td></td>
      </tr>
      <tr>

        <td>4</td>
        <td>ps4</td>
        <td>sony</td>
        <td>x86</td>
        <td></td>
        <td>+1 55</td>
      </tr>
      <tr>
        <td>5</td>
        <td>atari</td>
        <td>atari</td>
        <td></td>
        <td>First</td>
        <td></td>
      </tr>
    </tbody>
  </table>

  <p>
    <img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png" style="float: right; margin: 0.5em;" />
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed non
    risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec,
    ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula
    massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci
    nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit
    amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat
    in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero
    pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo
    in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue
    blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus
    et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed
    pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales
    hendrerit.
  </p>

  <hr />

  <h2>Section 2</h2>

  <p>
    <img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png" style="float: left; padding: 0.5em;"
      width="180" />
    Ut velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut
    orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius,
    ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus
    sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer
    id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae
    elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer
    adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et
    sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue
    eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non
    elementum posuere, metus purus iaculis lectus, et tristique ligula
    justo vitae magna. Morbi vel erat non mauris convallis vehicula. Nulla et
    sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue
    eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non
    elementum posuere, metus purus iaculis lectus, et tristique ligula
    justo vitae magna.
  </p>

  <hr />

  <h2>Section 3</h2>

 
    libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean
    suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla
    tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus,
    felis magna fermentum augue, et ultricies lacus lorem varius purus.
    Curabitur eu amet.</p>

  <p>Aliquam convallis sollicitudin purus. Praesent aliquam, enim at
    fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu
    lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod
    libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean
    suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla
    tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus,
    felis magna fermentum augue, e
    t ultricies lacus lorem varius purus.
    Curabitur eu amet.</p>

  <p>Aliquam convallis sollicitudin purus. Praesent aliquam, enim at
    fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu
    lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod
    libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean
    suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla
    tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus,
    felis magna fermentum augue, et ultricies lacus lorem varius purus.
    Curabitur eu amet.</p>

  <p>Aliquam convallis sollicitudin purus. Praesent aliquam, enim at
    fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu
    lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod
    libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean
    suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla
    tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus,
    felis magna fermentum augue, et ultricies lacus lorem varius purus.
    Curabitur eu amet.</p>

  <p>Aliquam convallis sollicitudin purus. Praesent aliquam, enim at
    fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu
    lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod
    libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean
    suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla
    tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus,
    felis magna fermentum augue, et ultricies lacus lorem varius purus.
    Curabitur eu amet. Bla</p>

</body>

</html>';



    
use Dompdf\Dompdf;
$dompdf = new Dompdf(['enable_remote' => true]);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("AE1.pdf");




