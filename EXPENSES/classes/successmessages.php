<?php

class SuccessMessages{
    const SUCCESS_ADMIN_NEWCATEGORY_EXISTS = "success1";
    const SUCCESS_SIGNUP_NEWUSER = "success2";

    private $successList = [];
    public function __construct(){
        $this->successList=[
            SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY_EXISTS => 'Nueva categoria exitosa',
            SuccessMessages::SUCCESS_SIGNUP_NEWUSER => 'Registro de usuario existoso.'
        ];
    }

    public function get($hash){
        return $this->successList[$hash];
    }
    
    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }
        else{
            return false;
        }
    }
}

?>