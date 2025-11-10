<?php

namespace App\Entity;

use App\Db\Database;

class Candidato
{
    public $id;
    public $nome;
    public $rg;
    public $cpf;
    public $dt_nasc;
    public $ender;
    public $bairro;
    public $cidade;
    public $uf;
    public $cep;
    public $tel1;
    public $tel2;
    public $email;
    public $curso;
    public $serie;
    public $created_at;
    public $updated_at;
    public $ip_address;

    /**
     * Método responsável por cadastrar uma nova pessoa no banco.
     *
     * @return bool
     */
    public function cadastrar()
    {
        // INSERIR A REGISTRO NO BANCO
        $newId = UuiuD::gera(); // exec('uuidgen -r');
        $obDatabase = new Database('candidatos');
        $obDatabase->insert([
            'id' => $newId,
            'nome' => $this->nome,
            'rg' => $this->rg,
            'cpf' => $this->cpf,
            'dt_nasc' => $this->dt_nasc,
            'ender' => $this->ender,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'cep' => $this->cep,
            'tel1' => $this->tel1,
            'tel2' => $this->tel2,
            'email' => $this->email,
            'curso' => $this->curso,
            'serie' => $this->serie,
            'ip_address' => $this->ip_address,
            'created_at' => date('Y-m-d H:i:s'),
            // 'updated_at' => $this->updated_at,
        ]);

        // RETORNAR SUCESSO
        return $newId;
    }

    /**
     * Método responsável por atualizar REGISTRO no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('candidatos'))->update('id = "'.$this->id.'" ', [
            'nome' => $this->nome,
            'rg' => $this->rg,
            'cpf' => $this->cpf,
            'dt_nasc' => $this->dt_nasc,
            'ender' => $this->ender,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'cep' => $this->cep,
            'tel1' => $this->tel1,
            'tel2' => $this->tel2,
            'email' => $this->email,
            'curso' => $this->curso,
            'serie' => $this->serie,
            'ip_address' => $this->ip_address,
            //            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Método responsável por excluir a professor do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('candidatos'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function gets($where = null, $order = null, $limit = null)
    {
        return (new Database('candidatos'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @return array
     */
    public static function get($id)
    {
        $where = ' id = "'.$id.'" ';

        return (new Database('candidatos'))->select($where)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @return array
     */
    public static function getCPF($cpf)
    {
        $where = ' cpf = "'.$cpf.'" ';

        return (new Database('candidatos'))->select($where)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntd($where = null)
    {
        return (new Database('candidatos'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}
