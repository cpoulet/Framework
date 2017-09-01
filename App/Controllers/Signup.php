<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Signup extends \Core\Controller {

    protected function before() {
        #echo '(before)';
        #return False;
    }

    protected function after() {
        #echo '(after)';
    }

    function newAction() {
        View::renderTemplate('Signup/new.html');
    }

    function createAction() {
        $user = new User($_POST);
        if ($user->save()) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/signup/success', true, 303);
            exit;
        } else {
            View::renderTemplate('Signup/new.html', ['user' => $user]);
        }
    }

    function successAction() {
        View::renderTemplate('Signup/success.html');
    }

}

?>
