<?php

namespace Ahmedmi;

class Router
{
    /**
     * @var array The property that stores all routes 
     */
    protected array $routes = array();

    protected string $uri;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
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
        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $pattern => $fn) {
                $this->handle($pattern, $fn);
            }
        }
    }

    private function handle(string $pattern,callable $fn)
    {
        if ($this->uri === $pattern) {
            call_user_func($fn);
        }
    }
}
