<?php
require '../vendor/autoload.php';

use App\Entity\Professor;
use App\Entity\Vinculo;

function remocaoVinculoPf($id_user, $id_prof, $id_vinculo, $v){
    $where = 'id = "'.$id_prof.'"';
    $pessoa_requisicao = Professor::getProfessores($where);
    $pessoa_requisicao[0]->ativo = 0;

    $vinculo = Vinculo::get($id_vinculo);

    $insert = false;

    if ($vinculo && $pessoa_requisicao) {
        if(!$v){
            $post = [
                'tp_solicitacao' => 'desativacaoAdmin',
                'tp_cadastro' => 'pf',
                'id_solicitador' => $id_user,
                'id_avaliador' => $id_user,
                'resultado' => 'a',
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => $pessoa_requisicao[0]->titulacao,
                'lattes' => $pessoa_requisicao[0]->lattes,
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => '',
                'co_id' => $pessoa_requisicao[0]->id_colegiado,
                'cat_func' => $pessoa_requisicao[0]->cat_func,
                'rt' => '',
                'portaria' => '',
                'ano_letivo' => $vinculo->ano,
                'vinculo_remocao' => date('Y_m_d_').$pessoa_requisicao[0]->id,
            ];
            require_once '../includes/funcoes/func_solicitaPessoas.php';
            if(!solicitacaoPessoas($post)){
                return false;
            };
        }

        if ($pessoa_requisicao[0]->atualizarAtivo() && $vinculo->excluir()){
            $insert = true;
        }
    }
    return $insert;
}