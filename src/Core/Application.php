<?php

namespace App\Core;

use App\Core\Contracts\ServiceContainer;
use App\Core\Request;

class Application
{
    private static $app;
    private RouteCollection $routes;
    private $request;
    private $container;
    private $providers = [];

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Initialize the application by creating the instance
     *
     * @param ServiceContainer $container
     * @return Application
     */
    public static function init(ServiceContainer $container): Application
    {
        if (!self::$app) {
            self::$app = new self($container);
        }

        return self::$app;
    }

    /**
     * Run the application once everything is ready
     *
     * @param Request $request
     * @return void
     */
    public function run(Request $request): void
    {
        $this->request = $request;

        $this->registerProviders();
        $this->handleRequest();
    }

    /**
     * Register all the service providers
     *
     * @return void
     */
    private function registerProviders(): void
    {
        foreach($this->providers as $provider){
            $instance = $this->container->make($provider);
            $instance->register($this->container);
        }
    }

    /**
     * Includes the application routes
     *
     * @param RouteCollection $routes
     * @return Application
     */
    public function withRoutes(RouteCollection $routes): Application
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * Include the providers
     *
     * @param array $providers
     * @return Application
     */
    public function withProviders(array $providers): Application
    {
        $this->providers = $providers;
        return $this;
    }

    /**
     * Handle the incoming request
     *
     * @return void
     */
    private function handleRequest(): void
    {
        $method = $this->request->getMethod();
        $endpoint = $this->request->getRoutePath();
        $route = $this->findRoute($method, $endpoint);

        if(!$route){
            Response::redirect('/404');
        }

        $middlewares = $route->getMiddlewares();
        
        if($middlewares){
            $this->applyMiddlewares($middlewares);
        }

        $this->resolveAction($route->getAction(), $route->getParams());
    }

    /**
     * Find the route of the request
     *
     * @param string $method
     * @param string $endpoint
     * @return Route|null
     */
    private function findRoute(string $method, string $endpoint): Route|null
    {
        // dd([$method, $endpoint]);
        return $this->routes->find($method, $endpoint);
    }
    
    /**
     * Apply specified middleware to the request
     *
     * @param array $middlewares
     * @return void
     */
    private function applyMiddlewares(array $middlewares): void
    {
        foreach($middlewares as $middleware){
            $middleware::handle($this->request);
        }
    }

    /**
     * Resolve the action
     *
     * @param callable|array $action
     * @return void
     */
    private function resolveAction(callable|array $action, array $params=[]): void
    {
        if (is_callable($action)) {
            $action($this->request, ...$params);
        }

        elseif (is_array($action)) {
            $obj = $this->container->make($action[0]);
            $obj->{$action[1]}($this->request, ...$params);
        }
    }
}
