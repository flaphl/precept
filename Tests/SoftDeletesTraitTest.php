<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests;

use Flaphl\Fridge\Precept\SoftDeletes;
use Flaphl\Fridge\Precept\ScopeInterface;
use PHPUnit\Framework\TestCase;

class SoftDeletesTraitTest extends TestCase
{
    private function createMockEntity(): object
    {
        return new class {
            use SoftDeletes;
            
            private ?string $deleted_at = null;
            
            protected function getTable(): string
            {
                return 'users';
            }
            
            public function delete(): bool
            {
                if (!$this->forceDeleting) {
                    $this->deleted_at = date('Y-m-d H:i:s');
                } else {
                    $this->deleted_at = null;
                }
                return true;
            }
            
            protected static function addGlobalScope(ScopeInterface $scope): void
            {
                // Mock implementation
            }
        };
    }

    public function testGetDeletedAtColumn(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertSame('deleted_at', $entity->getDeletedAtColumn());
    }

    public function testGetQualifiedDeletedAtColumn(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertSame('users.deleted_at', $entity->getQualifiedDeletedAtColumn());
    }

    public function testTrashedReturnsFalseWhenNotDeleted(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertFalse($entity->trashed());
    }

    public function testTrashedReturnsTrueWhenDeleted(): void
    {
        $entity = $this->createMockEntity();
        $entity->delete();
        
        $this->assertTrue($entity->trashed());
    }

    public function testIsForceDeleting(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertFalse($entity->isForceDeleting());
    }

    public function testRestoreReturnsFalseWhenNotTrashed(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertFalse($entity->restore());
    }

    public function testRestoreReturnsTrueWhenTrashed(): void
    {
        $entity = $this->createMockEntity();
        $entity->delete();
        
        $this->assertTrue($entity->restore());
        $this->assertFalse($entity->trashed());
    }

    public function testBootSoftDeletesExists(): void
    {
        $entity = $this->createMockEntity();
        
        $this->assertTrue(method_exists($entity, 'bootSoftDeletes'));
    }
}
