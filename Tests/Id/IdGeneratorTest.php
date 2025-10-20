<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Id;

use Flaphl\Fridge\Precept\Id\IdentityGenerator;
use Flaphl\Fridge\Precept\Id\SequenceGenerator;
use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use PHPUnit\Framework\TestCase;

class IdentityGeneratorTest extends TestCase
{
    private ConnectionInterface $connection;
    private IdentityGenerator $generator;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(ConnectionInterface::class);
        $this->generator = new IdentityGenerator($this->connection);
    }

    public function testGenerateReturnsLastInsertId(): void
    {
        $this->connection->expects($this->once())
            ->method('lastInsertId')
            ->willReturn('42');

        $entity = new \stdClass();
        $result = $this->generator->generate($entity);

        $this->assertSame(42, $result);
    }

    public function testGenerateConvertsStringToInt(): void
    {
        $this->connection->expects($this->once())
            ->method('lastInsertId')
            ->willReturn('123');

        $entity = new \stdClass();
        $result = $this->generator->generate($entity);

        $this->assertIsInt($result);
        $this->assertSame(123, $result);
    }

    public function testGenerateWithSequenceName(): void
    {
        $generator = new IdentityGenerator($this->connection, 'user_id_seq');

        $this->connection->expects($this->once())
            ->method('lastInsertId')
            ->with('user_id_seq')
            ->willReturn('99');

        $entity = new \stdClass();
        $result = $generator->generate($entity);

        $this->assertSame(99, $result);
    }

    public function testIsPostInsertGenerator(): void
    {
        $this->assertTrue($this->generator->isPostInsertGenerator());
    }
}

class SequenceGeneratorTest extends TestCase
{
    private ConnectionInterface $connection;
    private SequenceGenerator $generator;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(ConnectionInterface::class);
        $this->generator = new SequenceGenerator($this->connection, 'user_id_seq');
    }

    public function testGenerateExecutesSequenceQuery(): void
    {
        $this->connection->expects($this->once())
            ->method('fetchOne')
            ->with("SELECT NEXTVAL('user_id_seq')")
            ->willReturn(42);

        $entity = new \stdClass();
        $result = $this->generator->generate($entity);

        $this->assertSame(42, $result);
    }

    public function testGenerateWithCustomAllocationSize(): void
    {
        $generator = new SequenceGenerator($this->connection, 'user_id_seq', 10);

        $this->connection->expects($this->once())
            ->method('fetchOne')
            ->willReturn(100);

        $entity = new \stdClass();
        $result = $generator->generate($entity);

        $this->assertSame(100, $result);
    }

    public function testIsPostInsertGenerator(): void
    {
        $this->assertFalse($this->generator->isPostInsertGenerator());
    }

    public function testGetSequenceName(): void
    {
        $this->assertSame('user_id_seq', $this->generator->getSequenceName());
    }

    public function testGetAllocationSize(): void
    {
        $generator = new SequenceGenerator($this->connection, 'seq', 20);
        
        $this->assertSame(20, $generator->getAllocationSize());
    }
}
