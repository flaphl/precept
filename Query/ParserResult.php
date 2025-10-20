<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Query;

/**
 * Result of parsing a query.
 * Contains the parsed SQL and parameter mappings.
 */
class ParserResult
{
    /** @var array<string, int|string> */
    private array $parameterMappings = [];

    public function __construct(
        private readonly string $sql,
        private readonly array $parameters = []
    ) {
    }

    /**
     * Get the parsed SQL string.
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * Get the parameters.
     *
     * @return array<string|int, mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Add a parameter mapping.
     */
    public function addParameterMapping(string $name, int|string $position): void
    {
        $this->parameterMappings[$name] = $position;
    }

    /**
     * Get parameter mappings.
     *
     * @return array<string, int|string>
     */
    public function getParameterMappings(): array
    {
        return $this->parameterMappings;
    }

    /**
     * Check if a parameter exists.
     */
    public function hasParameter(string|int $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }
}
