<?php 

namespace App\Controllers;
use \Core\View;

/**
 * Dashboard controller
 *
 * PHP version 7.0
*/

class Project extends Authenticated
{

    /**
     * Show the project forms page
     *
     * @return void
     */

    public function newAction()
    {
        View::renderTemplate('Admin/newproject.html');
    }

}