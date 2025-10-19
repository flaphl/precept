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

use Flaphl\Fridge\Precept\Mapping\Column;
use PHPUnit\Framework\TestCase;

class ColumnAttributeTest extends TestCase
{
    public function testColumnAttributeDefaults(): void
    {
        $column = new Column();
        
        $this->assertNull($column->name);
        $this->assertNull($column->type);
        $this->assertNull($column->length);
        $this->assertFalse($column->nullable);
        $this->assertFalse($column->unique);
    }

    public function testColumnAttributeWithName(): void
    {
        $column = new Column(name: 'email_address');
        
        $this->assertSame('email_address', $column->name);
    }

    public function testColumnAttributeWithType(): void
    {
        $column = new Column(type: 'integer');
        
        $this->assertSame('integer', $column->type);
    }

    public function testColumnAttributeWithLength(): void
    {
        $column = new Column(type: 'string', length: 255);
        
        $this->assertSame('string', $column->type);
        $this->assertSame(255, $column->length);
    }

    public function testColumnAttributeNotNullable(): void
    {
        $column = new Column(nullable: false);
        
        $this->assertFalse($column->nullable);
    }

    public function testColumnAttributeUnique(): void
    {
        $column = new Column(unique: true);
        
        $this->assertTrue($column->unique);
    }

    public function testColumnAttributeWithDefault(): void
    {
        $column = new Column(
            default: 'active'
        );
        
        $this->assertSame('active', $column->default);
    }

    public function testColumnAttributeAllParameters(): void
    {
        $column = new Column(
            name: 'created_at',
            type: 'datetime',
            nullable: false,
            unique: false,
            default: 'CURRENT_TIMESTAMP'
        );
        
        $this->assertSame('created_at', $column->name);
        $this->assertSame('datetime', $column->type);
        $this->assertFalse($column->nullable);
        $this->assertFalse($column->unique);
        $this->assertSame('CURRENT_TIMESTAMP', $column->default);
    }
}
