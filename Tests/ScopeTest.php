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

use Flaphl\Fridge\Precept\ScopeInterface;
use Flaphl\Fridge\Precept\SoftDeletingScope;
use Flaphl\Fridge\Precept\Query\QueryBuilderInterface;
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    public function testSoftDeletingScopeImplementsScopeInterface(): void
    {
        $scope = new SoftDeletingScope();
        
        $this->assertInstanceOf(ScopeInterface::class, $scope);
    }

    public function testSoftDeletingScopeHasName(): void
    {
        $scope = new SoftDeletingScope();
        
        $this->assertSame('soft_deleting', $scope->getName());
    }

    public function testSoftDeletingScopeApplyMethod(): void
    {
        $scope = new SoftDeletingScope();
        
        // Test that apply method exists and is callable
        $this->assertTrue(method_exists($scope, 'apply'));
        $this->assertTrue(is_callable([$scope, 'apply']));
    }

    public function testSoftDeletingScopeRemoveMethod(): void
    {
        $scope = new SoftDeletingScope();
        
        // Test that remove method exists and is callable
        $this->assertTrue(method_exists($scope, 'remove'));
        $this->assertTrue(is_callable([$scope, 'remove']));
    }
}
