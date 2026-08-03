<?php

require '../vendor/autoload.php';

use App\Entity\Agente;
use App\Entity\Professor;
use App\Entity\Solicita_Pessoas;
use App\Entity\UuiuD;
use App\Entity\Vinculo;
use App\Session\Login;
Login::requireLogin();

// Por enquanto está apenas a solicitação
// Quando os ADMs fizerem a solicitação ai não precisa ser avaliada (inserir direto)

function solicitacaoPessoas($post){
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

    if ($post['tp_solicitacao'] == 'cadastro'){
        $idPessoa = UuiuD::gera();
    }
    elseif ($post['tp_solicitacao'] == 'desativacao' || $post['tp_solicitacao'] == 'reativacao'){
        $idPessoa = $post['id_pessoa'];
    }

    $cadastro = new Solicita_Pessoas();
        $cadastro->id = UuiuD::gera();
        $cadastro->tp_solicitacao = $post['tp_solicitacao'];
        $cadastro->tp_cadastro = $post['tp_cadastro'];
        $cadastro->id_solicitador = $post['id_solicitador'];
        $cadastro->id_pessoa = $idPessoa;
        $cadastro->nome = $post['nome'];
        $cadastro->cpf = $post['cpf'];
        $cadastro->titulacao = $post['titulacao'];
        $cadastro->lattes = $post['lattes'];
        $cadastro->email = $post['email'];
        $cadastro->telefone = $post['telefone'];
        $cadastro->ca_id = $post['ca_id'];
        $cadastro->co_id = $post['co_id'];
        $cadastro->cat_func = $post['cat_func'];
        $cadastro->rt = $post['rt'];
        $cadastro->portaria = $post['portaria'];
        $cadastro->ano_letivo = $post['ano_letivo'];
        $cadastro->vinculo_remocao = $post['vinculo_remocao'];
        $cadastro->data_solicitacao = $data->format('Y-m-d H:i:s.v');
    
    if ($cadastro->insertRegistros()){
        $insert = true;
    } else {
        $insert = false;
    }

    return $insert;
}

// function analisarCadastro(){
//     $cadastro = new Solicita_Pessoas();

//     $cadastro->atualizar();

// }

function removeSolicitacao($idPessoa){
    $where = 'id_pessoa = "'.$idPessoa.'"';
    $desativacao = Solicita_Pessoas::getRegistros($where);
    
    if ($desativacao[0]->excluir()){
        $rm = true;
    } else {
        $rm = false;
    }

    return $rm;

}

function insercaoPessoasAdmin($post){
    // Dados gerais Pf/Ag
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $newId = UuiuD::gera();

    if ($post['tp_solicitacao'] == 'cadastroAdmin' ){
        // Inserção de Professor
        
        if ($post['tp_cadastro'] == 'pf' ){
            $cadastroProf = new Professor();
                // Cadastra o professor
                $cadastroProf->id = $newId; 
                $cadastroProf->nome = $post['nome'];
                $cadastroProf->cpf = $post['cpf'];
                $cadastroProf->telefone = $post['telefone'];
                $cadastroProf->lattes = $post['lattes'];
                $cadastroProf->titulacao = $post['titulacao'];
                $cadastroProf->email = $post['email'];
                $cadastroProf->id_colegiado = $post['co_id'];
                $cadastroProf->cat_func = $post['cat_func'];
                $cadastroProf->ativo = 1;
                $cadastroProf->senha = $post['senha'];
                $cadastroProf->user = $post['idResponsavel'];      
            
                // Cadastra o vínculo
            $cadastrarNewVinculo = new Vinculo();
                $cadastrarNewVinculo->ano = $post['ano_letivo'];
                $cadastrarNewVinculo->rt = $post['rt'];
                $cadastrarNewVinculo->tide = $post['tide'];
                $cadastrarNewVinculo->id_prof = $newId;
                $cadastrarNewVinculo->area_concurso = '';
                $cadastrarNewVinculo->dt_obtn_tit = null;
                $cadastrarNewVinculo->tempo_cc = ''; // Tempo concursado
                $cadastrarNewVinculo->tempo_esu = ''; // ver qq é isso
                $cadastrarNewVinculo->obs = ''; // Ver se tem que pegar
                $cadastrarNewVinculo->created_at = $data->format('Y-m-d H:i:s.v');
                $cadastrarNewVinculo->user = $post['idResponsavel'];
           
            if ($cadastroProf->cadastrar() && $cadastrarNewVinculo->cadastrar()){
                $insert = true;
            } else {
                $insert = false;
            }  
            
        }
        // Inserção de Agentes
        elseif ($post['tp_cadastro'] == 'ag' ){
            // Inserir Agentes
            $cadastroAg = new Agente();
                $cadastroAg->nome = $post['nome'];
                $cadastroAg->cpf = $post['cpf'];
                $cadastroAg->telefone = $post['telefone'];
                $cadastroAg->email = $post['email'];
                $cadastroAg->cat_func = $post['cat_func'];
                $cadastroAg->ativo = 1;
                $cadastroAg->lotacao = $post['ca_id'];
                $cadastroAg->senha = $post['senha'];
                $cadastroAg->created_at = $data->format('Y-m-d H:i:s.v');
                $cadastroAg->user = $post['idResponsavel'];
            
            if($cadastroAg->cadastrar() == true){
                $insert = true;
            } elseif($cadastroAg->cadastrar() == false){
                $insert = false;
            }  
       
        }
    }
    return $insert;
}

function reativacaoPessoasAdmin($post){
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

    // Cadastra o vínculo
    $cadastrarNewVinculo = new Vinculo();
        $cadastrarNewVinculo->ano = $post['ano'];
        $cadastrarNewVinculo->rt = $post['rt'];
        $cadastrarNewVinculo->tide = $post['tide'];
        $cadastrarNewVinculo->id_prof = $post['id_prof'];
        $cadastrarNewVinculo->area_concurso = '';
        $cadastrarNewVinculo->dt_obtn_tit = null;
        $cadastrarNewVinculo->tempo_cc = ''; 
        $cadastrarNewVinculo->tempo_esu = '';
        $cadastrarNewVinculo->obs = ''; 
        $cadastrarNewVinculo->created_at = $data->format('Y-m-d H:i:s.v');
        $cadastrarNewVinculo->user = $post['user'];
    if ($cadastrarNewVinculo->cadastrar()){
        $insert = true;
    } else {
        $insert = false;
    }  

    return $insert;
}