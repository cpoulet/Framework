<?php

namespace App\Controllers;

class Posts extends \Core\Controller {

    protected function before() {
    }

    protected function after() {
    }

    function indexAction() {
        echo 'Posts -> index()';
    }

    function addNewAction() {
        echo 'Posts -> addNew()';
    }

    function editAction() {
        echo 'Posts -> edit()';
        echo '<pre>';
        var_dump($this->_route_params);
        echo '</pre>';
    }
}

?>
