<?php

namespace Ahmedmi;

class Router
{
    /**
     * @var array The property that stores all routes 
     */
    protected array $routes = array();

    protected string $uri;

    protected string $method;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * stores a get route in the $routes array
     *
     * @param string   $pattern the route pattern 
     * @param callable $fn The handling function to be executed
     */
    public function get(string $pattern, callable $fn)
    {
        $this->addRoute('GET', $pattern, $fn);
    }

    public function post(string $pattern, callable $fn)
    {
        $this->addRoute('POST', $pattern, $fn);
    }

    private function addRoute(string $method, string $pattern, callable $fn)
    {
        $this->routes[$method][$pattern] = $fn;
    }

    /**
     * runs the router to match uri and handle the routes
     */
    public function run()
    {
        // loop through the routes (now there is only get)
        // run handle on each ["/route" => $fn]
        // no parameters binding yet
        if (key_exists($this->method, $this->routes)) {
            foreach ($this->routes[$this->method] as $pattern => $fn) {
                $this->handle($pattern, $fn);
            }
        }
    }

    private function handle(string $pattern, callable $fn)
    {
        if ($this->uri === $pattern) {
            call_user_func($fn);
        }
    }
}
