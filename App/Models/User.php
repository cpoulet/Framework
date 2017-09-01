<?php

namespace App\Models;

use PDO;

class User extends \Core\Model {

    public $errors = [];

    function __construct($data) {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }

    protected function emailExists($email) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch() !== False;
    }

    function save() {

        $this->validate();

        if (empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $db = static::getDB();
            $stmt = $db->prepare('INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)');
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            return $stmt->execute();
        }
        return False;
    }

    function validate() {
        if ($this->name == '')
            $this->errors[] = 'Name is required';

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === False)
            $this->errors[] = 'Invalid email';

        if ($this->emailExists($this->email))
            $this->errors[] = 'Email already registered.';

        if ($this->password != $this->password_confirmation)
            $this->errors[] = 'Password confirmation does not match.';

        if (strlen($this->password) < 6)
            $this->errors[] = 'Password must be at least 6 characters long.';

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0)
            $this->errors[] = 'Password needs at least one letter.';

        if (preg_match('/.*\d+.*/i', $this->password) == 0)
            $this->errors[] = 'Password needs at least one number.';
    }

}

?>
