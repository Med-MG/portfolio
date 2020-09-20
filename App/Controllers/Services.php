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

class Services extends Authenticated
{
    /**
     * Show Services forms page
     *
     * @return void
     */

     public function newAction(){
        $services = ServicesModel::getServices();
        foreach ($services as $key => $service) {
            $services[$key]->description = $this->strWordCut($service->description,38);
        }
        View::renderTemplate('Admin/services/manageservice.html', [
            "services" => $services
        ]);
     }
    /**
     * Show Services forms page
     *
     * @return void
     */

     public function addServiceAction(){
        
        if(!empty($_POST)){
            $addService = ServicesModel::addService($_POST);        
        }else{
            echo json_encode(['code'=>400, 'msg'=>"No data sent"]);
        }
        if($addService){
            echo json_encode(['code'=>200, 'msg'=>"service added successfully"]);
        }else{
            echo json_encode(['code'=>400, 'msg'=>"cannot add service due to an error"]);
        }
     }

     /**
     * Detele service action
     *
     * @return void
    */
    public function deleteServiceAction()
    {
        if(!empty($_POST)){
            $deleteService = ServicesModel::delService($_POST);        
        }else{
            echo json_encode(['code'=>400, 'msg'=>"No data sent"]);
        }

        if($deleteService){
            echo json_encode(['code'=>200, 'msg'=>"Service Deleted successfully"]);
        }else{
            echo json_encode(['code'=>400, 'msg'=>"cannot delete Service due to an error"]);
        }
    }

    /**
     * Update service data
     *
     * @return void
    */
    public function updateServiceAction()
    {
        if(!empty($_POST)){
            $updateService = ServicesModel::updateServicedata($_POST);        
        }else{
            echo json_encode(['code'=>400, 'msg'=>"No data sent"]);
        }

        if($updateService){
            echo json_encode(['code'=>200, 'msg'=>"Service Updated successfully"]);
        }else{
            echo json_encode(['code'=>400, 'msg'=>"cannot update Service due to an error"]);
        }
    }

}