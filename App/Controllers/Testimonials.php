<?php 

namespace App\Controllers;
use \Core\View;
use App\UploadImages;
use App\Flash;
use App\Models\TestimonialsModel;
use App\Models\ProjectModel;

/**
 * Dashboard controller
 *
 * PHP version 7.0
*/

class Testimonials extends Authenticated
{
    /**
     * Show the Testimonials forms page
     *
     * @return void
     */

    public function newAction()
    {
         
        View::renderTemplate('Admin/Testimonials/newTestimonial.html');
    }

    /**
     * Create testimonials
     *
     * @return void
     */

    public function createAction()
    {
        if(!empty($_POST)){
            /* Validate */
            if (UploadImages::validateImages(false))
            {
                
                /* images array */
                $images = UploadImages::getImage();
                foreach ($images as $image)
                {
                    
                    /* save the image to assets/images folder */
                    UploadImages::saveImage($image["tmp_name"], "assets/images/", $image["name"]);

                    /* save the image to database */
                    $ImageId = ProjectModel::saveImage("/assets/images/", $image["name"], $image["type"],$image["size"]);

                   $createTestimonial = TestimonialsModel::create($_POST,$ImageId);
                    
                }
                if($createTestimonial){
                    Flash::addMessage('Testimonnial added successfully');
                    $this->redirect('/Testimonials/manage');

                }else {
                    Flash::addMessage('Testimonnial error, please try again', Flash::WARNING);
                    $this->redirect('/Testimonials/new');
                }
                
            }
            else /* Show errors array */
            {
                print_r(UploadImages::$error);
            }
        }
    }

    /**
     * Display testimonial managing page
     *
     * @return void
     */
    public function manageAction()
    {
        $testimonials = TestimonialsModel::getAll();
        foreach ($testimonials as $key => $testimonial) {
            $testimonials[$key]->recommendation = $this->strWordCut($testimonial->recommendation,38);
        }
        View::renderTemplate('Admin/Testimonials/manageTestimonial.html', [
            "testimonials" => $testimonials
        ]);
    }
    /**
     * Delete testimonial  
     *
     * @return void
     */
    public function deleteAction()
    {
        if(!empty($_GET)){
            $delTesimonial = TestimonialsModel::deleteOne($_GET['id']);
            if($delTesimonial){
                unlink("./assets/images/".$_GET['image']);
                Flash::addMessage('Testimonnial deleted');
            }else{
                Flash::addMessage('Testimonial is not deleted, please try again', Flash::WARNING);

            }
        }else {
            Flash::addMessage('Parameter is empty, please try again', Flash::WARNING);

        }
        $this->redirect('/Testimonials/manage');


    }
}