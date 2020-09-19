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
        $sql = 'SELECT * FROM categories';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

    }

    /**
     * Fetch all projects
     *
     * @return array return categories table data
     */
    public static function  getProject()
    {
        $sql = "SELECT pr.*, cat.cat_name FROM project pr join categories cat on pr.category = cat.id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

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
            $title = $_GET['title'];
            $description = $_GET['description'];
            $order_date = $_GET['order_date'];
            $final_date = $_GET['final_date'];
            $location = $_GET['location'];
            $link = $_GET['projectlink'];
            $category = $_GET['category'];
            $sql = "INSERT INTO `project` (`title`, `description`, `order_date`, `final_date`, `location`, `link`, `category` ) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute([$title, $description, $order_date, $final_date, $location, $link, $category]);
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



    

}


?>