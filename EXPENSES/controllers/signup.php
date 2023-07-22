<?php
/// validador de usuario
class Signup extends SessionController
{

    function __construct()
    {
        parent::__construct();
        error_log('Signup::construct -> ');
    }

    function render()
    {
        $this->view->render('login/signup', []);
    }

    function newUser()
    {
        if ($this->existPOST(['username', 'password'])) {
            
                $username = $this->getPost('username');
                $password = $this->getPost('password');

                if ($username == '' || empty($username) || $password == '' || empty($password)) {
                    $string_version = implode(',', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
                    error_log("Signup::newUser--> usuario y contraseña vacios " . $string_version);
                    $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
                } else {
                    $user = new UserModel();
                    $user->setUsername($username);
                    $user->setPassword($password);
                    $user->setRole('user');

                    if ($user->exists($username)) {
                        $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXIST]);
                    } elseif ($user->save()) {
                        $this->redirect('', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
                    } else {
                        $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
                    }
                }
            
        } else {
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
        }
    }
}
