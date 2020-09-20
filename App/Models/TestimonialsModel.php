<?php 

namespace App\Models;

use PDO;
use \Core\View;

class TestimonialsModel extends \Core\Model
{

     /**
     * Fetch all testimonial details
     *
     * @return array Testimonials 
     */
    public static function getAll(){
        try {
            $sql = "SELECT t.*, m.file_name,m.file_location FROM testimonials t LEFT JOIN media m on t.image = m.id";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll();
        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }
    /**
     * Insert Testimonia details
     *
     * @return bool true if Testimonial added, false otherwise
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

    /**
     * Delete testimonial
     *
     * @return bool true if deleted, false otherwise
     */
    public static function  deleteOne($id)
    {
        try {
        $sql = "DELETE t, m FROM testimonials t LEFT join media m on t.image = m.id WHERE t.id =  ?";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
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