<?php 

/** 
 * @Author: Mohamed Mouiguina 
 * @Date: 2020-09-15 19:32:46 
 * @file:  Front Controller
 * @PHP: version 7.3.5
 */

 /** 
  * composer
  */

    require dirname(__DIR__) . '/vendor/autoload.php';

  /**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();

/** 
* Routing  
*/
$router = new Core\Router();

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);

$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);

