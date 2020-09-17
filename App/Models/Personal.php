<?php 

namespace App\Models;

use PDO;
use \Core\View;

class Personal extends \Core\Model
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
     * Find a personal information 
     *
     * @return mixed User object if found, false otherwise
     */
    public static function personalInfo()
    {
        $sql = 'SELECT * FROM personal p JOIN media m on p.image = m.id LIMIT 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}


?>