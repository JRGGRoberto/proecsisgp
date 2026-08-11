<?php

require '../vendor/autoload.php';

use App\Entity\Agente;
use App\Entity\EmailService;
use App\Entity\Professor;
use App\Entity\Solicita_Pessoas;
use App\Entity\UuiuD;
use App\Entity\Vinculo;
use App\Session\Login;

Login::requireLogin();

function analiseVinculo($post){
    $insert = false;
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $tide = ($post['rt'] == 'TIDE') ? 1 : 0; // Inserir se é TIDE ou não na tabela Vinculos
    // Cadastra o vínculo
    $cadastrarNewVinculo = new Vinculo();
        $cadastrarNewVinculo->ano = $post['ano_letivo'];
        $cadastrarNewVinculo->rt = $post['rt'];
        $cadastrarNewVinculo->tide = $tide;
        $cadastrarNewVinculo->id_prof = $post['id_pessoa'];
        $cadastrarNewVinculo->area_concurso = '';
        $cadastrarNewVinculo->dt_obtn_tit = null;
        $cadastrarNewVinculo->tempo_cc = ''; 
        $cadastrarNewVinculo->tempo_esu = '';
        $cadastrarNewVinculo->obs = ''; 
        $cadastrarNewVinculo->created_at = $data->format('Y-m-d H:i:s.v');
        $cadastrarNewVinculo->user = $post['id_solicitador'];
    if ($cadastrarNewVinculo->cadastrar()){
        $insert = true;
    }
    return $insert;
}

function analiseProfessor($post){
    $insert = false;
    if (!$post['tp_solicitacao'] == 'cadastro' || !$post['tp_solicitacao'] == 'cadastroAdmin'){
        $where = 'id = "'.$post['id_pessoa'].'"';
        $profs = Professor::getProfessores($where);  
        $vinculo_remocao = Vinculo::getByAnoProf($profs[0]->id, $post['ano_letivo']);
    }

    if ($post['tp_solicitacao'] == 'cadastro' || $post['tp_solicitacao'] == 'cadastroAdmin'){
        // Cadastra o professor            
        $cadastroProf = new Professor();
            $cadastroProf->id = $post['id_pessoa']; 
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
            $cadastroProf->user = $post['id_solicitador'];   
        if($cadastroProf->cadastrar() && analiseVinculo($post)){
            $insert = true;
        }  
    }
    elseif ($post['tp_solicitacao'] == 'reativacao'){        
        // Para garantir que tenha um email para acessar e esteja em um colegiado
        if(!$profs[0]->email || !$profs[0]->id_colegiado){
            return false;
        }
        $profs[0]->ativo = 1;
        $profs[0]->cat_func = $post['cat_func'];
        if($profs[0]->atualizarAtivo() && $profs[0]->atualizarCatFunc() && analiseVinculo($post)){
            $insert = true;
        }
    } 
    elseif ($post['tp_solicitacao'] == 'desativacao'){   
        require_once __DIR__ . '/func_conexaoEpad.php';
        if(conexaoEpad($post['id_solicitador'], $profs[0]->id, $vinculo_remocao->id, $v=true)){
            $insert = true;
        }
    }
    return $insert;
}

function analiseAgente($post){
    $insert = false;
    // Data
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    // Pegar os dados do Agente
    $where = 'id = "'.$post['id_pessoa'].'"';
    $agnt = Agente::gets($where);

    if ($post['tp_solicitacao'] == 'cadastro' || $post['tp_solicitacao'] == 'cadastroAdmin'){
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
            $cadastroAg->user = $post['id_solicitador'];
        if($cadastroAg->cadastrar()){
            $insert = true;
        }
    }
    elseif ($post['tp_solicitacao'] == 'desativacao'){
        $agnt[0]->ativo = 0;
        if ($agnt[0]->atualizarAtivo()){
            $insert = true;
        }
    }
    elseif ($post['tp_solicitacao'] == 'reativacao'){
        $agnt[0]->ativo = 1;
        $agnt[0]->cat_func = $post['cat_func'];
        // Para garantir que tenha um email para acessar e esteja em um campus
        if(!$agnt[0]->email || !$agnt[0]->lotacao){
            return false;
        }
        if($agnt[0]->atualizarAtivo() && $agnt[0]->atualizarCatFunc()){
            $insert = true;
        }
    } 
    return $insert;
}

// Aqui é a função para cadastrar na tabela tb_solicitacao_pessoas
// Ela chama as funções para cadastro em outros campos
function solicitacaoPessoas($post, $senha = ''){
    
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $idSolicitacaoPessoas = UuiuD::gera(); // Não é o ID da pessoa e sim da tabela

    $cadastro = new Solicita_Pessoas();
        $cadastro->id = $idSolicitacaoPessoas;
        $cadastro->tp_solicitacao = $post['tp_solicitacao'];
        $cadastro->tp_cadastro = $post['tp_cadastro'];
        $cadastro->id_solicitador = $post['id_solicitador'];
        $cadastro->id_avaliador = $post['id_avaliador']; 
        $cadastro->resultado = $post['resultado'];
        $cadastro->id_pessoa = $post['id_pessoa'];
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

    if ($post['tp_solicitacao'] == 'reativacaoAdmin' && $post['tp_cadastro'] == 'pf'){
        // Cadastra o vínculo
        $insert = analiseVinculo($post);
    }

    if ($post['tp_solicitacao'] == 'cadastroAdmin'){
        if ($post['tp_cadastro'] == 'ag'){
            $insert = analiseAgente($post);
        }
        elseif ($post['tp_cadastro'] == 'pf'){
            $insert = analiseProfessor($post);
        }
    }

    // Email
    $email = new EmailService();

    if ($post['tp_solicitacao'] == 'cadastro'||$post['tp_solicitacao'] == 'reativacao'||$post['tp_solicitacao'] == 'desativacao'){
        if ($cadastro->insertRegistros()){
            $insert = true;
            $email->alteracaoPessoas($cadastro);
        } else {
            $insert = false;
        }
    }
    elseif ($post['tp_solicitacao'] == 'cadastroAdmin'||$post['tp_solicitacao'] == 'reativacaoAdmin'||$post['tp_solicitacao'] == 'desativacaoAdmin'){;
        if ($cadastro->insertRegistrosAdm()){
            $insert = true;
            $email->alteracaoPessoas($cadastro, $senha);
        } else {
            $insert = false;
        }
    }
    return $insert;
}

function removeSolicitacao($idPessoa){
    $where = 'id_pessoa = "'.$idPessoa.'"';
    $desativacao = Solicita_Pessoas::getRegistros($where);

    $desativacao[0]->tp_solicitacao = $desativacao[0]->tp_solicitacao.'Rm';

    // Email
    $email = new EmailService();
      
    if ($desativacao[0]->excluir()){
        $rm = true;
        $email->alteracaoPessoas($desativacao[0]);
    } else {
        $rm = false;
    }

    return $rm;

}
