<?php
//  codigo para que escriba los error_log en archivo php-error.log
//----------------------------------------------------//
    error_reporting(E_ALL);
    ini_set('ignore_repeated_errors', TRUE);
    ini_set('display_errors',FALSE);
    ini_set('log_errors',TRUE);
    ini_set('error_log',"php-error.log");
    error_log("ingresa a EXPENSES/index.php .....!");
//----------------------------------------------------//
// ----- invocando configuracion inicial db-----//
require_once ('libs/database.php');

require_once ('classes/errormessages.php');
require_once ('classes/successmessages.php');
require_once 'libs/controller.php';
require_once ('classes/session.php');
require_once ('classes/sessioncontroller.php');
require_once ('libs/model.php');
require_once ('libs/imodel.php');
require_once ('libs/view.php');
require_once ('libs/app.php');
require_once('models/loginmodel.php');
require_once('models/usermodel.php');



require_once 'config/config.php';
require_once ('controllers/errores.php');
require_once ('controllers/expenses.php');

$app = new App();
?>