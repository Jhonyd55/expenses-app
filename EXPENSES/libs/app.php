<?php

require_once ('controllers/errores.php');
class App{
function __construct(){
    error_log("---- igresa a App ----");   
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim((string)$url,'/');
    $url = explode('/',$url);
    // url original https://localhost/expense/index.php
    // convienrta   expense/index.php
    error_log('APP::construct -> url '. implode($url));
    if(empty($url[0])){// si la url no existe redirija a login
        error_log('APP::construct -> no hay constrolador especificado');
        $archivoController = 'controllers/login.php';
        require_once $archivoController;
        $controller = new Login();
        $controller -> loadModel('login');
        $controller->render();
        return false;

    }
    $archivoController = 'controllers/' .$url[0].  '.php';

    if(file_exists($archivoController)){
        require_once ($archivoController);

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        if(isset($url[1])){
            if(method_exists($controller, $url[1])){
                if(isset($url[2])){
                    $nparam = count($url)-2;
                    $params = [];

                    for($i=0; $i<$nparam; $i++){
                        error_log('APP::construct -> para el delete '. $url[$i+2]);
                        array_push($params,$url[$i+2]);
                    }
                    $controller->{$url[1]}($params);
                }
                else{$controller->{$url[1]}();
            }

            }else{
                // error 404 :: esa pagina no existe
                $controller = new Errores();

            }

        } else{
            $controller->render();

        }
    }else {
        // error 404 :: esa pagina no existe
        error_log("App:: -------pagina no existe ---");   
        $controller = new Errores();
    }
}
}
?>