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

   /** 
    * Routing  
    */
    $router = new Core\Router();

    //Add the routes
    $router->add('', ['controller' => 'Home', 'action' => 'index']);
    $router->add('{controller}/{action}');
    
    $router->dispatch($_SERVER['QUERY_STRING']);

