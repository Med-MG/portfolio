<?php 

namespace App\Models;

use PDO;
use \Core\View;

class Contact extends \Core\Model
{


        /**
     * Find a personal information 
     *
     * @return mixed User object if found, false otherwise
     */
    public static function sendemail()
    {
        $sql = 'SELECT * FROM personal p JOIN media m on p.image = m.id LIMIT 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}


?>