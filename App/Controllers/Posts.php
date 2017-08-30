<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;

class Posts extends \Core\Controller {

    protected function before() {
    }

    protected function after() {
    }

    function indexAction() {
        $posts = Post::getAll();
        View::renderTemplate('Posts/index.html', ['name' => 'post index', 'posts' => $posts]);
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
