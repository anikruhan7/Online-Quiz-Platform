<?php
class Router
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        $pattern = preg_replace('/\{[a-z]+\}/', '([0-9]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        $this->routes[] = ['method' => $method, 'pattern' => $pattern, 'handler' => $handler];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
                if (is_callable($route['handler'])) {
                    echo call_user_func_array($route['handler'], $matches);
                } else {
                    list($controllerName, $action) = explode('@', $route['handler']);
                    require_once "controllers/$controllerName.php";
                    $controller = new $controllerName();
                    echo $controller->$action(...$matches);
                }
                return;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
