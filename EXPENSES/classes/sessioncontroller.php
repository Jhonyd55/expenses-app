<?php
class SessionController extends Controller{
 private $userSession;
 private $username;
 private $userid;
 
 private $session;
 private $sites;
 private $defaultSites;
 private $user;

 function __construct(){
    parent::__construct();
    $this->init();
 }

 function init(){
    $this->session = new Session();
    $json = $this->getJSONFileConfig();
    $this->sites = $json['sites'];
    $this->defaultSites = $json['default-sites'];

    $this->validateSession();
}

 private function getJSONFileConfig(){
    $string = file_get_contents('config/access.json');
    $json = json_decode($string, true);

    return $json;
 }
 public function validateSession(){
    error_log('Sessioncontroller::validateSession -> validando usuario');
    
    if($this->existsSession()){
        $role = $this->getUserSessionData()->getRole();
        error_log('Sessioncontroller::validateSession -> role = '.$role);

        //si la pagina es publica entrar;
        if($this->isPublic()){
            $this->redirectDefaultSiteByRole($role);
        }else{
            if($this->isAuthorized($role)){
                //lo dejo pasar
            }else{
                $this->redirectDefaultSiteByRole($role);
            }
            
        }
        
    }else{
        //no existe session
        if($this->isPublic()){
           //no pasa nada
        }else{
            header('Location: '.constant('URL').'');
            }

        }
}

function existsSession(){
    if(!$this->session->exists()){
        return false;
    }
    if($this->session->getCurrentUser()== NULL){
        return false;
    }
    $userid = $this->session->getCurrentUser();

    if($userid) return true;
    
    return false;
}

function getUserSessionData(){
    $id = $this->session->getCurrentUser();
    $this->user = new UserModel();
    $this->user->get($id);
    error_log('SESSIONCONTROLLER::getUserSessionData -> '.$this->user->getUsername());
    return $this->user;
}
 function isPublic(){ // me regresa si la pagina es publica
    $currentURL = $this->getCurrentPage();
    $currentURL = preg_replace("/\?.*/","",$currentURL);

    for($i = 0;$i < sizeof($this->sites); $i++){
        if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public'){
            return true;
        }
    }
    return false;
 }

 function redirectDefaultSiteByRole($role){
    $url = '';
    for($i = 0;$i < sizeof($this->sites); $i++){
        if($this->sites[$i]['role'] == $role){
            $url = $this->sites[$i]['site'];// redicrecciona
            break;
        }
    }
    error_log('SESSIONCONTROLLER::redirectDefaultSiteByRole -> '.$role." ".$url);
    
    header('location:'.constant('URL').$url);
 }

 function isAuthorized($role){ // me regresa si la pagina es publica
    $currentURL = $this->getCurrentPage();
    $currentURL = preg_replace("/\?.*/","",$currentURL);

    for($i = 0;$i < sizeof($this->sites); $i++){
        if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role){
            return true;
        }
    }
    return false;
 }

 function getCurrentPage(){
    $actualLink = trim("$_SERVER[REQUEST_URI]");
    $url = explode('/',$actualLink); 
    error_log('SESSIONCONTROLLER::getCurrentPage -> '.$url[2]);
    return $url[2];
 }
function initialize($user){
    $this->session->setCurrentUser($user->getId());
    $this->authorizeAccess($user->getRole());
}

 function authorizeAccess($role){
    switch($role){
        case 'user':
            $this->redirect($this->defaultSites['user'],[]);
            break;
        case 'admin':
            $this->redirect($this->defaultSites['admin'],[]);
            break;
    }
 }

 function logout(){
    $this->session->closeSession();
 }


}
?>