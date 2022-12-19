<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User
{
   public $user_id;
   public $user_name;
   public $user_email;
   public $user_password;

   public static function getUserByEmail($email){
        return (new Database('user'))->select('user_email = "'.$email.'"')->fetchObject(self::class);
   }
}
