<?php
namespace Lib;

/**
 * Route.
 */
class Router {

    private static array $routes = [];

    public static function get($route, $callback) {
        //delete /
        $route = trim($route, "/");
        self::$routes['GET'][$route] = $callback;
    }

    public static function post($route, $callback) {
        $route = trim($route, "/");        
        self::$routes['POST'][$route] = $callback;
    }

    public static function dispatch() {
        $uri = $_SERVER["REQUEST_URI"];
        $uri = trim($uri, "/");
        if(strpos($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }

        $methodReq = $_SERVER["REQUEST_METHOD"];

        foreach(self::$routes[$methodReq] as $route => $callback) {
            //podria evaluar si es true
            if(strpos($route, ":") !== false) {
                //replace route
                $route = preg_replace("#:[a-zA-Z]+#", "([a-zA-Z0-9]+)", $route);
            }            

            if(preg_match("#^$route$#", $uri, $matches)) {
                $params = array_slice($matches, 1);
                //echo json_encode($params);
                
                if(is_callable($callback)) {
                    $response = $callback(...$params);
                }
                if(is_array($callback)) {
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$params);
                }
                
                if(is_array($response) || is_object($response)) {
                    header("Content-Type:application/json");
                    echo json_encode($response);
                } else {
                    echo $response;
                }
                
                return;
            }            
        }

        echo "<br> 400 Not found";
    }
}

?>