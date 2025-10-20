<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Logging;

/**
 * Chain multiple cache loggers together.
 */
class CacheLoggerChain implements CacheLogger
{
    /** @var CacheLogger[] */
    private array $loggers = [];

    public function __construct(array $loggers = [])
    {
        foreach ($loggers as $logger) {
            $this->addLogger($logger);
        }
    }

    public function addLogger(CacheLogger $logger): void
    {
        $this->loggers[] = $logger;
    }

    public function logCacheHit(string $region, string $key): void
    {
        foreach ($this->loggers as $logger) {
            $logger->logCacheHit($region, $key);
        }
    }

    public function logCacheMiss(string $region, string $key): void
    {
        foreach ($this->loggers as $logger) {
            $logger->logCacheMiss($region, $key);
        }
    }

    public function logCachePut(string $region, string $key, mixed $value): void
    {
        foreach ($this->loggers as $logger) {
            $logger->logCachePut($region, $key, $value);
        }
    }

    public function logCacheEviction(string $region, string $key): void
    {
        foreach ($this->loggers as $logger) {
            $logger->logCacheEviction($region, $key);
        }
    }

    public function logCacheClear(string $region): void
    {
        foreach ($this->loggers as $logger) {
            $logger->logCacheClear($region);
        }
    }
}
