<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Personal;
use \App\Models\ServicesModel;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html', [
            "services" => ServicesModel::getServices()
        ]);
    }
    /**
     * Show the index page
     *
     * @return mixed User object if found, false otherwise 
     */
    public static function getPersonalInfo()
    {
        return Personal::personalInfo();
    }
}