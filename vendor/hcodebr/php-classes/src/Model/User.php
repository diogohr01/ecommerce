<?php 

namespace Hcode\Model;

use \Hcode\Model;
use \Hcode\DB\Sql;

class User extends Model {

	const SESSION = "User";

	protected $fields = [
		"iduser", "idperson", "deslogin", "despassword", "inadmin", "dtergister"
	];

	public static function login($login, $password) {
     
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            "LOGIN"=>$login
        ));
     
        if (count($results) === 0) {
     
            throw new \Exception("Usuario inexistente ou senha invalida.");
                
        }
     
        $data = $results[0];
     
        if (password_verify($password, $data["despassword"]) === true) {
     
            $user = new User();
            $user->setiduser($data["iduser"]);
     
        } else {
            throw new \Exception("Usuario inexistente ou senha invalida.");
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
			(bool)$_SESSION[User::SESSION]["iduser"] !== $inadmin
		) {
			
			header("Location: /ecommerce/admin/login");
			exit;

		}

	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}

}

 ?>
