<?php

declare(strict_types=1);

namespace Hurtcode\Config;

/**
 * Compiler interface
 *
 * Compiler provides method to convert input
 * configuration content in one array.
 *
 * @package Hurtcode\Config;
 */
interface CompilerInterface
{
    /**
     * Compiles raw string data
     *
     * @param string $data
     * This is content string of configuration file.
     *
     * @return mixed
     *
     * @throws ConfigureException
     */
    public function compile(string $data): array;
}