<?php 

namespace App\Controllers;
use \Core\View;
use App\Flash;
use App\Models\ServicesModel;
/**
 * Dashboard controller
 *
 * PHP version 7.0
*/

class Project extends Authenticated
{
    /**
     * Show Services forms page
     *
     * @return void
     */

     public function newAction(){
        View::renderTemplate('Admin/services/newservice.html');
     }

}