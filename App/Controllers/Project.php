<?php 

namespace App\Controllers;
use \Core\View;
use App\UploadImages;
use App\Flash;
use App\Models\ProjectModel;
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
        $cat = ProjectModel::getcategories();
        View::renderTemplate('Admin/newproject.html', [
            "categories" => $cat
        ]);
    }


    /**
     * Upload project images
     *
     * @return void
    */

    public function uploadAction()
    {      
        $project = ProjectModel::save();
        if($project !== false){
            if (UploadImages::countImages() > 0)
            {
                    $validator;
                    /* Validate */
                    if (UploadImages::validateImages())
                    {
                        
                        /* images array */
                        $images = UploadImages::getImages();
                        foreach ($images as $image)
                        {
                            
                            /* save the image to assets/images folder */
                            UploadImages::saveImage($image["tmp_name"], "assets/images/", $image["name"]);

                            /* save the image to database */
                            $ImageId = ProjectModel::saveImage("assets/images/", $image["name"], $image["type"],$image["size"]);

                            /*  joined table image and project */
                            $validator = ProjectModel::joinImagesProject($project, $ImageId);
                            
                        }
                        if($validator){
                            print("<script>toastr.success('project added', 'success')</script>");
                        }else {
                            print("<script>toastr.error('project not added', 'error')</script>");
                        }

                    }
                    else /* Show errors array */
                    {
                        print_r(UploadImages::$error);
                    }
    
            }
            else
            {
                throw new \Exception("images required");
            }
        } else {
            throw new \Exception("project is not added value is". $project);
        }

    }

    public function managecategoriesAction(){
        $proj = ProjectModel::getProject();
        View::renderTemplate('Admin/managecategories.html', [
            "project" => $proj
        ]);
    }
    

}