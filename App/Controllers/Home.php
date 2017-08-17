<?php

namespace App\Controllers;

class Home extends \Core\Controller {

    protected function before() {
        echo '(before)';
        return False;
    }

    protected function after() {
        echo '(after)';
    }

    function indexAction() {
        echo 'Home -> index()';
    }

}

?>
