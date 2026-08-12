<?php

require '../vendor/autoload.php';
require_once '../includes/funcoes/func_mudaAbreviacao.php';

function mailInsercaoADM($dados){
    $tipo = 12; // Cadastro de pessoa por ADM
    
    $nomeADM = ucwords(strtolower($dados['nomeResponsavelAvaliacao']));
    $nomeChefe = ucwords(strtolower($dados['nomeResponsavelLocal']));
    $nomeInteressado = ucwords(strtolower($dados['nomeInteressado']));
    $tipoCargos = tipoCargos($dados['tp_cadastro']);

    if($_SERVER['HTTP_HOST'] == 'sistemaproec.unespar.edu.br'){  // Para produção
        $baseUrl = 'https://'.$_SERVER['HTTP_HOST']; 
    } 
    else{ // Para Localhost
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST']; 
    }
    

    if ($dados['tp_solicitacao'] == 'reativacaoAdmin'){
        $assunto = 'Usuário ativado no sistema';

        $msg1 = fn($nome, $nomeInteressado, $tipoCargos) => '
            <h2>Reativação efetuada com sucesso!</h2>
            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>
                Informamos que a solicitação de <strong>reativação</strong> foi realizado com sucesso!
            </p>
            <p>
                Nome do usuário: <strong>'.$nomeInteressado.'</strong>
            </p>
            <p>
                Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
            </p>
            <br>
            <small>Este e-mail é automático.</small>   
        ' ;

        $msg2 = '
            <h2>Acesso disponível no sistema!</h2>
            <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
            <p>
                Informamos que sua conta está disponível novamente para acesso no sistema.
            </p>
            <p>
                Para realizar o login, utilize as credenciais que você já utilizava anteriormente.
            </p>
            <p>
                Caso necessário é possível recuperar sua senha em: '.$baseUrl.'/sistema/login/recuperar.php
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ' ;

    }

    if ($dados['tp_solicitacao'] == 'cadastroAdmin'){
        $assunto = 'Usuário cadastrado';

        $msg1 = fn($nome, $nomeInteressado, $tipoCargos) => '
            <h2>Cadastrado incluído ao sistema!</h2>
            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>
                Informamos que a solicitação de <strong>cadastro</strong> foi realizado com sucesso!
            </p>
            <p>
                Nome do usuário: <strong>'.$nomeInteressado.'</strong>
            </p>
            <p>
                Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
            </p>
            <br>
            <small>Este e-mail é automático.</small>   
        ' ;

        $msg2 = '
            <h2>Acesso disponível no sistema!</h2>
            <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
            <p>
                Informamos que sua conta está disponível para acesso no sistema.
            </p>
            <p>
                Para realizar o primeiro login utilize as credenciais abaixo.
            </p>
            <p>Login: <strong>'.$dados['emailInteressado'].'</strong></p>
            <p>Senha: <strong>'.$dados['senhaAcesso'].'</strong></p>
            <p>
                Solicitamos que a senha seja alterada após o primeiro login.
            </p>
            <p>
                Para alterar a senha, clique em seu nome, no canto superior direito da tela, e, em seguida, clique em "Perfil".
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ' ;

    }

    if ($dados['tp_solicitacao'] == 'desativacaoAdmin'){
        $assunto = 'Usuário desativado';

        if($dados['vinculo_remocao']){
            $link = 
            '<p>
                Link para acesso ao PAD do professor: 
                href="'.$baseUrl.'/sistema/upload/uploads/pads/'.$dados['vinculo_remocao'].'.html" target="_blank">'.$nomeInteressado.'</a>
            </p>';
        }
        else {
            $link = null;
        }

        $msg1 = fn($nome, $nomeInteressado, $tipoCargos) => '
            <h2>Usuário desativado no sistema!</h2>
            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>
                Informamos que a solicitação de <strong>desativação</strong> foi realizado com sucesso!
            </p>
            '.$link.'
            <p>
                Nome do usuário: <strong>'.$nomeInteressado.'</strong>
            </p>
            <p>
                Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
            </p>
            <br>
            <small>Este e-mail é automático.</small>   
        ' ;

        $msg2 = '
            <h2>Acesso desativado no sistema!</h2>
            <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
            <p>
                Informamos que sua conta foi desabilitada e está indisponível para acesso no momento.
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ' ;
    }

    $msg = [
        'tipo' => $tipo, 

        'administrador' => [
            'destinatario' => $dados['emailResponsavelAvaliacao'],
            'nome' => $dados ['nomeResponsavelAvaliacao'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeADM,$nomeInteressado,$tipoCargos),
        ],
        'chefe' => [
            'destinatario' => $dados['emailResponsavelLocal'],
            'nome' => $dados ['nomeResponsavelLocal'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeChefe,$nomeInteressado,$tipoCargos),
        ],
        'interessado' => [
            'destinatario' => $dados['emailInteressado'],
            'nome' => $dados ['nomeInteressado'],
            'assunto' => $assunto,
            'mensagem' => $msg2,
        ]
    ];
    
    return $msg;

}

function mailSolicitacaoPessoas($dados){
    $tipo = 13; // Solicitação pelos chefes

    $nomeChefe = ucwords(strtolower($dados['nomeResponsavelLocal']));
    $nomeInteressado = ucwords(strtolower($dados['nomeInteressado']));
    $tipoCargos = tipoCargos($dados['tp_cadastro']);

    require_once '../includes/funcoes/func_mudaAbreviacao.php';
    $dados['tp_solicitacao'] = strtolower(tipoSolicitacao($dados['tp_solicitacao'])); 

    $assunto = 'Solicitação enviada!';
    $msg1 = fn($nome, $nomeInteressado, $tipoCargos) => '
        <h2>Solicitação incluída no sistema!</h2>
        <p>Olá <strong>'.$nome.'</strong>,</p>
        <p>
            Informamos que a solicitação de <strong>'.$dados['tp_solicitacao'].'</strong> foi realizado com sucesso!
        </p>
        <p>
            Nome do usuário: <strong>'.$nomeInteressado.'</strong>
        </p>
        <p>
            Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
        </p>
        <br>
        <small>Este e-mail é automático.</small>
    ' ;

    $msg = [
        'tipo' => $tipo, 

        'chefe' => [
            'destinatario' => $dados['emailResponsavelLocal'],
            'nome' => $dados ['nomeResponsavelLocal'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeChefe,$nomeInteressado,$tipoCargos),
        ]
    ];   
    return $msg;
}

function mailRemocaoSolicitacaoPessoas($dados){
    $tipo = 14; // Remoção de solicitação pelos chefes

    $nomeChefe = ucwords(strtolower($dados['nomeResponsavelLocal']));
    $nomeInteressado = ucwords(strtolower($dados['nomeInteressado']));
    $tipoCargos = tipoCargos($dados['tp_cadastro']);

    require_once '../includes/funcoes/func_mudaAbreviacao.php';
    $dados['tp_solicitacao'] = strtolower(tipoSolicitacao($dados['tp_solicitacao'])); 

    $assunto = 'Remoção de solicitação efetuada.';
    $msg1 = fn($nome, $nomeInteressado, $tipoCargos) => '
        <h2>Remoção de solicitação efetuada no sistema!</h2>
        <p>Olá <strong>'.$nome.'</strong>,</p>
        <p>
            Informamos que a solicitação de <strong>'.$dados['tp_solicitacao'].'</strong> foi cancelada com sucesso!
        </p>
        <p>
            Nome do usuário: <strong>'.$nomeInteressado.'</strong>
        </p>
        <p>
            Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
        </p>
        <br>
        <small>Este e-mail é automático.</small>
    ' ;

    $msg = [
        'tipo' => $tipo, 

        'chefe' => [
            'destinatario' => $dados['emailResponsavelLocal'],
            'nome' => $dados ['nomeResponsavelLocal'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeChefe,$nomeInteressado,$tipoCargos),
        ]
    ];   
    return $msg;
}

function mailAvaliacaoADM($dados){
    
    $tipo = 15; // Cadastro de pessoa por ADM

    $nomeADM = ucwords(strtolower($dados['nomeResponsavelAvaliacao']));
    $nomeChefe = ucwords(strtolower($dados['nomeResponsavelLocal']));
    $nomeInteressado = ucwords(strtolower($dados['nomeInteressado']));
    $tipoCargos = tipoCargos($dados['tp_cadastro']);

    require_once '../includes/funcoes/func_mudaAbreviacao.php';
    $n_tp_solicitacao = strtolower(tipoSolicitacao($dados['tp_solicitacao'])); 


    if($_SERVER['HTTP_HOST'] == 'sistemaproec.unespar.edu.br'){  // Para produção
        $baseUrl = 'https://'.$_SERVER['HTTP_HOST']; 
    } 
    else{ // Para Localhost
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST']; 
    }

    if ($dados['resultado'] == 'r'){
        $assunto = 'Avaliação de solicitação';

        $msg1 = fn($nome, $nomeInteressado, $tipoCargos, $n_tp_solicitacao) => '
            <h2>Avaliação de solicitação</h2>
            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>
                Informamos que a solicitação de <strong>'.$n_tp_solicitacao.'</strong> não foi acatada!
            </p>
            <p>
                Nome do usuário: <strong>'.$nomeInteressado.'</strong>
            </p>
            <p>
                Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
            </p>
            <br>
            <small>Este e-mail é automático.</small>   
        ' ; 
    }
    elseif ($dados['resultado'] == 'a'){
        
        if ($dados['tp_solicitacao'] == 'cadastro'){
            $assunto = 'Usuário cadastrado';

            $msg2 = '
                <h2>Acesso disponível no sistema!</h2>
                <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
                <p>
                    Informamos que sua conta está disponível para acesso no sistema.
                </p>
                <p>
                    Para realizar o primeiro login utilize as credenciais abaixo.
                </p>
                <p>Login: <strong>'.$dados['emailInteressado'].'</strong></p>
                <p>Senha: <strong>'.$dados['senhaAcesso'].'</strong></p>
                <p>
                    Solicitamos que a senha seja alterada após o primeiro login.
                </p>
                <p>
                    Para alterar a senha, clique em seu nome, no canto superior direito da tela, e, em seguida, clique em "Perfil".
                </p>
                <br><br>
                <small>Este e-mail é automático.</small>
            ' ;
        }

        if ($dados['tp_solicitacao'] == 'reativacao'){
            $assunto = 'Usuário ativado no sistema';

            $msg2 = '
                <h2>Acesso disponível no sistema!</h2>
                <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
                <p>
                    Informamos que sua conta está disponível novamente para acesso no sistema.
                </p>
                <p>
                    Para realizar o login, utilize as credenciais que você já utilizava anteriormente.
                </p>
                <p>
                    Caso necessário é possível recuperar sua senha em: '.$baseUrl.'/sistema/login/recuperar.php
                </p>
                <br><br>
                <small>Este e-mail é automático.</small>
            ' ;
        }

        $link = null;
        if ($dados['tp_solicitacao'] == 'desativacao'){
            $assunto = 'Usuário desativado';         
            if($dados['vinculo_remocao']){
                $link = 
                '<p>
                    Link para acesso ao PAD do professor: 
                    href="'.$baseUrl.'/sistema/upload/uploads/pads/'.$dados['vinculo_remocao'].'.html" target="_blank">'.$nomeInteressado.'</a>
                </p>';
            }
            else {
                $link = null;
            }

            $msg2 = '
                <h2>Acesso desativado no sistema!</h2>
                <p>Olá <strong>'.$nomeInteressado.'</strong>,</p>
                <p>
                    Informamos que sua conta foi desabilitada e está indisponível para acesso no momento.
                </p>
                <br><br>
                <small>Este e-mail é automático.</small>
            ' ;
        }

        $msg1 = fn($nome, $nomeInteressado, $tipoCargos, $n_tp_solicitacao) => '
            <h2>Solicitação de '.ucfirst($n_tp_solicitacao).' efetuada com sucesso!</h2>
            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>
                Informamos que a solicitação de <strong>'.$n_tp_solicitacao.'</strong> foi realizada com sucesso!
            </p>
            '.$link.'
            <p>
                Nome do usuário: <strong>'.$nomeInteressado.'</strong>
            </p>
            <p>
                Cargo: <strong>'.ucwords(strtolower($tipoCargos)).'</strong>
            </p>
            <br>
            <small>Este e-mail é automático.</small>   
        ' ;
    }

    $msg = [
        'tipo' => $tipo, 

        'administrador' => [
            'destinatario' => $dados['emailResponsavelAvaliacao'],
            'nome' => $dados ['nomeResponsavelAvaliacao'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeADM,$nomeInteressado,$tipoCargos,$n_tp_solicitacao),
        ],
        'chefe' => [
            'destinatario' => $dados['emailResponsavelLocal'],
            'nome' => $dados ['nomeResponsavelLocal'],
            'assunto' => $assunto,
            'mensagem' => $msg1($nomeChefe,$nomeInteressado,$tipoCargos,$n_tp_solicitacao),
        ],
        'interessado' => [
            'destinatario' => $dados['emailInteressado'],
            'nome' => $dados ['nomeInteressado'],
            'assunto' => $assunto,
            'mensagem' => $msg2,
        ]
    ];
    
    return $msg;

}