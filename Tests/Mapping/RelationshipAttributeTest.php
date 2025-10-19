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

use Flaphl\Fridge\Precept\Mapping\OneToOne;
use Flaphl\Fridge\Precept\Mapping\ManyToOne;
use Flaphl\Fridge\Precept\Mapping\OneToMany;
use Flaphl\Fridge\Precept\Mapping\ManyToMany;
use Flaphl\Fridge\Precept\Mapping\MorphTo;
use PHPUnit\Framework\TestCase;

class RelationshipAttributeTest extends TestCase
{
    public function testOneToOneAttribute(): void
    {
        $relation = new OneToOne(
            targetEntity: 'App\\Entity\\Profile',
            mappedBy: 'user',
            cascade: ['persist', 'remove']
        );
        
        $this->assertSame('App\\Entity\\Profile', $relation->targetEntity);
        $this->assertSame('user', $relation->mappedBy);
        $this->assertNull($relation->inversedBy);
        $this->assertSame(['persist', 'remove'], $relation->cascade);
        $this->assertSame('LAZY', $relation->fetch);
    }

    public function testManyToOneAttribute(): void
    {
        $relation = new ManyToOne(
            targetEntity: 'App\\Entity\\Category',
            inversedBy: 'products',
            fetch: 'EAGER'
        );
        
        $this->assertSame('App\\Entity\\Category', $relation->targetEntity);
        $this->assertSame('products', $relation->inversedBy);
        $this->assertSame('EAGER', $relation->fetch);
    }

    public function testOneToManyAttribute(): void
    {
        $relation = new OneToMany(
            targetEntity: 'App\\Entity\\Comment',
            mappedBy: 'post',
            cascade: ['persist'],
            orphanRemoval: true
        );
        
        $this->assertSame('App\\Entity\\Comment', $relation->targetEntity);
        $this->assertSame('post', $relation->mappedBy);
        $this->assertSame(['persist'], $relation->cascade);
        $this->assertTrue($relation->orphanRemoval);
    }

    public function testManyToManyAttribute(): void
    {
        $relation = new ManyToMany(
            targetEntity: 'App\\Entity\\Tag',
            mappedBy: 'posts',
            cascade: ['persist']
        );
        
        $this->assertSame('App\\Entity\\Tag', $relation->targetEntity);
        $this->assertSame('posts', $relation->mappedBy);
        $this->assertNull($relation->inversedBy);
        $this->assertSame(['persist'], $relation->cascade);
    }

    public function testMorphToAttribute(): void
    {
        $relation = new MorphTo(
            name: 'commentable',
            type: 'commentable_type',
            id: 'commentable_id'
        );
        
        $this->assertSame('commentable', $relation->name);
        $this->assertSame('commentable_type', $relation->type);
        $this->assertSame('commentable_id', $relation->id);
        $this->assertSame('LAZY', $relation->fetch);
    }

    public function testMorphToAttributeDefaults(): void
    {
        $relation = new MorphTo();
        
        $this->assertNull($relation->name);
        $this->assertNull($relation->type);
        $this->assertNull($relation->id);
        $this->assertSame([], $relation->cascade);
        $this->assertSame('LAZY', $relation->fetch);
    }
}
