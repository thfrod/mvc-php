<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    // ID do depoimento
    public $id;

    // Nome do usuário que fez o depoimento
    public $name;

    // Mensagem do depoimento
    public $message;

    // Data do depoimento
    public $data;

    // Método responsável por cadastrar a a instância atual no banco de dados
    public function register()
    {
        // Define a data
        $this->data = date('Y-m-d H:i:s');
        // Insere depoimento no BD
        $this->id = (new Database('testimonies'))->insert([
            'testimony_name' => $this->name,
            'testimony_message' => $this->message,
            'testimony_data' => $this->data,
        ]);
        return true;
    }

    // método responsável por retornar os depoimentos
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('testimonies'))->select(
            $where,
            $order,
            $limit,
            $fields
        );
    }
}
