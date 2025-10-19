<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Connection;

/**
 * Prepared statement interface.
 */
interface StatementInterface
{
    /**
     * Bind a value to a parameter.
     *
     * @param string|int $param The parameter identifier
     * @param mixed $value The value to bind
     * @param int|null $type The parameter type
     *
     * @return self
     */
    public function bindValue(string|int $param, mixed $value, ?int $type = null): self;

    /**
     * Bind a parameter reference.
     *
     * @param string|int $param The parameter identifier
     * @param mixed $variable The variable to bind
     * @param int|null $type The parameter type
     *
     * @return self
     */
    public function bindParam(string|int $param, mixed &$variable, ?int $type = null): self;

    /**
     * Execute the prepared statement.
     *
     * @param array<mixed>|null $params Optional parameters
     *
     * @return ResultInterface The result
     */
    public function execute(?array $params = null): ResultInterface;

    /**
     * Get the SQL string.
     *
     * @return string The SQL
     */
    public function getSql(): string;
}
