<?php

namespace App\Core;

use App\Core\Contracts\ServiceContainer;
use Exception;
use ReflectionClass;

class Container implements ServiceContainer
{

    private static $instance;
    private $bindings = [];
    private $singleton = [];
    private $resolved = [];

    /**
     * Get the instance of the container
     * 
     * @return Container
     */
    public static function init(): Container
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Bind an interface to a concrete class
     * 
     * @param string $interface
     * @param string|callable $concrete
     * @return void
     */
    public function bind(string $interface, string|callable $concrete = null): void
    {
        $this->bindings[$interface] = $concrete ?? $interface;
    }

    /**
     * Bind a singleton instance to an interface
     * 
     * @param string $interface
     * @param string|callable $concrete
     */
    public function singleton(string $interface, string|callable $concrete = null): void
    {
        $this->singleton[$interface] = $concrete ?? $interface;
    }

    /**
     * Make an instance of a class
     * 
     * @param string $interface
     * @return object
     * @throws Exception
     */
    public function make(string $interface): object
    {
        if (isset($this->resolved[$interface])) {
            return $this->resolved[$interface];
        }

        return $this->resolve($interface);
    }

    /**
     * Resolve the instance of a class
     * 
     * @param string $interface
     * @return object
     * @throws Exception
     */
    private function resolve(string $interface): object
    {
        if (!$interface) {
            throw new Exception('This can not be resolved!');
        }

        $isSingleton = $this->isSingleton($interface);

        $concrete = $this->singleton[$interface] ?? $this->bindings[$interface] ?? $interface;

        if (is_callable($concrete)) {
            return $this->resolvedInstance($interface, $concrete(), $isSingleton);
        }

        if (!class_exists($concrete)) {
            throw new Exception($concrete . ' can not be resolved!');
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception($concrete . ' can not be resolved!');
        }

        $dependencies = $reflector->getConstructor()?->getParameters();

        if (!$dependencies) {
            return $this->resolvedInstance($interface, new $concrete(), $isSingleton);
        }

        $dependencyInstances = $this->resolveDependencies($dependencies);

        $instance = $reflector->newInstanceArgs($dependencyInstances);

        return $this->resolvedInstance($interface, $instance, $isSingleton);
    }

    /**
     * Resolve the dependencies of a class
     * 
     * @param array $dependencies
     * @return array
     */
    private function resolveDependencies(array $dependencies): array
    {
        $instances = [];
        foreach ($dependencies as $dependency) {
            $instances[] = $this->resolve($dependency?->getType()?->getName());
        }

        return $instances;
    }

    /**
     * Check if the interface is a singleton
     * 
     * @param string $interface
     * @return bool
     */
    private function isSingleton(string $interface): bool
    {
        return isset($this->singleton[$interface]);
    }

    /**
     * Store the resolved instance
     * 
     * @param string $interface
     * @param object $instance
     * @param bool $isSingleton
     * @return object
     */
    private function resolvedInstance(string $interface, object $instance, bool $isSingleton = false): object
    {
        if ($isSingleton) {
            $this->resolved[$interface] = $instance;
        }
        return $instance;
    }
}
