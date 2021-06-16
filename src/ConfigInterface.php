<?php

declare(strict_types=1);

namespace Hurtcode\Config;;

/**
 * Config interface
 *
 * Describes config resources. Provides access configuration directory and main
 * file (compilation enter point)
 *
 * @package Hurtcode\Config;
 */
interface ConfigInterface
{
    /**
     * Returns path
     * for configuration directory
     *
     * @return string
     */
    public function dir(): string;

    /**
     * Gets main file (enter point) content.
     *
     * @return string
     *
     * @throws ConfigureException
     * Throws exception if something gone
     * wrong while reading file
     */
    public function main(): string;

    /**
     * Gets sub config files content. Finds file relative of
     * base configuration directory.
     *
     * @param string $path
     *
     * @return string
     *
     * @throws ConfigureException
     * Throws exception if something gone
     * wrong while reading file
     */
    public function sub(string $path): string;
}