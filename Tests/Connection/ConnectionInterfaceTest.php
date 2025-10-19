<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Connection;

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Connection\ResultInterface;
use Flaphl\Fridge\Precept\Connection\StatementInterface;
use Flaphl\Fridge\Precept\Connection\PlatformInterface;
use PHPUnit\Framework\TestCase;

class ConnectionInterfaceTest extends TestCase
{
    public function testConnectionInterfaceHasQueryMethods(): void
    {
        $reflection = new \ReflectionClass(ConnectionInterface::class);
        
        $this->assertTrue($reflection->hasMethod('query'));
        $this->assertTrue($reflection->hasMethod('execute'));
        $this->assertTrue($reflection->hasMethod('prepare'));
    }

    public function testConnectionInterfaceHasTransactionMethods(): void
    {
        $reflection = new \ReflectionClass(ConnectionInterface::class);
        
        $this->assertTrue($reflection->hasMethod('beginTransaction'));
        $this->assertTrue($reflection->hasMethod('commit'));
        $this->assertTrue($reflection->hasMethod('rollback'));
        $this->assertTrue($reflection->hasMethod('inTransaction'));
    }

    public function testConnectionInterfaceHasPlatformAccess(): void
    {
        $reflection = new \ReflectionClass(ConnectionInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getPlatform'));
    }

    public function testResultInterfaceHasResultMethods(): void
    {
        $reflection = new \ReflectionClass(ResultInterface::class);
        
        $this->assertTrue($reflection->hasMethod('fetchAssociative'));
        $this->assertTrue($reflection->hasMethod('fetchAllAssociative'));
        $this->assertTrue($reflection->hasMethod('fetchOne'));
        $this->assertTrue($reflection->hasMethod('rowCount'));
    }

    public function testStatementInterfaceHasExecutionMethods(): void
    {
        $reflection = new \ReflectionClass(StatementInterface::class);
        
        $this->assertTrue($reflection->hasMethod('bindValue'));
        $this->assertTrue($reflection->hasMethod('bindParam'));
        $this->assertTrue($reflection->hasMethod('execute'));
    }

    public function testPlatformInterfaceHasSqlGenerationMethods(): void
    {
        $reflection = new \ReflectionClass(PlatformInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('getCreateTableSQL'));
        $this->assertTrue($reflection->hasMethod('getAlterTableSQL'));
        $this->assertTrue($reflection->hasMethod('getDropTableSQL'));
    }

    public function testAllConnectionInterfacesExist(): void
    {
        $interfaces = [
            ConnectionInterface::class,
            ResultInterface::class,
            StatementInterface::class,
            PlatformInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
