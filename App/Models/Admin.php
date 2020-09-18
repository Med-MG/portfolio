<?php 

namespace App\Models;

use PDO;
use \Core\View;

class Admin extends \Core\Model
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
    public function validate() {
        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }
    }

        /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM admin WHERE email = ?';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public static function authenticate($email, $password){
        $user = static::findByEmail($email);

        if($user){
            if(password_verify($password, $user->password) ){
                return $user;
            }
        }
        return false;
    }

        /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $sql = 'SELECT * FROM admin WHERE id = ?';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}


?>