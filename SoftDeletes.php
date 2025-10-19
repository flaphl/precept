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

/**
 * Trait for soft delete functionality.
 * 
 * Entities using this trait won't be physically deleted from the database.
 * Instead, a deleted_at timestamp is set. Soft-deleted entities are automatically
 * excluded from queries unless explicitly requested.
 */
trait SoftDeletes
{
    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    protected string $deletedAtColumn = 'deleted_at';

    /**
     * Indicates if the entity is currently force deleting.
     *
     * @var bool
     */
    protected bool $forceDeleting = false;

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getDeletedAtColumn(): string
    {
        return $this->deletedAtColumn;
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn(): string
    {
        return $this->getTable() . '.' . $this->getDeletedAtColumn();
    }

    /**
     * Determine if the entity instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed(): bool
    {
        return $this->{$this->getDeletedAtColumn()} !== null;
    }

    /**
     * Force a hard delete on a soft deleted entity.
     *
     * @return bool
     */
    public function forceDelete(): bool
    {
        $this->forceDeleting = true;

        try {
            return $this->delete();
        } finally {
            $this->forceDeleting = false;
        }
    }

    /**
     * Determine if the entity is force deleting.
     *
     * @return bool
     */
    public function isForceDeleting(): bool
    {
        return $this->forceDeleting;
    }

    /**
     * Restore a soft-deleted entity.
     *
     * @return bool
     */
    public function restore(): bool
    {
        if (!$this->trashed()) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = null;

        return true;
    }

    /**
     * Boot the soft deleting trait for an entity.
     * 
     * Registers the SoftDeletingScope as a global scope.
     *
     * @return void
     */
    public static function bootSoftDeletes(): void
    {
        static::addGlobalScope(new SoftDeletingScope());
    }

    /**
     * Get the table name for the entity.
     * 
     * This method should be implemented by the entity class.
     *
     * @return string
     */
    abstract protected function getTable(): string;

    /**
     * Perform the delete operation.
     * 
     * This method should be implemented by the entity class.
     *
     * @return bool
     */
    abstract protected function delete(): bool;

    /**
     * Add a global scope to the entity.
     * 
     * This method should be implemented by the entity class.
     *
     * @param ScopeInterface $scope The scope to add
     *
     * @return void
     */
    abstract protected static function addGlobalScope(ScopeInterface $scope): void;
}
