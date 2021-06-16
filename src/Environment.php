<?php

declare(strict_types=1);

namespace Hurtcode\Config;;

/**
 * Application environment
 *
 * Defines current application environment. Environment has to
 * be set only once. After that this class provides global access
 * to current environment by `current()` method.
 *
 * Instance on Environment provides methods to compare current
 * environment with another.
 *
 * @package Hurtcode\Config;
 */
final class Environment
{
    /**
     * Name of environment
     *
     * @var string
     */
    private string $value;
    /**
     * Current application environment
     *
     * By default is common
     *
     * @var Environment
     */
    private static Environment $current;

    /**
     * Environment constructor
     *
     * @param string $env
     *
     * @throws \Exception
     */
    private function __construct(string $env)
    {
        $this->value = $env;
    }

    /**
     * Checks current environment
     *
     * Compares given environment with current
     *
     * @param string $environment
     *
     * @return bool
     */
    public function is(string $environment): bool
    {
        return $this->value === $environment;
    }

    /**
     * Gets environment string
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Defines application's environment
     *
     * Environment sets only once time.
     *
     * @param string $env
     * Environment to be set
     *
     * @throws \Exception
     */
    public static function define(string $env): void
    {
        if (isset(self::$current)) {
            return;
        }
        $env = new self($env);
        self::$current = $env;
    }

    /**
     * Gets current environment
     *
     * @return Environment
     *
     * @throws \Exception
     */
    public static function current(): Environment
    {
        if (!isset(self::$current)) {
            throw new \Exception("Environment wasn't set up");
        }
        return self::$current;
    }
}