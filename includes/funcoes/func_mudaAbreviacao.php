<?php
// Função utilizada apenas para receber uma abreviação, verificar se ela existe na lista e mudar ela para o nome sem abreviação
// É necessário passar a abreviação para a função
// Ajudar na hora de dar manutenção em um nome

// Tabelas do banco que também tem abreviação:
// - campos_editaveis_projetos;

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();

function mudaAbreviacaoCampoAlterado($abreviacao){
  $abrevia = [
    'vigen_ini' => 'Início da vigência',
    'vigen_fim' => 'Fim da vigência',
    'id_prof' => 'Coordenador da proposta',
    'titulo' => 'Título da proposta',
    'tide' => 'TIDE'
  ];
  return $abrevia[$abreviacao];
};

function mudaAbreviacaoAprovacao($abreviacao){
  $abrevia = [
    'r' => 'Reprovado',
    'a' => 'Aprovado'
  ];
  return $abrevia[$abreviacao];
}

function mudaAbreviacaoTipoPropostas($abreviacao){
  $abrevia = [
    '1' => 'Curso',
    '2' => 'Evento',
    '3' => 'Prestação de Serviço',
    '4' => 'Programa',
    '5' => 'Projeto'
  ];
  return $abrevia[$abreviacao];
}

function mudaAbreviacaoHoraEstatica($abreviacao){
  $abrevia = [
    'ultimaHora' => ' 23:59:59.000',
    'meioDia' => ' 12:00:00.000'
  ];
  return $abrevia[$abreviacao];
}


// function getAvaliadorRelatorio($relatorio)
// {
//     switch ($relatorio->tp_avaliador) {
//         case 'ca':
//             return [
//                 'email' => $relatorio->chef_mail,
//                 'nome' => 'Chefe de Divisão',
//             ];

//         case 'ce':
//             return [
//                 'email' => $relatorio->ce_mail,
//                 'nome' => 'Diretor(a) de Centro',
//             ];

//         case 'co':
//             return [
//                 'email' => $relatorio->co_mail,
//                 'nome' => 'Coordenador(a)',
//             ];

//         case 'dc':
//             return [
//                 'email' => $relatorio->dc_mail,
//                 'nome' => 'Diretor(a) de Campus',
//             ];

//         default:
//             return null;
//     }
// }

//     public function getTipoRel($relatorio)
//     {
//         switch ($relatorio->tipo ?? $relatorio->tp_relatorio) {
//             case 'pa':
//                 return [
//                     'tipoNome' => 'Relatório Parcial',
//                     'tipoAbr' => 'p',
//                 ];
//             case 'fi':
//                 return [
//                     'tipoNome' => 'Relatório Final',
//                     'tipoAbr' => 'f',
//                 ];
//             case 're':
//                 return [
//                     'tipoNome' => 'Relatório Final com Renovação',
//                     'tipoAbr' => 'f',
//                 ];
//             case 'pr':
//                 return [
//                     'tipoNome' => 'Relatório Final com Prorrogação',
//                     'tipoAbr' => 'f',
//                 ];
//             default:
//                 return [
//                     'tipoNome' => 'erro',
//                     'tipoAbr' => 'erro',
//                 ];
//         }
//     }