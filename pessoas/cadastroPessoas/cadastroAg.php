<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

$tipo = 'ag';
$mensagem = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Cadastro de Admin
    if ($validade == 1){

        $novaSenha = substr(md5(uniqid()), 0, 8); 

        $post = [
            // Identificador de tabela e tipo de Cadastro
            'tp_solicitacao' => 'cadastroAdmin',
            'tp_cadastro' => 'ag',
            // Quem cadastrou
            'idResponsavel' => $user['id'],
            // Dados que serão inseridos
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'titulacao' => 'n/a',
            'lattes' => '',
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'ca_id' => $_POST['ca'],
            'co_id' => '',
            'cat_func' => $_POST['categoria'],
            'rt' => '',
            // 'tide' =>,
            'portaria' => $_POST['portaria'],
            'ano_letivo' => date('Y'),
            'vinculo_remocao' => '',
            'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        $insert = insercaoPessoasAdmin($post);

        if($insert){
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=2';
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=false';
                </script>
            ";
        }
    }
    // Cadastro de DEC
    else{
        $post = [
            'tp_solicitacao' => 'cadastro',
            'tp_cadastro' => 'ag',
            'id_solicitador' => $user['id'],
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'titulacao' => 'n/a',
            'lattes' => '',
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'ca_id' => $_POST['ca'],
            'co_id' => '',
            'cat_func' => $_POST['categoria'],
            'ano_letivo' => date('Y'),
            'rt' => '',
            'vinculo_remocao' => '',
            'portaria' => $_POST['portaria'],
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        $insert = solicitacaoPessoas($post);
        
        if($insert == true){
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=1';
                </script>
            ";
            exit;
        } elseif ($insert == false) {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=false';
                </script>
            ";
        }
    }

}

include 'includes/form.php';