<?php
class User extends SessionController
{
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
    }

    function render()
    {
        $this->view->render('user/index', [
            'user' => $this->user
        ]);
    }

    function updateBudget()
    {
        if (!$this->existPOST(['budget'])) {
            $this->redirect('user', []); //TODO:
            return;
        }
        $budget = $this->getPost('budget');

        if ($budget == 0 || empty($budget) || $budget < 0) {
            $this->redirect('user', []); //TODO:
            return;
        }

        $this->user->setBudget($budget);
        if ($this->user->update()) {
            $this->redirect('user', []); //TODO:
        }
    }

    function updateName()
    {

        if (!$this->existPOST(['name'])) {
            error_log("USER::updateName--> el parametro name no existe " );
            $this->redirect('user', []); //TODO:
            return;
        }
        $name = $this->getPost('name');

        if ($name == NULL || empty($name)) {
            $this->redirect('user', []); //TODO:
            return;
        }

        $this->user->setName($name);
        if ($this->user->update()) {
            $this->redirect('user', []); //TODO:
        }
    }

    function updatePassword()
    {
        if (!$this->existPOST(['current_password', 'new_password'])) {
            $this->redirect('user', []); //TODO:
            return;
        }

        $current = $this->getPost('current_password');
        $new = $this->getPost('new_password');

        if ($current === $new) {
            $this->redirect('user', []); //TODO:
            return;
        }

        $newHash = $this->model->comparePasswords($current, $this->user->getId());
        if ($newHash) {
            error_log("User::updatePassword--> nueva contraseña (" . $new.")");
            $this->user->setPassword($new);
            if ($this->user->update()) {
                $this->redirect('user', []); //TODO:
                return;
            } else {
                $this->redirect('user', []); //TODO:
                return;
            }
        } else {
            $this->redirect('user', []); //TODO:
            return;
        }
    }

    function updatePhoto()
    {
        if (!isset($_FILES['photo'])) {
            $this->redirect('user', []); //TODO:
            return;
        }

        $photo = $_FILES['photo'];
        $targetDir = 'public/img/photos/';
        $extension = explode('.', $photo['name']);
        $filename = $extension[sizeof($extension) - 2];
        $ext = $extension[sizeof($extension) - 1];
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $targetFile = $targetDir . $hash;
        $uploadOk = false;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($photo['tmp_name']);
        if ($check !== false) {
            $uploadOk =  true;
        } else {
            $uploadOk =  false;
        }
        if (!$uploadOk) {
            $this->redirect('user', []); //TODO:
            return;
        } else {
            if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
                $this->user->setPhoto($hash);
                $this->user->update();
                $this->redirect('user', []); //TODO:
                return;
            } else {
                $this->redirect('user', []); //TODO:
                return;
            }
        }
    }
}
