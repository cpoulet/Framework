<?php

class Router {

    protected $_routes = [];
    protected $_params = [];

    function getRoutes() { return $this->_routes; }
    function getParams() { return $this->_params; }

    function add($route, $params = []) {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->_routes[$route] = $params;
    }

    function match($url) {
        foreach($this->getRoutes() as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $params = [];
                foreach($matches as $key => $value) {
                    if (is_string($key))
                        $params[$key] = $value;
                }
                $this->_params = $params;
                return True;
            }
        }
        return False;
    }

}

?>
