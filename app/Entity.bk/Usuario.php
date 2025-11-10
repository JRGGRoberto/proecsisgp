<?php

namespace App\Entity;

use \App\Db\Database;
use App\Session\Login;

class Usuario{
  public $id;
  public $nome;
  public $email;
  public $senha;
  public $config;
  public $ce_id;
  public $ce_cod;
  public $ce_nome;
  public $co_id;
  public $co_nome;
  public $ca_id;
  public $ca_cod;
  public $ca_nome;
  public $tipo;
  public $adm;
  public $ativo;

/*
  public $id;
  public $nome;
  public $lattes;
  public $titulacao;
  public $email;
  public $telefone;
  public $id_colegiado;
  public $cat_func;
  public $ativo;
  public $senha;
  public $adm;
  public $created_at;
  public $uddated_at;
  public $user;
  public $ca_id;
  public $campus;
  public $chef_div_id;
  public $chef;
  public $ce_id;
  public $centros;
  public $dir_ca_id;
  public $dir_ca;
  public $co_id;
  public $colegiado;
  public $coord_id;
  public $coord;
  public $nivel;
  public $niveln;
  public $tpnivel;
  */

  /**
   * Método responsável por retornar uma instancia de usuário com base em seu e-mail
   * @param string $email
   * @return Usuário
   */
  public static function getUsuarioPorEmail($email){
   return (new Database('usuarios'))->select('email ="'.$email.'"')->fetchObject(self::class);
  }
  

  public function updateSenha(){ 
      
    if ($this->tipo === 'agente'){
      return (new Database('agentes'))->update('id = '.$this->id,[
        'senha' => $this->senha , 
        'updated_at' => date("Y-m-d H:i:s"),
      ]);
    }

    if ($this->tipo === 'prof'){
      return (new Database('professores'))->update('id = '.$this->id,[
        'senha' => $this->senha , 
        'updated_at' => date("Y-m-d H:i:s"),
      ]);
    }
     
  }
}
