<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;



class Palavras{

  public $idproj;
  public $palavra;

/*
  function __construct($idproj, $palavra){
    $this->idproj = $idproj;
    $this->palavra = $palavra;
    $this->cadastrar();
  }

  função constructor ficou dando erro...
*/
function incluir($idproj, $palavra){
  $this->idproj = $idproj;
  $this->palavra = $palavra;
  $this->cadastrar();
}

/**
   * Método responsável por obter as registros do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function getPalavrasByProj($idproj){
     return (new Database('palavras'))->select(' idproj = "'.$idproj.'"')
                                   ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

/**
   * Método responsável por obter as registros do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function getProjByPalavra($palavra){
    return (new Database('palavras'))->select('palavra = "'. $palavra ."'")
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }



  /**
   * Método responsável por excluir a Registro do banco
   * @return boolean
   */
  public static function excluir($idproj){
    return (new Database('palavras'))->delete('idproj = "'.$idproj.'"');
                                              
  }


  /**
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function cadastrar(){
    //DEFINIR A DATA
    // $this->data = date('Y-m-d H:i:s');
    $obDatabase = new Database('palavras');
        $obDatabase->insert([
                              'idproj' => $this->idproj,
                              'palavra' => $this->palavra
                           ]);

    //RETORNAR SUCESSO
    return true;
  }


}