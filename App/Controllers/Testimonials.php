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
            $testimonials[$key]->timestamp = date("F jS, Y", strtotime($testimonial->timestamp));
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

    /**
     * Display Editing  page
     *
     * @return void
     */
    public function editAction()
    {
        if(!empty($_GET)){
            $testimonial = TestimonialsModel::getOne($_GET['id']);
        }else {
            Flash::addMessage('Parameter is empty, please try again', Flash::WARNING);
            $this->redirect('/Testimonials/manage');

        }
        
        View::renderTemplate('Admin/Testimonials/newTestimonial.html', [
            "testimonial" => $testimonial
        ]);
    }

    /**
     * UpdateCreate testimonials
     *
     * @return void
     */

    public function updateAction()
    {
        $msg="";
        if(!empty($_POST)){
            if(!empty($_FILES['files']['name'])){
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

                        $updateTestimonial = TestimonialsModel::Update($_POST,$ImageId);
                        if(TestimonialsModel::delImage($_POST['imageid'])){
                            if(!unlink("./assets/images/".$_POST['imageName'])){
                                $msg = "image not found on the server";
                            }
                            
                        }
                        
                        
                    }


                    
                }
                else /* Show errors array */
                {
                    print_r(UploadImages::$error);
                }
            } else{
                $updateTestimonial = TestimonialsModel::Update($_POST,$_POST['imageid']);

            }

        }

        if($updateTestimonial){
            Flash::addMessage('Testimonnial updated  successfully'. $msg);

        }else {
            Flash::addMessage('Testimonnial error, please try again' . $msg, Flash::WARNING);
            
        }
        $this->redirect('/Testimonials/manage');
    }
}