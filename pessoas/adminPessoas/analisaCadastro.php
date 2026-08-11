<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\EmailService;
use App\Entity\Solicita_Pessoas;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

// Email
$email = new EmailService();

// Parte que faz o aceite ou recusa
if($validade == 1 && $_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!array_key_exists('solicitacao_pessoa', $_POST) && !array_key_exists('resultado', $_POST)){  
        echo "
            <script>
                window.location.href = 'index.php?tipo=avalia&valida&sucesso=false';
            </script>
        ";
        exit;
    }

    $where = "id = '".$_POST['solicitacao_pessoa']."'";
    $atualizaSolicitacao = Solicita_Pessoas::getRegistros($where);
    $atualizaSolicitacao[0]->resultado = $_POST['resultado'];
    $atualizaSolicitacao[0]->id_avaliador = $user['id'];

    if ($_POST['resultado'] == 'r'){  // Se a solicitação feita for recusada
        if($atualizaSolicitacao[0]->atualizar()){
            // Email
            $email->alteracaoPessoas($atualizaSolicitacao[0],'',$_POST['resultado']);
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
            exit;
        }
    }
    elseif ($_POST['resultado'] == 'a'){ // Se a solicitação feita for aceita
        // Aqui pega a solicitação, transforma em array e, se for cadastro, gera a senha
        require_once '../includes/funcoes/func_solicitaPessoas.php';
        
        $dadosSolicitaPess_array = (array) $atualizaSolicitacao[0]; // Transforma em Array
        
        if ($atualizaSolicitacao[0]->tp_solicitacao == 'cadastro'){
            $novaSenha = substr(md5(uniqid()), 0, 8); // Gera senha
            $dadosSolicitaPess_array['senha'] = password_hash($novaSenha, PASSWORD_DEFAULT); // Hasheia
        }
        else {
            $novaSenha = '';
        }

        if($atualizaSolicitacao[0]->tp_cadastro == 'ag'){
            // analiseAgente() aqui que faz a atualização da tabela agentes
            // $atualizaSolicitacao[0]->atualizar() aqui que faz a atualização da tabela tb_solicita_pessoa
            if(analiseAgente($dadosSolicitaPess_array) && $atualizaSolicitacao[0]->atualizar()){
                // Email
                $email->alteracaoPessoas($atualizaSolicitacao[0],$novaSenha,$_POST['resultado']);
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
                exit;
            }
        }
        if($atualizaSolicitacao[0]->tp_cadastro == 'pf'){
            // analiseProfessor() Aqui que faz a atualização da tabela professores
            // $atualizaSolicitacao[0]->atualizar() Aqui que faz a atualização da tabela tb_solicita_pessoa
            if(analiseProfessor($dadosSolicitaPess_array) && $atualizaSolicitacao[0]->atualizar()){
                // Email
                $email->alteracaoPessoas($atualizaSolicitacao[0],$novaSenha,$_POST['resultado']);
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
                exit;
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