<?php

namespace App\Core;

class RouteCollection
{
    private $routes;

    /**
     * Constructor
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Find a route by method and endpoint
     *
     * @param string $method
     * @param string $endpoint
     * @return Route|null
     */
    public function find(string $method, string $endpoint): Route|null
    {
        foreach ($this->routes[$method] as $route) {
            $pattern = $route->getEndpoint();
            $pattern = preg_replace('/\{[^}]+\}/', '([a-zA-Z0-9-_]+)', $pattern);
            if (preg_match("#^$pattern$#", $endpoint, $matches)) {
                array_shift($matches);
                $route->setParams($matches);
                return $route;
            }
        }

        return null;
    }
}
