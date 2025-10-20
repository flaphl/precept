<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept;

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Query\HydrationMode;
use Flaphl\Fridge\Precept\Query\Parser;
use Flaphl\Fridge\Precept\Query\ParserResult;
use Flaphl\Fridge\Precept\Hydration\HydrationInterface;

/**
 * Abstract base query implementation.
 */
abstract class AbstractQuery
{
    protected array $parameters = [];
    protected HydrationMode $hydrationMode = HydrationMode::OBJECT;
    protected ?Parser $parser = null;
    protected ?ParserResult $parserResult = null;

    public function __construct(
        protected readonly ConnectionInterface $connection,
        protected readonly ?HydrationInterface $hydrator = null
    ) {
        $this->parser = new Parser();
    }

    /**
     * Set a query parameter.
     */
    public function setParameter(string|int $key, mixed $value): static
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Set multiple parameters.
     */
    public function setParameters(array $parameters): static
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    /**
     * Get all parameters.
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Set the hydration mode.
     */
    public function setHydrationMode(HydrationMode $mode): static
    {
        $this->hydrationMode = $mode;

        return $this;
    }

    /**
     * Get the hydration mode.
     */
    public function getHydrationMode(): HydrationMode
    {
        return $this->hydrationMode;
    }

    /**
     * Get the SQL query string.
     */
    abstract public function getSQL(): string;

    /**
     * Execute the query.
     */
    abstract public function execute(): mixed;

    /**
     * Parse the query if not already parsed.
     */
    protected function parseQuery(): ParserResult
    {
        if ($this->parserResult === null) {
            $this->parserResult = $this->parser->parse($this->getSQL(), $this->parameters);
        }

        return $this->parserResult;
    }

    /**
     * Get bound parameters for execution.
     *
     * @return array<int, mixed>
     */
    protected function getBoundParameters(): array
    {
        $result = $this->parseQuery();

        return $this->parser->bindParameters($result, $this->parameters);
    }
}
