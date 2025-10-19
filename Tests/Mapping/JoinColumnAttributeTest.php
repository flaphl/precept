<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Mapping;

use Flaphl\Fridge\Precept\Mapping\JoinColumn;
use PHPUnit\Framework\TestCase;

class JoinColumnAttributeTest extends TestCase
{
    public function testJoinColumnWithName(): void
    {
        $joinColumn = new JoinColumn(name: 'user_id');
        
        $this->assertSame('user_id', $joinColumn->name);
        $this->assertSame('id', $joinColumn->referencedColumnName);
        $this->assertTrue($joinColumn->nullable);
        $this->assertFalse($joinColumn->unique);
    }

    public function testJoinColumnWithReferencedColumnName(): void
    {
        $joinColumn = new JoinColumn(
            name: 'category_id',
            referencedColumnName: 'id'
        );
        
        $this->assertSame('category_id', $joinColumn->name);
        $this->assertSame('id', $joinColumn->referencedColumnName);
    }

    public function testJoinColumnNotNullable(): void
    {
        $joinColumn = new JoinColumn(
            name: 'author_id',
            nullable: false
        );
        
        $this->assertSame('author_id', $joinColumn->name);
        $this->assertFalse($joinColumn->nullable);
    }

    public function testJoinColumnUnique(): void
    {
        $joinColumn = new JoinColumn(
            name: 'profile_id',
            unique: true
        );
        
        $this->assertSame('profile_id', $joinColumn->name);
        $this->assertTrue($joinColumn->unique);
    }

    public function testJoinColumnWithOnDelete(): void
    {
        $joinColumn = new JoinColumn(
            name: 'post_id',
            onDelete: 'CASCADE'
        );
        
        $this->assertSame('post_id', $joinColumn->name);
        $this->assertSame('CASCADE', $joinColumn->onDelete);
    }

    public function testJoinColumnAllParameters(): void
    {
        $joinColumn = new JoinColumn(
            name: 'parent_id',
            referencedColumnName: 'id',
            nullable: false,
            unique: false,
            onDelete: 'SET NULL'
        );
        
        $this->assertSame('parent_id', $joinColumn->name);
        $this->assertSame('id', $joinColumn->referencedColumnName);
        $this->assertFalse($joinColumn->nullable);
        $this->assertFalse($joinColumn->unique);
        $this->assertSame('SET NULL', $joinColumn->onDelete);
    }
}
