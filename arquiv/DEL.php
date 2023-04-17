<?php


  $arr = [
    '03307a4f9d654af8a4ed705b30220fdd.png',
    '81931f8bd0b28779b728876341a69d0c.png',
    '12a7f64b09eb535ede7b767355e27c53.pdf',
    '828e533dc77636cc59ba00c490f9a0cd.txt',
    '133aa46598455f582361322a4ecea2af.png',
    'a109cc9cb6337cb1a5afa019c25289d8.png',
    '1da0877c8fc3e37e2b427ad8cdc00960.png',
    'b65daa79706232abcea70afe552270dd.png',
    '3decea8541e3d185b319bc56bd9929c9.png',
    'bcfe6090c35fef3a9ce9d748a369c075.pdf',
    '410a723ef1f5775ff9ac502c4d4b1ed3.png',
    'cf2bf69ea5f635fc66127217aa4b5328.png',
    '46fbba420324361f9dff0497349aab3b.png',
    'cf9b95a743a236bf03d77705f5f7fd5c.docx',
    '47ec56b4e33a16300c9d6818a606bbce.pdf',
    'd43b3c525c61c2292f3068fdc722bef6.png',
    '542037917c59e9d63085659abcc49f33.png',
    'e063a6b6f6b4d0c0fa3c0191f5c7a7ad.txt',
    '62aef09a33ee947c752282e7d5746556.png',
    'e66293eb3858b74d10b3f4f9c5892b0f.doc',
    '66a9faac28509af08303fabba8bef6d8.docx',
    'ea0704bb0a532dac7b50a913ef5351c5.png',
    '693ffd5918cb23186f497afc37744537.png',
    'eb26b30b2bbbc456a2a6fb9bc763db46.png',
    '7618dd1124ecdb11c5812e8ae34cfba5.png',
    'f2cea6aeb1bee30129da2b7ae350cbae.png',
    '7cce9424ce05f79ed537d337dea724af.pdf',
    'f7837ff5f3f16404c779313ff3548c02.png'];

    $arr =  ['2023.03.28-11.09.58.jpg',
            '2023.03.28-11.14.18jpeg',
            '2023.03.28-11.26.41docx',
            '2023.03.28-11.10.37.jpg',
            '2023.03.28-11.15.55.png',
            '2023.03.28-11.28.13docx',
            '2023.03.28-11.13.14.jpg',
            '2023.03.28-11.25.39docx',
            '2023.04.17-10.19.02t.js',
            '2023.03.28-11.13.22.jpg',
            '2023.03.28-11.26.24.png',
            '2023.04.17-10.19.36.png',
            '2023.03.28-11.13.34.png',
            '2023.03.28-11.26.30.png'];

  //$caminho = '../upload/uploads/';
    $caminho = '/home/sistemaproec/www/teste/imagens';
    $caminho = '/home/sistemaproec/www/sistema/upload/uploads';
    foreach ($arr as &$valor) {
        // Verificando se o arquivo realmente existe
      if(unlink($caminho . $valor)){
        echo 'Apagando: '.$valor .'<br>';
      } else {
        echo 'Erro... [ '.$valor.' ]<br>';
      }    
  }
