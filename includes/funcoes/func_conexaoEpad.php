<?php

require '../vendor/autoload.php';

function conexaoEpad($id_user, $id_prof, $id_vinculo, $v){
    $insert = false;

    if($_SERVER['HTTP_HOST'] == 'sistemaproec.unespar.edu.br'){ // Para produção 
        $baseUrl = 'https://'.$_SERVER['HTTP_HOST']; 
    } else { // Para Localhost 
        $baseUrl = 'http://host.docker.internal'; 
    }

    if (isset($id_vinculo)){
        // Conexão com o EPAD para poder gerar o PDF de PAD ao excluir o professor
        $url = $baseUrl . "/epad/padstopdf/indexHtml.php?id={$id_vinculo}";
        $ch = curl_init($url);
        if ($baseUrl === 'http://host.docker.internal') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Host: sis7.localhost'
            ]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
            return false;
        }
        curl_close($ch);
        if ($httpCode != 200) {
            throw new Exception("Erro ao gerar PDF.");
            return false;
        }
        $dados = json_decode($resposta, true);

        require_once '../pessoas/func_remocaoVinculoPf.php';
        if ($dados['status'] == 'ok' && remocaoVinculoPf($id_user, $id_prof, $id_vinculo, $v)){
            $insert = true;
        } 
    }

    return $insert;
}