<?php

namespace App\Entity;

use App\Db\Database;

class Form_Rel_Selec_Prof
{
    public $id;
    public $id_avaliador;
    public $id_parecerista;
    public $solicitacoes;
    public $cidade;
    public $whosigns; // Nome fulando + cargo
    public $dateAssing;
    public $resultado;
    public $created_at;
    public $updated_at;
    public $user;

    /**
     * Método responsável por buscar um Registro com base em seu ID.
     *
     * @return Form_a
     */
    public static function getRegistro($id)
    {
        return (new Database('form_rel_selec_prof'))->select(' id  = "'.$id.'" ')
                                      ->fetchObject(self::class);
    }// form_rel_selec_prof

    public function cadastrar()
    {
        // DEFINIR A DATA
        // $this->data = date('Y-m-d H:i:s');
        //        $newId = UuiuD::gera();
        $obDatabase = new Database('form_rel_selec_prof');
        $obDatabase->insert([
            'id' => $this->id,
            'id_avaliador' => $this->id_avaliador,
            'id_parecerista' => $this->id_parecerista,
            'solicitacoes' => $this->solicitacoes,
            'cidade' => $this->cidade,
            'whosigns' => $this->whosigns,
            'dateAssing' => date('Y-m-d H:i:s'),
            'resultado' => $this->resultado,
            'created_at' => date('Y-m-d H:i:s'),
            //                        'updated_at'   => $this->updated_at,
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar a Registro no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('form_rel_selec_prof'))->update('id =  "'.$this->id.'"  ',
            [
                'id_avaliador' => $this->id_avaliador,
                'id_parecerista' => $this->id_parecerista,
                'solicitacoes' => $this->solicitacoes,
                'cidade' => $this->cidade,
                'whosigns' => $this->whosigns,
                'dateAssing' => date('Y-m-d H:i:s'),
                'resultado' => $this->resultado,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]);
    }
}
