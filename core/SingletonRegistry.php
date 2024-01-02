<?php

namespace Core;

/**
 * Efficiently manages shared instances, enabling reuse of a single class instance across scripts.
 */
class SingletonRegistry
{
    /**
     * @var array $instances The registered instances.
     */
    private static array $instances = [];

    /**
     * Registers an instance.
     *
     * @param string $class The name of the class to which the instance belongs.
     * @param mixed $instance The instance to register.
     *
     * @return void
     *
     * @throws \Exception If the name doesn't match an existing class or the instance doesn't belong to the class named
     *                    $class.
     */
    public static function register(string $class, mixed $instance): void
    {
        if (! class_exists($class)) {
            throw new \Exception("The identifier $class does not match an existing class.");
        }

        if (! $instance instanceof $class) {
            throw new \Exception("The instance does not belong to the class identified $class.");
        }

        self::$instances[$class] = $instance;
    }

    /**
     * Returns a registered instance.
     *
     * @param string $class The name of the class to which the registered instance belongs.
     *
     * @return mixed The registered instance.
     */
    public static function get(string $class): mixed
    {
        if (! isset(self::$instances[$class])) {
            throw new \Exception("No instance of the class identified $class is registered.");
        }

        return self::$instances[$class];
    }
}
