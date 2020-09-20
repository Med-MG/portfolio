<?php 

namespace App\Models;

use PDO;
use \Core\View;

class ServicesModel extends \Core\Model
{
    /**
     * Fetch all Services
     *
     * @return array return categories table data
     */
    public static function getServices()
    {
        try {

        $sql = 'SELECT * FROM services';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }

        /**
     * Add new Service to database
     *
     * @return bool return true of added false othewise 
     */
    public static function addService($data){
        try {

            $sql = "INSERT INTO `services` (`id`, `name`, `description`, `timestamp`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP);";
    
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([trim($data['service_title']),trim($data['description'])]);
    
            if($stmt->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
    
            } catch (PDOException $e) {
                        echo 'query failed' . $e->getMessage();
            }
    }

    /**
     * delete category from database
     *
     * @return bool return true if deleted false otherwise
     */
    public static function delService($data){
        try {
            $db = static::getDB();
            $sql = "DELETE FROM `services` WHERE `services`.`id` =  ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$data['id']]);

    
            if($stmt->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
    
            } catch (PDOException $e) {
                        echo 'query failed' . $e->getMessage();
            }
    }

    /**
     * update category 
     * 
     * @return bool return categories table data
     */
    public static function updateServicedata($data){
        try {
            $db = static::getDB();
            $sql="UPDATE `services` SET `name` = ?, `description` = ? WHERE `services`.`id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([trim($data['service_title']),trim($data['description']), $data['service_id']]);

            if($stmt->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
    
            } catch (PDOException $e) {
                        echo 'query failed' . $e->getMessage();
            }
    }

}