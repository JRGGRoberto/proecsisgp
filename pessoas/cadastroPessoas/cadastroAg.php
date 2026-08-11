<?php

require '../vendor/autoload.php';

use App\Entity\UuiuD;
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
            'tp_solicitacao' => 'cadastroAdmin',
            'tp_cadastro' => 'ag',
            'id_solicitador' => $user['id'],
            'id_avaliador' => $user['id'],
            'resultado' => 'a',
            'id_pessoa' => UuiuD::gera(),
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
            'portaria' => $_POST['portaria'],
            'ano_letivo' => date('Y'),
            'vinculo_remocao' => '',
            'tide' => '',
            'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        if(solicitacaoPessoas($post, $novaSenha)){
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
            exit;
        }
    }
    // Cadastro de DEC
    else{
        $post = [
            'tp_solicitacao' => 'cadastro',
            'tp_cadastro' => 'ag',
            'id_solicitador' => $user['id'],
            'id_avaliador' => null,
            'resultado' => null,
            'id_pessoa' => UuiuD::gera(),
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
            'portaria' => $_POST['portaria'],
            'vinculo_remocao' => '',
            'ano_letivo' => date('Y'),
            'tide' => '',
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        if(solicitacaoPessoas($post)){
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=1';
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=false';
                </script>
            ";
            exit;
        }
    }

}

include 'includes/form.php';