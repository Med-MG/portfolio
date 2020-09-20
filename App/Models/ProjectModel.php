<?php 

namespace App\Models;

use PDO;
use \Core\View;

class ProjectModel extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    /**
     * Fetch all categories
     *
     * @return array return categories table data
     */
    public static function getcategories()
    {
        try {

        $sql = 'SELECT * FROM categories';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }

    /**
     * Fetch all projects
     *
     * @return array return categories table data
     */
    public static function  getProject()
    {
        try {

        $sql = "SELECT pr.*, cat.cat_name FROM project pr join categories cat on pr.category = cat.id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }
    /**
     * Fetch one project data
     *
     * @return array return categories table data
     */
    public static function  getoneProject($id)
    {
        try {

        $sql = "SELECT pr.*, cat.id as cat_id, cat_name FROM project pr join categories cat on pr.category = cat.id WHERE pr.id = ?";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }
    /**
     * Fetch one project images
     *
     * @return array return categories table data
     */
    public static function  getimagesProject($id)
    {
        try {
        $sql = "SELECT m.* FROM joinporfoliotable jp join project pr on jp.project = pr.id join media m on jp.image = m.id WHERE jp.project = ?";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
         
        } catch (PDOException $e) {
            echo 'query failed' . $e->getMessage();
        }
    }
    /**
     * Fetch all projects
     *
     * @return bool true if project, false otherwise
     */
    public static function  deleteProject($id)
    {
        try {
        $sql = "DELETE FROM `project` WHERE `project`.`id` = ?";

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

    /**
     * Delete project image from media an join table
     *
     * @return bool true if image deleted, false otherwise
     */
    public static function  deleteImage($id)
    {
        try {
        $sql = "DELETE m, jp FROM media m LEFT JOIN joinporfoliotable jp on m.id = jp.image WHERE m.id = ?";

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

    /**
     * Update project data 
     *
     * @return bool true if project updated, false otherwise
     */
    public static function updateData($data){
        try {
            $sql = "UPDATE `project` SET `title` = ?, `description` = ?, `order_date` = ?, `final_date` = ?, `location` = ?,`Client` = ?, `link` = ?, `category` = ? WHERE `project`.`id` = ?";
    
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([trim($_POST['title']), trim($_POST['description']), trim($_POST['order_date']), trim($_POST['final_date']), trim($_POST['location']), trim($_POST['Client']), trim($_POST['projectlink']), trim($_POST['category']), $_POST['projectId']]);
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
     * Insert Project details
     *
     * array of data to insert in the project table
     *
     * @return mixed User object if found, false otherwise
     */
    public static function save()
    {
        try {
            
        if(!empty($_GET)){
            $title = trim($_GET['title']);
            $description = trim($_GET['description']);
            $order_date = trim($_GET['order_date']);
            $final_date = trim($_GET['final_date']);
            $location = trim($_GET['location']);
            $Client = trim($_GET['Client']);
            $link =trim($_GET['projectlink']);
            $category = trim($_GET['category']);
            $sql = "INSERT INTO `project` (`title`, `description`, `order_date`, `final_date`, `location`,`Client`, `link`, `category` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([$title, $description, $order_date, $final_date, $location,$Client, $link, $category]);
            if($stmt->rowCount() > 0){
                return $db->lastInsertId();
            }else{
                return false;
            }
            
            
            
        }else{
            throw new \Exception("There is no paramaters");
        }
        } catch (PDOException $e) {
            echo 'query failed' . $e->getMessage();
        }

    }

    /**
     * Insert Project details
     *
     * @param integer Id of the latest added project
     * @param integer Id of the latest added image
     * @return bool returns true if data inserted false if otherwise
     */

    public static function joinImagesProject($projId, $Imageid){
        try {
            $sql = "INSERT INTO `joinporfoliotable` (`id`, `project`, `image`) VALUES (NULL, ?, ?);";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([$projId, $Imageid]);
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
     * Insert Project details
     *
     * @param string location of the image
     * @param string name of image
     * @param string Type of the image
     * @param string size of the image
     * @return integer returns the last inserted id
     */
    public static function saveImage($location, $name, $type, $size)
    {
        $location = $location . $name;
        $sql = "INSERT INTO `media` (`id`, `file_name`, `file_type`, `file_size`, `file_location`, `media_type`, `thumbnail`, `timestamp`) VALUES (NULL, ?, ?, ?, ?, 'image', ?, CURRENT_TIMESTAMP)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$name,$type,$size,$location,$location]);
        
        return $db->lastInsertId();
    }


    /**
     * Fetch all projects
     *
     * @return array return categories table data
     */
    public static function  fetchProjects()
    {
        try {

        $sql = "SELECT pr.*, m.file_location, cat.cat_name,cat.slug FROM project pr LEFT join joinporfoliotable jp on pr.id = jp.project LEFT join media m on jp.image = m.id LEFT JOIN categories cat on pr.category = cat.id GROUP BY pr.id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

        } catch (PDOException $e) {
                    echo 'query failed' . $e->getMessage();
        }
    }

    //** Section for handling categories */

    /**
     * Add new category to database
     *
     * @return array return categories table data
     */
    public static function addCategory($data){
        try {

            $sql = "INSERT INTO `categories` (`id`, `cat_name`, `slug`, `timestamp`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP)";
    
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([$data['cat_title'],$data['cat_slug']]);
    
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
    public static function delCategory($data){
        try {
            $db = static::getDB();
            $sql="UPDATE `project` SET `category` = '7' WHERE `project`.`category` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$data['id']]);

            $sql = "DELETE FROM `categories` WHERE `categories`.`id` = ?";
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
    public static function updateCategorydata($data){
        try {
            $db = static::getDB();
            $sql="UPDATE `categories` SET `cat_name` = ?, `slug` = ? WHERE `categories`.`id` = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$data['cat_title'], $data['cat_slug'], $data['cat_id']]);

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


?>