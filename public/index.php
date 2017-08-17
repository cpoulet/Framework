<?php

spl_autoload_register(function ($class) {
    $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file))
        require $file;
});

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{action}/{controller}');

$url = $_SERVER['QUERY_STRING'];

$router->dispatch($url);

?>
