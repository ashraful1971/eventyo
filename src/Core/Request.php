<?php

namespace App\Core;

class Request {
    private static $instance;
    private $attributes = [];
    private $method;

    /**
     * Constructor to init the props
     */
    public function __construct()
    {
        $this->method = isset($_POST) && isset($_POST['_method']) ? $_POST['_method'] : strtoupper($_SERVER['REQUEST_METHOD']);
        $this->attributes = array_merge($this->attributes, $_POST, $_GET);
    }

    public static function create()
    {
        if(!self::$instance){
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Access the attributes like property
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if($name === 'user'){
            return Auth::user();
        }

        if(isset($_POST) && isset($_POST[$name])){
            return $_POST[$name];
        }
        
        if(isset($_GET) && isset($_GET[$name])){
            return $_GET[$name];
        }
        
        if(isset($this->attributes[$name])){
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Set attributes
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get the request method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
    
    /**
     * Get the Request URI
     *
     * @return string
     */
    public function getURI(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $base = str_replace("\\", '/', $base);
        if($base !== '/'){
            $uri = substr($uri, strlen($base));
        }

        return $uri;
    }
    
    /**
     * Get the route path/endpoint
     *
     * @return string
     */
    public function getRoutePath(): string
    {
        $path = parse_url(self::getURI())['path'];
        return $path == '/' ? $path : rtrim($path, '/');
    }
    
    /**
     * Get all the request attributes
     *
     * @return array
     */
    public function all(): array
    {
        $data = $this->attributes;

        if(isset($data['_method'])){
            unset($data['_method']);
        }

        if(isset($data['user'])){
            unset($data['user']);
        }

        return $data;
    }
}