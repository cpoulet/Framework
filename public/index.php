<?php
require '../Core/Router.php';

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
#$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{action}/{controller}');


$url = $_SERVER['QUERY_STRING'];

echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
}
else {
    echo '404 sa mere !';
}
?>
