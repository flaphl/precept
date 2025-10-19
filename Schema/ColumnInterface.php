<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Schema;

/**
 * Column definition interface.
 */
interface ColumnInterface
{
    /**
     * Get the column name.
     *
     * @return string The name
     */
    public function getName(): string;

    /**
     * Get the column type.
     *
     * @return string The type
     */
    public function getType(): string;

    /**
     * Set the length.
     *
     * @param int $length The length
     *
     * @return self
     */
    public function setLength(int $length): self;

    /**
     * Get the length.
     *
     * @return int|null The length
     */
    public function getLength(): ?int;

    /**
     * Set the precision.
     *
     * @param int $precision The precision
     *
     * @return self
     */
    public function setPrecision(int $precision): self;

    /**
     * Get the precision.
     *
     * @return int|null The precision
     */
    public function getPrecision(): ?int;

    /**
     * Set the scale.
     *
     * @param int $scale The scale
     *
     * @return self
     */
    public function setScale(int $scale): self;

    /**
     * Get the scale.
     *
     * @return int|null The scale
     */
    public function getScale(): ?int;

    /**
     * Set nullable.
     *
     * @param bool $nullable Whether nullable
     *
     * @return self
     */
    public function setNullable(bool $nullable): self;

    /**
     * Check if nullable.
     *
     * @return bool True if nullable
     */
    public function isNullable(): bool;

    /**
     * Set unique.
     *
     * @param bool $unique Whether unique
     *
     * @return self
     */
    public function setUnique(bool $unique): self;

    /**
     * Check if unique.
     *
     * @return bool True if unique
     */
    public function isUnique(): bool;

    /**
     * Set default value.
     *
     * @param mixed $default The default
     *
     * @return self
     */
    public function setDefault(mixed $default): self;

    /**
     * Get default value.
     *
     * @return mixed The default
     */
    public function getDefault(): mixed;

    /**
     * Set auto increment.
     *
     * @param bool $autoIncrement Whether auto increment
     *
     * @return self
     */
    public function setAutoIncrement(bool $autoIncrement): self;

    /**
     * Check if auto increment.
     *
     * @return bool True if auto increment
     */
    public function isAutoIncrement(): bool;
}
