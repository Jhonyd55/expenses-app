<?php
require_once 'models/usermodel.php';
class LoginModel extends Model {
    
    function __construct(){
        parent::__construct();

    }

    function login($username,$password){
        try{error_log("LoginModel::login-> ENTRA A LOGIN ".$username." ".$password);
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            $query -> execute([
                'username'=> $username
            ]);

            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::FETCH_ASSOC);  
            $user = new UserModel();
            $user->from($item);
            
            if(password_verify($password,$user->getPassword())){
                error_log("LoginModel::login-> usuario verificado ");
                return $user;
            }else{error_log("LoginModel::login-> usuario no validado ");
                return NULL;

            }
            
           
            }
        }  
        catch(PDOException $e){
            error_log('LoginModel::login->exception '.$e);
        }
    }
}

?>