<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache;

/**
 * Cache configuration interface.
 */
interface CacheConfigurationInterface
{
    /**
     * Get result cache configuration.
     *
     * @return array<string, mixed> Result cache config
     */
    public function getResultCacheConfig(): array;

    /**
     * Get metadata cache configuration.
     *
     * @return array<string, mixed> Metadata cache config
     */
    public function getMetadataCacheConfig(): array;

    /**
     * Get query cache configuration.
     *
     * @return array<string, mixed> Query cache config
     */
    public function getQueryCacheConfig(): array;

    /**
     * Check if result caching is enabled.
     *
     * @return bool True if enabled
     */
    public function isResultCacheEnabled(): bool;

    /**
     * Check if metadata caching is enabled.
     *
     * @return bool True if enabled
     */
    public function isMetadataCacheEnabled(): bool;

    /**
     * Check if query caching is enabled.
     *
     * @return bool True if enabled
     */
    public function isQueryCacheEnabled(): bool;

    /**
     * Get default cache lifetime.
     *
     * @return int|null Lifetime in seconds or null for no expiry
     */
    public function getDefaultLifetime(): ?int;

    /**
     * Get cache key prefix.
     *
     * @return string The prefix
     */
    public function getCachePrefix(): string;

    /**
     * Enable or disable result caching.
     *
     * @param bool $enabled Whether to enable
     *
     * @return void
     */
    public function setResultCacheEnabled(bool $enabled): void;

    /**
     * Enable or disable metadata caching.
     *
     * @param bool $enabled Whether to enable
     *
     * @return void
     */
    public function setMetadataCacheEnabled(bool $enabled): void;

    /**
     * Set default cache lifetime.
     *
     * @param int|null $lifetime Lifetime in seconds
     *
     * @return void
     */
    public function setDefaultLifetime(?int $lifetime): void;
}
