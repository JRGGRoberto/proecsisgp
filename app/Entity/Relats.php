<?php

namespace App\Entity;

use App\Db\Database;

class Relats
{
    public $id;
    public $ver;
    public $idproj;
    public $regra;
    public $fase_atual;
    public $para_avaliar;
    public $tramitar;
    public $last_result;
    public $created_at;
    public $updated_at;
    public $user;

    /**
     * Método responsável por cadastrar um registro no banco.
     *
     * @return bool
     */
    public function cadastrar()
    {
        $submeter = false;
        $inicialTramitar = $this->tramitar;
        if ($this->tramitar == 1 and (($inicialTramitar == 0) or ($inicialTramitar == null))) {
            if ($this->fase_atual == 0) {
                $this->fase_atual = 1;
            }
            $submeter = true;
        }

        // INSERIR A REGISTRO NO BANCO
        $newId = UuiuD::gera(); // exec('uuidgen -r');
        $obDatabase = new Database('relats');
        $obDatabase->insert([
            'id' => $newId,
            'ver' => $this->ver,
            'idproj' => $this->idproj,
            'regra' => $this->regra,
            'fase_atual' => $this->fase_atual,
            'para_avaliar' => $this->para_avaliar,
            'tramitar' => $this->tramitar,
            'last_result' => $this->last_result,
            // 'created_at'   => $this->created_at,
            // 'updated_at' => date("Y-m-d H:i:s"),
            'user' => $this->user,
        ]);

        $submeter == true ? $this->submeter() : null;

        // RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar um registro no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        $submeter = false;
        $inicialTramitar = $this->tramitar;
        if ($this->tramitar == 1 and (($inicialTramitar == 0) or ($inicialTramitar == null))) {
            if ($this->fase_atual == 0) {
                $this->fase_atual = 1;
            }
            $submeter = true;
        }

        (new Database('relats'))->update('id =  "'.$this->id.'" ',
            [
                'ver' => $this->ver,
                'idproj' => $this->idproj,
                'regra' => $this->regra,
                'fase_atual' => $this->fase_atual,
                'para_avaliar' => $this->para_avaliar,
                'tramitar' => $this->tramitar,
                'last_result' => $this->last_result,
                // 'created_at'   => $this->created_at,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]);

        // RETORNAR SUCESSO

        $submeter == true ? $this->submeter() : null;

        return true;
    }

    /**
     * Método responsável por excluir registro do tipo relatório do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('relats'))->delete('id = '.$this->id);
    }

    public static function getRegistros($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('relats'))->select($where, $order, $limit, $fields)
                                ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as registro do banco de dados.
     *
     * @return array
     */
    public static function getRegistro($id)
    {
        $where = ' id = "'.$id.'" ';

        return (new Database('relats'))->select($where)
                                         ->fetchObject(self::class);
    }

    public static function getQntdRegistros($where = null)
    {
        return (new Database('relats'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }

    public function submeter()
    {
        $novaAvaliacao = new AvaliacoesRel();
        $novaAvaliacao->cadastrar($this->id, $this->fase_atual);

        return;
    }

    /*
    ** Método responsável por Aprovar a avaliação do relatório
    */
    public function aprovar()
    {
        $qnt = Outros::q('select count(1) qnt from to_avaliar_rel where id_rel = "'.$this->id.'"');
        $this->last_result = 'a';
        $this->updated_at = date('Y-m-d H:i:s');
        if ($this->fase_atual < $qnt) {
            ++$this->fase_atual;
        }
        $this->user = $this->user;
        $this->atualizar();
    }
}
