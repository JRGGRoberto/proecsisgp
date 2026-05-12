<?php
// Função utilizada apenas para receber uma abreviação, verificar se ela existe na lista e mudar ela para o nome sem abreviação
// É necessário passar a abreviação para a função
// Ajudar na hora de dar manutenção em um nome

// Tabelas do banco que também tem abreviação:
// - campos_editaveis_projetos;


require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();

function mudaAbreviacao($abreviacao){
    if($abreviacao == 'vigen_ini'){
        return 'Início da vigência';
    }
    elseif($abreviacao == 'vigen_fim'){
        return 'Fim da vigência';
    }
    elseif($abreviacao == 'id_prof'){
        return 'Coordenador da proposta';
    }
    elseif($abreviacao == 'titulo'){
        return 'Título da proposta';
    }
    elseif($abreviacao == 'tide'){
        return 'TIDE';
    }
    elseif($abreviacao == 'r'){
        return 'Reprovado';
    }
    elseif($abreviacao == 'a'){
        return 'Aprovado';
    }
}