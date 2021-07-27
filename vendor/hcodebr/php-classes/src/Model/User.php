<?php

namespace antoniocrcruz\Model;

use \antoniocrcruz\DB\Sql;
use \antoniocrcruz\Model;

class User extends Model{

    const SESSION = "User";

    public static function login($login, $password){
        
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if (count($results) === 0){
            throw new \Exception("Usuário inexistente ou senha inválida");// "\" colocada no código para achar a exception no namespace principal, no caso, apenas antoniocrcruz e não antoniocrcruz\Model
        }

        $data = $results[0];

        if (password_verify($password, $data["despassword"]) === true)
        {
            $user = new User();//cria uma nova instância da classe User

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();//retorna todos os valores da instância na sessão

            return $user;
            
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }

    }
    public static function verifyLogin($inadmin = true)
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ) {
            header("Location: /admin/login");
            exit;
        }
        
    }

    public static function logout(){

        $_SESSION[User::SESSION] = NULL;
    }

}

?>