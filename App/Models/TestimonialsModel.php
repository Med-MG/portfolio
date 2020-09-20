<?php 

namespace App\Models;

use PDO;
use \Core\View;

class TestimonialsModel extends \Core\Model
{
        /**
     * Insert Project details
     *
     * array of data to insert in the project table
     *
     * @return mixed User object if found, false otherwise
     */
    public static function create($data, $imgId)
    {
        try {
            $name = trim($data['full_name']);
            $occupation = trim($data['occupation']);
            $description = trim($data['description']);
            
            $sql = "INSERT INTO `testimonials` (`id`, `full_name`, `occupation`, `recommendation`, `timestamp`, `image`) VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP, ?)";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([$name, $occupation, $description, $imgId]);
            if($stmt->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        } catch (PDOException $e) {
            echo 'query failed' . $e->getMessage();
        }

    }
}