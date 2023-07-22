<?php
class Login extends SessionController
{
    public $model;
    function __construct()
    {
        parent::__construct();
        error_log("---- Inicio de login ----");
    }

    function render()
    {
        error_log("login::render -> carga view de login.");
        $this->view->render('login/index');
    }

    function authenticate()
    {
        if ($this->existPOST(['username', 'password'])) {

            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if ($username == '' || empty($username) || $password == '' || empty($password)) {
                
                error_log("login::authenticate--> usuario y contraseña vacios " .ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY);
                $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
            }else{
                error_log("login::authenticate--> datos a autenticar " .$username." ".$password);
                $this->model = new LoginModel();
                $user = $this->model->login($username,$password);
                if($user != NULL){
                    $this->initialize($user);
                }else{
                    $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
                }
            }
        }else{
            $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE]);
        }
    }
}
