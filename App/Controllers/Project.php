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
        if(isset($_GET['idEdit'])){
            $project = $_GET['idEdit'];
            $msg = "Image added succefully";
        } else{
            $project = ProjectModel::save();
            $msg = "Project added succefully";

        }
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
                            $ImageId = ProjectModel::saveImage("/assets/images/", $image["name"], $image["type"],$image["size"]);

                            /*  joined table image and project */
                            $validator = ProjectModel::joinImagesProject($project, $ImageId);
                            
                        }
                        if($validator){
                            print("<script>toastr.success('{$msg}', 'success');</script>");
                        }else {
                            print("<script>toastr.error('Try again later', 'error');</script>");
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

    /**
     * Delete a specific Project Image
     *
     * @return void
    */
    public function deleteProjectImageAction()
    {
        if(isset($_POST['imageId'])){
            
            if(!unlink("./assets/images/".$_POST['imageName'])){
                echo json_encode(['code'=>400, 'msg'=>"cannot delete image due to an error"]);
            }else {
                echo json_encode(['code'=>200, 'msg'=>"image has been deleted successfully"]);
            }
            $deleted = ProjectModel::deleteImage($_POST['imageId']);
                // $old = getcwd() . DIRECTORY_SEPARATOR . "assets/images/".$_POST['imageName']; 
                // echo json_encode(['code'=>200, 'msg'=> $old]);

        }else {
            throw new \Exception("There is no Image Id");
        }
    }

    /**
     * Display project to be managed
     *
     * @return void
    */
    public function manageAction()
    {
        $proj = ProjectModel::getProject();
        foreach ($proj as $key => $project) {
            $proj[$key]->order_date = date("F jS, Y, g:i a", strtotime($project->order_date));
            $proj[$key]->final_date = date("F jS, Y, g:i a", strtotime($project->final_date));
        }
        View::renderTemplate('Admin/manageproject.html', [
            "projects" => $proj
        ]);
    }
    /**
     * Delete a project from database
     *
     * @return void
    */
    public function deleteAction()
    {

        if(ProjectModel::deleteProject($_GET['id'])){
            Flash::addMessage('project deleted successful');
        }else{
            Flash::addMessage('Delete unsuccessful, please try again', Flash::WARNING);
        }

        $this->manageAction();
    }

    /**
     * Get the editing page
     *
     * @return void
    */
    public function editAction()
    {
        $proj = ProjectModel::getoneProject($_GET['id']);
        $projectImages = ProjectModel::getimagesProject($_GET['id']);
        $cat = ProjectModel::getcategories();
        View::renderTemplate('Admin/editproject.html', [
            "categories" => $cat,
            "project" => $proj,
            "images" => $projectImages
        ]);
 
    }

    /**
     * Fetch and display project data to be updated
     *
     * @return void
    */

    public function updateAction()
    {
        $proj = ProjectModel::getoneProject($_GET['id']);
        $projectImages = ProjectModel::getimagesProject($_GET['id']);
        $cat = ProjectModel::getcategories();
        View::renderTemplate('Admin/editproject.html', [
            "categories" => $cat,
            "project" => $proj,
            "images" => $projectImages
        ]);
 
    }

    /**
     * Update project data in database
     *
     * @return void
    */
    public function updateProjectdataAction()
    {
        $dataupdated = ProjectModel::updateData($_POST);
        if($dataupdated){
            echo json_encode(['code'=>200, 'msg'=>"project updated successfully"]);
 
        } else {
            echo json_encode(['code'=>400, 'msg'=>"cannot update project due to an error"]);
        }
        

        
    }

    /**
     * Display form for managing categories
     *
     * @return void
    */
    public function managecategoriesAction()
    {
        $cat = ProjectModel::getcategories();        
        View::renderTemplate('Admin/managecategories.html', [
            "categories" => $cat
        ]);
    }
    /**
     * Add a new category
     *
     * @return void
    */
    public function addCategoryAction()
    {
        if(!empty($_POST)){
            $addcat = ProjectModel::addCategory($_POST);        

        }else{
            echo json_encode(['code'=>400, 'msg'=>"No data sent"]);

        }
        if($addcat){
            echo json_encode(['code'=>200, 'msg'=>"category added successfully"]);

        }else{
            echo json_encode(['code'=>400, 'msg'=>"cannot add category due to an error"]);

        }
    }
}