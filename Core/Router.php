<?php

namespace Core;

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

    function dispatch($url) {
        $url = $this->_removeQuery($url);
        if ($this->match($url)) {
            $controller = $this->_params['controller'];
            $controller = $this->_toStudlyCaps($controller);
            $controller = $this->_getNamespace() . $controller;
            if (class_exists($controller)) {
                $controller_obj = new $controller($this->getParams());
                $action = $this->_params['action'];
                $action = $this->_toCamelCase($action);
                if (is_callable([$controller_obj, $action]))
                    $controller_obj->$action();
                else
                    throw new \Exception("Method $action from $controller does not exist.");
            }
            else
                throw new \Exception("Controller class $controller does not exist.");
        }
        else
            throw new \Exception("The url $url goes nowhere.", 404);
    }

    protected function _getNamespace() {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->getParams()))
            $namespace .= $this->_params['namespace'] . '\\';
        return $namespace;
    }

    protected function _removeQuery($url) {
        if ($url != '') {
            $split = explode('&', $url, 2);
            if (strpos($split[0], '=') === False)
                $url = $split[0];
            else
                $url = '';
        }
        return $url;
    }

    private function _toStudlyCaps($s) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $s)));
    }

    private function _toCamelCase($s) {
        return lcfirst($this->_toStudlyCaps($s));
    }
}

?>
