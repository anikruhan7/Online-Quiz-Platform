<?php
class Router
{
    private $routes = [];
<<<<<<< HEAD

=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    public function add($method, $path, $handler)
    {
        $pattern = preg_replace('/\{[a-z]+\}/', '([0-9]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[] = ['method' => $method, 'pattern' => $pattern, 'handler' => $handler];
    }
<<<<<<< HEAD

=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
<<<<<<< HEAD
                if (is_callable($route['handler'])) {
                    echo call_user_func_array($route['handler'], $matches);
                } else {
                    list($controllerName, $action) = explode('@', $route['handler']);
                    require_once "controllers/$controllerName.php";
                    $controller = new $controllerName();
                    echo $controller->$action(...$matches);
                }
=======
                list($ctrl, $action) = explode('@', $route['handler']);
                require_once "controllers/$ctrl.php";
                $obj = new $ctrl();
                echo $obj->$action(...$matches);
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
                return;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
