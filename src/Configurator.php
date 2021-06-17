<?php

declare(strict_types=1);

namespace Hurtcode\Config;

use Psr\Cache\{CacheItemPoolInterface, InvalidArgumentException};

/**
 * Application configurator
 *
 * @package Hurtcode\Config;
 */
final class Configurator
{
    /** Key for compiled configuration item */
    private const CACHE = 'config_cache_item';

    private ConfigInterface $configs;
    private CompilerInterface $compiler;
    private CacheItemPoolInterface $cacheItemPool;
    /**
     * Helps to locate configurator
     * part from other point of program
     *
     * @var Configurator|null
     */
    public static ?Configurator $locator;

    /**
     * Configurator constructor
     *
     * @param ConfigInterface $configs
     * @param CompilerInterface $compiler
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function __construct(
        ConfigInterface $configs,
        CompilerInterface $compiler,
        CacheItemPoolInterface $cacheItemPool,
    )
    {
        $this->configs = $configs;
        $this->compiler = $compiler;
        $this->cacheItemPool = $cacheItemPool;
        self::$locator = $this;
    }

    /**
     * Gets configs
     *
     * @return ConfigInterface
     */
    public function config(): ConfigInterface
    {
        return $this->configs;
    }

    /**
     * Gets compiler
     *
     * @return CompilerInterface
     */
    public function compiler(): CompilerInterface
    {
        return $this->compiler;
    }

    /**
     * Runs config compilation
     *
     * @param bool $forcedRebuild
     * If true rebuilds configuration every new run
     *
     * @return array
     *
     * @throws ConfigureException
     */
    public function run(bool $forcedRebuild = false): array
    {
        $out = $this->getFromCache($forcedRebuild);
        if (isset($out))
            return $out;

        $out = $this->compiler->compile($this->configs->main());
        if (!$forcedRebuild)
            $this->saveInCache($out);

        $this->freeMem();
        return $out;
    }

    /**
     * Gets configuration from cache
     *
     * @param bool $forcedRebuild
     *
     * @return array|null
     *
     * @throws ConfigureException
     */
    private function getFromCache(bool $forcedRebuild = false): ?array
    {
        try {
            $cacheItem = $this->cacheItemPool->getItem(self::CACHE);
            if ($cacheItem->isHit() && !$forcedRebuild) {
                return $cacheItem->get();
            }
        } catch (InvalidArgumentException $e) {
            throw new ConfigureException($e->getMessage(), $e->getCode(), $e);
        }
        return null;
    }

    /**
     * Saves out configuration cache
     *
     * @param array $configuration
     *
     * @throws ConfigureException
     */
    private function saveInCache(array $configuration): void
    {
        try {
            $cacheItem = $this->cacheItemPool->getItem(self::CACHE);
            $cacheItem->set($configuration);
            $this->cacheItemPool->save($cacheItem);
        } catch (InvalidArgumentException $e) {
            throw new ConfigureException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Free memory
     */
    private function freeMem(): void
    {
        self::$locator = null;
    }
}