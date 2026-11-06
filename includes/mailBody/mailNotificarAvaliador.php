<?php

// require '../vendor/autoload.php';

// require_once '../includes/funcoes/func_mudaAbreviacao.php';

// function mailNotificarAvaliador($id_proj, $titulo, $protocolo, $tipo_exten, $emailAvaliador, $nomeAvaliador){

//     $tipo = 1;
//     $idref = $id_proj;
        
//     $destinatario = $emailAvaliador;
//     $nome = $nomeAvaliador; 
    
//     $assunto = 'Notificação de avaliação pendente.';

//     $mensagem = '
//         <h2>Notificação de avaliação pendente no sistema da PROEC.</h2>
    
//         <p>Olá, <strong>'.$nome.'</strong>.</p>

//         <p>Identificamos que existe uma proposta aguardando sua avaliação no Sistema de Gerenciamento de Projetos da PROEC.</p>

//         <p><strong>Informações da proposta:</strong></p>
//         <p><strong>Título:</strong> '.$titulo.'</p>
//         <p><strong>Protocolo:</strong> '.$protocolo.'</p>
//         <p><strong>Tipo:</strong> '.mudaAbreviacaoTipoPropostas($tipo_exten).'</p>

//         <p>Solicitamos, por gentileza, que acesse o sistema para verificar a proposta e realizar a avaliação pendente.</p>

//         <p>Em caso de dúvidas, entre em contato com a equipe responsável.</p>

//         <br>
//         <small>Este e-mail é uma notificação automática do Sistema de Gerenciamento de Projetos da PROEC.</small>
//     ';

//     $dados = [
//         'tipo' => $tipo,
//         'idref' => $idref,
//         'destinatario' => $destinatario,
//         'nome' => $nome,
//         'assunto' => $assunto,
//         'mensagem' => $mensagem,
//     ];

//     return $dados;

// }



