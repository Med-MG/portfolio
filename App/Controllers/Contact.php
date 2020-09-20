<?php

namespace App\Controllers;

use \Core\View;
use App\Flash;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Contact extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function showAction()
    {       

        View::renderTemplate('Contact/contact.html');
    }
    /**
     * Sending email function
     *
     * @return void
     */
    public function sendemailAction()
    {       
        if(!empty($_POST)){
            
        }
        echo json_encode(["code" => 200, 'msg'=>"email sent successfully"]);
       
    }

}