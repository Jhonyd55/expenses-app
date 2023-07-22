<?php

class ErrorMessages{
    public const ERROR_ADMIN_NEWCATEGORY_EXISTS = "AdminNewCategoryExists";
    public const ERROR_SIGNUP_NEWUSER = "errorSignupNewUser";
    public const ERROR_SIGNUP_NEWUSER_EMPTY = "errorSignupNewUserEmpty";
    public const ERROR_SIGNUP_NEWUSER_EXIST = "errorSignupNewUserExist";
    public const ERROR_LOGIN_AUTHENTICATE_EMPTY = "errorLoginAuthenticateEmpty";
    public const ERROR_LOGIN_AUTHENTICATE = "errorLoginAuthenticate";
    public const ERROR_LOGIN_AUTHENTICATE_DATA = "errorLoginAuthenticateData";

    private $errorList = [];
    public function __construct(){
        $this->errorList = [ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS => 'la categoria ya existe',
                            ErrorMessages::ERROR_SIGNUP_NEWUSER => 'Hubo un error al procesar esta solicitud',
                            ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY => 'Ingresa usuario y contraseña.',
                            ErrorMessages::ERROR_SIGNUP_NEWUSER_EXIST => 'Este nombre de usuario ya existe.',
                            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY => 'Ingresa usuario y contraseña.',
                            ErrorMessages::ERROR_LOGIN_AUTHENTICATE => 'Error de usuario y contraseña',
                            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA => 'El usuario y/o contraseña no son correctos'];
    }

    public function get($hash){
        return $this->errorList[$hash];
    }
    
    public function existsKey($key){
        if(array_key_exists($key, $this->errorList)){
            return true;
        }
        else{
            return false;
        }
    }
}

?>