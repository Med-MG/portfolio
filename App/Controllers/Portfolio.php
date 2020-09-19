<?php

namespace App\Controllers;

use \Core\View;
use App\Flash;
use App\Models\ProjectModel;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Portfolio extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function showAction()
    {
        $projects = ProjectModel::fetchProjects();
        $cat = ProjectModel::getcategories();        

        View::renderTemplate('Portfolio/portfolio.html', [
            "projects" => $projects,
            "categories" => $cat
        ]);
    }

}