<?php
// Função utilizada para armazenar os IDs de usuários importantes no Sistema
// Caso seja modificada é necessário enviar o código pois ela está no gitignore

require '../vendor/autoload.php';

function permissoesADM(){
    return [
        'b8fa555f-cedb-47cf-91cc-7581736aac88', //ROBERTO
        'bfd757a5-4f2d-4a10-87a8-a872ae69f1fd', //MATHEUS
        '2bebba9e-226a-11ef-b2c8-0266ad9885af', //ARTHUR AG
        '28577ac6-cc50-4ca3-82d5-2496f6bf0e2c',  //ARTHUR PF
    ];
}

function permissoesEnviarBolsistas(){
    return [
        '8154fff1-becd-11ee-801b-0266ad9885af', //Dantas
        // '2bebba9e-226a-11ef-b2c8-0266ad9885af', //Arthur
        // 'b8fa555f-cedb-47cf-91cc-7581736aac88', //Roberto
    ];
}

function permissoesVerificarBolsistas(){
    return [
        '8154fff1-becd-11ee-801b-0266ad9885af', //Dantas
    ];
}

function permissoesAvaliadorPibis(){
    return [
        '91ad9f28-8819-42c9-b6a9-18f284ee7453', // [MARILDA DE LARA SANTOS----------] Agente Sol Ângela Deeke Curitiba I 11/06/2025
        '3d1be647-d7e3-4d00-a642-75ea14059b5b', // [IRENE OLIVEIRA------------------] Agente Sol Ângela Deeke Curitiba I 11/07/2025
        'c492dd7e-ac95-4d9f-b1c0-c7fc63340dd6', // [PAULO SERGIO SANTOS-------------] Estágiário - Sérgio Dantas 21/07/2025
        'a68f28dd-2b1b-49ec-8ef8-b6ed28ab3376', // [SUWELLY GONÇALVES SUASSUI PICH--] Solicitação Daniela Machado 31/07/2025
    ];
}
