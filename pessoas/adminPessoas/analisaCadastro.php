<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Agente;
use App\Entity\Professor;
use App\Entity\Solicita_Pessoas;
use App\Entity\Vinculo;
use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();


function agentes($dados){

    $where = 'id = "'.$dados->id_pessoa.'"';
    $agnt = Agente::gets($where);

    if ($dados->tp_solicitacao == 'cadastro'){
        
        $novaSenha = substr(md5(uniqid()), 0, 8); 

        $post = [
        // Identificador de tabela e tipo de Cadastro
        'tp_solicitacao' => 'cadastroAdmin',
        'tp_cadastro' => 'ag',
        // Quem cadastrou
        'idResponsavel' => $dados->id_solicitador,
        // Dados que serão inseridos
        'nome' => $dados->nome,
        'cpf' => $dados->cpf,
        'email' => $dados->email,
        'telefone' => $dados->telefone,
        'ca_id' => $dados->ca_id,
        'cat_func' => $dados->cat_func,
        'portaria' => $dados->portaria,
        'ano_letivo' => $dados->ano_letivo,
        'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        return insercaoPessoasAdmin($post);

    }
    elseif ($dados->tp_solicitacao == 'desativacao'){

        $agnt[0]->ativo = 0;

        if ($agnt[0]->atualizarAtivo()){
            return true;
        }
        else {
            return false;
        }

    }
    elseif ($dados->tp_solicitacao == 'reativacao'){

        $agnt[0]->ativo = 1;

        // Para garantir que tenha um email para acessar e esteja em um campus
        if(!$agnt[0]->email || !$agnt[0]->lotacao){
            return false;
        }

        $agnt[0]->cat_func = $dados->cat_func;

        if($agnt[0]->atualizarAtivo() && $agnt[0]->atualizarCatFunc()){
            return true;
        }
        else {
            return false;
        }

    } 
}

function professores($dados){

    if ($dados->rt == 'TIDE'){
        $tide = 1;
    } else {
        $tide = 0;
    }
    
    $novaSenha = substr(md5(uniqid()), 0, 8); 

    $where = 'id = "'.$dados->id_pessoa.'"';
    $profs = Professor::getProfessores($where);

    if ($dados->tp_solicitacao == 'cadastro'){
        $post = [
        // Identificador de tabela e tipo de Cadastro
        'tp_solicitacao' => 'cadastroAdmin',
        'tp_cadastro' => 'ag',
        // Quem cadastrou
        'idResponsavel' => $dados->id_solicitador,
        // Dados que serão inseridos
        'nome' => $dados->nome,
        'cpf' => $dados->cpf,
        'titulacao' => $dados->titulacao,
        'lattes' => $dados->lattes,
        'email' => $dados->email,
        'telefone' => $dados->telefone,
        'co_id' => $dados->co_id,
        'cat_func' => $dados->cat_func,
        'rt' => $dados->rt,
        'tide' => $tide,
        'portaria' => $dados->portaria,
        'ano_letivo' => $dados->ano_letivo,
        'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        return insercaoPessoasAdmin($post);
    }
    elseif ($dados->tp_solicitacao == 'desativacao'){

        $vinculo_remocao = Vinculo::getByAnoProf($profs[0]->id, $dados->ano_letivo);

        if($_SERVER['HTTP_HOST'] == 'sistemaproec.unespar.edu.br'){  // Para produção
            $baseUrl = 'https://'.$_SERVER['HTTP_HOST']; 
        } 
        else{ // Para Localhost
            $baseUrl = 'http://'.$_SERVER['HTTP_HOST']; 
        }
        
        if (isset($vinculo_remocao->id)){
            echo "
                <script>
                fetch('{$baseUrl}/epad/padstopdf/indexHtml.php?id={$vinculo_remocao->id}')
                    .then(r => r.json())
                    .then(epadResponse => {
                        if (epadResponse.status === 'ok') {
                            window.open(epadResponse.url, '_blank');
                            return fetch('../api/remocao_vinculoPf.php?vinculo_id={$vinculo_remocao->id}&prof_id={$profs[0]->id}');
                        }

                        throw new Error();
                    })
                    .then(r => r.json())
                    .then(apiResponse => {
                        if (apiResponse.status === 'ok') {
                            console.log('okok');
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=1';
                        } else {
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
                        }
                    })
                    .catch(error => { 
                        window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
                    });
                </script>
            ";
            $dados->atualizar();
        }
        else{
            return false;
        }
        exit;
    }
    elseif ($dados->tp_solicitacao == 'reativacao'){
                    
        // Para garantir que tenha um email para acessar e esteja em um colegiado
        if(!$profs[0]->email || !$profs[0]->id_colegiado){
            return false;
        }

        $profs[0]->ativo = 1;
        $profs[0]->cat_func = $dados->cat_func;

        $post = [  // O que vai para a tabela Vínculo
            'ano' => date('Y'), // ANO ATUAL
            'rt' => $dados->rt, // PEGAR REGIME POR POST
            'tide' => $tide,
            'id_prof' => $profs[0]->id,
            'user' => $dados->id_solicitador,
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        $insert = reativacaoPessoasAdmin($post);

        if($profs[0]->atualizarAtivo() && $profs[0]->atualizarCatFunc() && $insert){
            return true;
        }
        else {
            return false;
        }

    } 
}


// Parte que faz o aceite ou recusa
if($validade == 1 && $_SERVER['REQUEST_METHOD'] === 'POST'){
    if (array_key_exists('solicitacao_pessoa', $_POST) && array_key_exists('resultado', $_POST)){  

        $where = "id = '".$_POST['solicitacao_pessoa']."'";
        $atualizaSolicitacao = Solicita_Pessoas::getRegistros($where);
        $atualizaSolicitacao[0]->resultado = $_POST['resultado'];
        $atualizaSolicitacao[0]->id_avaliador = $user['id'];

        if ($_POST['resultado'] == 'r'){

            if($atualizaSolicitacao[0]->atualizar()){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=avalia&valida&sucesso=1';
                    </script>
                ";
                exit;
            } else {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
                </script>
            ";
            }
        }
        elseif ($_POST['resultado'] == 'a'){

            if($atualizaSolicitacao[0]->tp_cadastro == 'ag'){

                $resultadoAgentes = agentes($atualizaSolicitacao[0]);

                if($resultadoAgentes == true){
                    $atualizaSolicitacao[0]->atualizar(); 
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=1';
                        </script>
                    ";
                    exit;

                } elseif ($resultadoAgentes == false) {
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
                        </script>
                    ";
                    exit;
                }

            }
            if($atualizaSolicitacao[0]->tp_cadastro == 'pf'){

                $resultadoProfessores = professores($atualizaSolicitacao[0]);
    
                if($resultadoProfessores == true){
                    $atualizaSolicitacao[0]->atualizar(); 
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=1';
                        </script>
                    ";
                    exit;

                } elseif ($resultadoProfessores == false) {
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
                        </script>
                    ";
                    exit;
                }
            }              
        }
    }
}


// Onde envia as coisas para o front
if($_GET['tipo'] == 'avalia'){
    $where = 'id_avaliador is null and resultado is null';
} else {
    $where = 'id_avaliador is not null and resultado is not null';
}


// Para usar a paginação
$pessoasCount = Solicita_Pessoas::getQntdPessoas($where);
$obPagination = new Pagination($pessoasCount, $_GET['pagina'] ?? 1, 4);

$solicitacao_pessoas = Solicita_Pessoas::getRegistros($where, null, $obPagination->getLimite());

include 'includes/pagAnalisaCadastro.php';

?>