<?php
class Controller{
    public $model;
    public $view;// pendiente por revisar
    function __construct(){
        $this->view = new View();
    }

    function loadModel($model){
        $url = 'models/'.$model.'model.php';
        if(file_exists($url)){
            require_once ($url);
            $modelName = $model.'Model';
            $this->model = new $modelName();
        }

    }

    function existPOST($params){ //para cuando resiva parametros para meter a la base dedatos no 
                        // tener que reescribirlos comando de Mysql como Insert o demas
        foreach($params as $param) // si no existe el parametro me rechaze todo
        {
            if(!isset($_POST[$param])){
                error_log('CONTROLLER::existPost -> No existe el parametro '.$param);
                return false;
            }
            return true;
        }
    }

    function exitGET($params){ //para cuando resiva parametros para meter a la base dedatos no 
        // tener que reescribirlos comando de Mysql como Insert o demas
        foreach($params as $param) // si no existe el parametro me rechaze todo
        {
        if(!isset($_GET[$param])){
        error_log('CONTROLLER::existGet -> No existe el parametro '.$param);
        return false;
        }
        return true;
            }       
        }


    function getGet($name){ 
        return $_GET[$name];
    }

    function getPost($name){ 
        return $_POST[$name];
    }

    function redirect($route, $mensajes){ /// funcion para que redirija la pagina y me muestre un mensaje de exito
        $data =  [];  
        $params ='';
        $string_version = implode(',', $mensajes);
        error_log('CONTROLLER::redirect -> mensaje recibido '.$string_version);
        foreach($mensajes as $key =>$mensaje){
            array_push($data, $key . '='.$mensaje);
        }
        $params = join('&',$data);
        //?nombre=jhony&apellido=Duran
        if($params != ''){
            $params = '?'.$params;
        }
        
        //header('Location: '.constant('URL').'/'.$route.$params);
        header('Location: '.constant('URL').$route.$params);

    }
}

?>