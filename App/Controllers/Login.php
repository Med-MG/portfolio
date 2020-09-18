<?php 

namespace App\Controllers;
use \Core\View;
use App\Models\Admin;
use App\Auth;
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
        $user = Admin::authenticate($_POST['email'], $_POST['password']);
        if($user){
            Auth::login($user);
            $this->redirect('/');
            
        }else {
            View::renderTemplate('Admin/login.html', ["email" => $_POST['email']]);
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }
}


?>