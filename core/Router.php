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
                list($ctrl, $action) = explode('@', $route['handler']);
                require_once "controllers/$ctrl.php";
                $obj = new $ctrl();
                echo $obj->$action(...$matches);
                return;
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
