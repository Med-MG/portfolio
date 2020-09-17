<?php 

namespace App\Controllers;
use \Core\View;
use App\Models\Admin;
/**
 * Home controller
 *
 * PHP version 7.0
 */


class Login extends \Core\Controller
{


    /**
     * Show the Dashboard page
     *
     * @return void
     */

    public function newAction()
    {
        View::renderTemplate('Admin/login.html');
    }
    
     /**
     * Authenticate the admin in login page
     *
     * @return void
     */

    public function createAction()
    {
        // echo $_REQUEST['email'] . " " . $_REQUEST['password'];
        $admin = Admin::authenticate($_POST['email'], $_POST['password']);
        if($admin){
            header('Location: http://'.$_SERVER['HTTP_HOST'] . '/', true, 303);
            exit;
        }else {
            View::renderTemplate('Admin/login.html');
        }
    }
}


?>