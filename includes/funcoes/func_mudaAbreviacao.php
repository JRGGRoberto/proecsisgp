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
    'a' => 'Aprovado',
    'n' => 'Novo',
    'e' => 'Em espera'
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

function tipoRelatorio($abreviacao){
  $abrevia = [
    'pa' => 'Relatório Parcial',
    'fi' => 'Relatório Final',
    're' => 'Relatório Final com Renovação',
    'pr' => 'Relatório Final com Prorrogação'
  ];
  return $abrevia[$abreviacao];
}

function tipoCargos($abreviacao){
  $abrevia = [
    'pf' => 'Professor',
    'ag' => 'Agente',
    'ca' => 'Chefe de Divisão',
    'ce' => 'Diretor(a) de Centro',
    'co' => 'Coordenador(a)',
    'dc' => 'Diretor(a) de Campus',
    'ca' => 'Chefe de Divisão'
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

function mudaAbreviacaoPendencias($abreviacao){
  $abrevia = [
    // Tipos de pendências
    'av' => 'Avaliação',
    'aj' => 'Ajuste',
    'ntf' => 'Notificação',
    // Recebedores de pendências
    'proec' => 'PROEC',
    'dec' => 'DEC',
    'prop' => 'Proposta',
    'rp' => 'Relatório Parcial',
    'rf' => 'Relatório Final'
  ];
  return $abrevia[$abreviacao];
}


