<?php 

namespace App\Controllers;
use \Core\View;
use App\Models\Admin;

/**
 * Dashboard controller
 *
 * PHP version 7.0
*/


class Dashboard extends Authenticated
{


    /**
     * Show the Dashboard page
     *
     * @return void
     */

    public function indexAction()
    {
        View::renderTemplate('Admin/dashboard.html');
    }
    

}


?>