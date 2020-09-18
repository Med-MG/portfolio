<?php 

namespace App\Controllers;
use \Core\View;
use App\UploadImages;

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

    /**
     * Upload project images
     *
     * @return void
    */

    public function uploadAction()
    {        


        /* Images are required */
        if (UploadImages::countImages() > 0)
        {
                /* Validate */
                if (UploadImages::validateImages())
                {
                    print("<h3 class='text-info'>IMAGES</h3>");
                    /* images array */
                    $images = UploadImages::getImages();
                    foreach ($images as $image)
                    {
                        /* save the image */
                        if (UploadImages::saveImage($image["tmp_name"], "assets/images/", $image["name"]))
                        {
                            print ("<p class='text-success'>· <strong>" . $image["name"] . "</strong> saved in images folder</p>");
                            

                        }
                        else
                        {
                            print("<p class='text-danger'>· " . $image["name"] . " error to saved</p>");
                        }
                    }
                    /* GET EXTRA PARAMETERS */
                    print("<h3 class='text-info'>EXTRA PARAMETERS</h3>");
                    print_r(UploadImages::getParams());
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
    }

    

}