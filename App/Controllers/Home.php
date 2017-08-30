<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller {

    protected function before() {
        #echo '(before)';
        #return False;
    }

    protected function after() {
        #echo '(after)';
    }

    function indexAction() {
        View::renderTemplate('Home/index.html', ['name' => 'home/index', 'colours' => ['red', 'green', 'blue'], 'path' => dirname(__DIR__)]);
    }

}

?>
