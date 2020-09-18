<?php 

namespace App\Controllers;
use \Core\View;
use App\Models\Admin;
use App\Auth;
use \App\Flash;

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

            Flash::addMessage('Login successful');

            $this->redirect(Auth::getReturnToPage());
            
        }else {
            Flash::addMessage('Login unsuccessful, please try again', Flash::WARNING);

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

        $this->redirect('/login');
    }

        /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroyAction) the session is destroyed
     * so a new action needs to be called in order to use the session.
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {
        Flash::addMessage('Logout successful');

        $this->redirect('/');
    }
}


?>