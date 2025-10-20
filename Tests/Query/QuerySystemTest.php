<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Query;

use Flaphl\Fridge\Precept\AbstractQuery;
use Flaphl\Fridge\Precept\Query;
use Flaphl\Fridge\Precept\Query\Parser;
use Flaphl\Fridge\Precept\Query\ParserResult;
use Flaphl\Fridge\Precept\Query\HydrationMode;
use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Hydration\HydrationInterface;
use PHPUnit\Framework\TestCase;

class AbstractQueryTest extends TestCase
{
    private ConnectionInterface $connection;
    private HydrationInterface $hydrator;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(ConnectionInterface::class);
        $this->hydrator = $this->createMock(HydrationInterface::class);
    }

    public function testSetParameter(): void
    {
        $query = $this->createQuery();
        $result = $query->setParameter('id', 1);
        
        $this->assertSame($query, $result);
        $this->assertSame(1, $query->getParameter('id'));
    }

    public function testSetParameters(): void
    {
        $query = $this->createQuery();
        $query->setParameters(['id' => 1, 'name' => 'test']);
        
        $this->assertSame(1, $query->getParameter('id'));
        $this->assertSame('test', $query->getParameter('name'));
    }

    public function testGetParameters(): void
    {
        $query = $this->createQuery();
        $query->setParameters(['id' => 1, 'name' => 'test']);
        
        $params = $query->getParameters();
        
        $this->assertCount(2, $params);
        $this->assertSame(['id' => 1, 'name' => 'test'], $params);
    }

    public function testSetHydrationMode(): void
    {
        $query = $this->createQuery();
        $result = $query->setHydrationMode(HydrationMode::ARRAY);
        
        $this->assertSame($query, $result);
        $this->assertSame(HydrationMode::ARRAY, $query->getHydrationMode());
    }

    public function testDefaultHydrationMode(): void
    {
        $query = $this->createQuery();
        
        $this->assertSame(HydrationMode::OBJECT, $query->getHydrationMode());
    }

    private function createQuery(): AbstractQuery
    {
        return new class($this->connection, $this->hydrator) extends AbstractQuery {
            public function execute(): mixed
            {
                return null;
            }

            public function getSql(): string
            {
                return 'SELECT * FROM users';
            }
        };
    }
}

class QueryTest extends TestCase
{
    private ConnectionInterface $connection;
    private HydrationInterface $hydrator;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(ConnectionInterface::class);
        $this->hydrator = $this->createMock(HydrationInterface::class);
    }

    public function testGetSql(): void
    {
        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);
        
        $this->assertSame('SELECT * FROM users', $query->getSql());
    }

    public function testExecuteReturnsResults(): void
    {
        $expectedResults = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob']
        ];

        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM users', [])
            ->willReturn($expectedResults);

        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);
        $results = $query->execute();

        $this->assertSame($expectedResults, $results);
    }

    public function testExecuteWithParameters(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM users WHERE id = ?', [1])
            ->willReturn([['id' => 1, 'name' => 'Alice']]);

        $query = new Query($this->connection, 'SELECT * FROM users WHERE id = ?', $this->hydrator);
        $query->setParameter('id', 1);
        
        $results = $query->execute();

        $this->assertCount(1, $results);
    }

    public function testGetSingleResult(): void
    {
        $expectedResult = ['id' => 1, 'name' => 'Alice'];

        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn([$expectedResult]);

        $query = new Query($this->connection, 'SELECT * FROM users WHERE id = 1', $this->hydrator);
        $result = $query->getSingleResult();

        $this->assertSame($expectedResult, $result);
    }

    public function testGetSingleResultThrowsExceptionWhenNoResults(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn([]);

        $query = new Query($this->connection, 'SELECT * FROM users WHERE id = 999', $this->hydrator);

        $this->expectException(\Flaphl\Fridge\Precept\Exception\QueryException::class);
        $query->getSingleResult();
    }

    public function testGetSingleResultThrowsExceptionWhenMultipleResults(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn([
                ['id' => 1, 'name' => 'Alice'],
                ['id' => 2, 'name' => 'Bob']
            ]);

        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);

        $this->expectException(\Flaphl\Fridge\Precept\Exception\QueryException::class);
        $query->getSingleResult();
    }

    public function testGetOneOrNullResult(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn([]);

        $query = new Query($this->connection, 'SELECT * FROM users WHERE id = 999', $this->hydrator);
        $result = $query->getOneOrNullResult();

        $this->assertNull($result);
    }

    public function testGetScalarResult(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn([[42]]);

        $query = new Query($this->connection, 'SELECT COUNT(*) FROM users', $this->hydrator);
        $query->setHydrationMode(HydrationMode::SCALAR);
        $result = $query->getScalarResult();

        $this->assertSame(42, $result);
    }

    public function testHydrationWithObjectMode(): void
    {
        $rawData = [['id' => 1, 'name' => 'Alice']];
        $hydratedObject = (object)['id' => 1, 'name' => 'Alice'];

        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->willReturn($rawData);

        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with($rawData, HydrationMode::OBJECT)
            ->willReturn([$hydratedObject]);

        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);
        $query->setHydrationMode(HydrationMode::OBJECT);
        $results = $query->execute();

        $this->assertCount(1, $results);
        $this->assertIsObject($results[0]);
    }

    public function testSetMaxResults(): void
    {
        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);
        $result = $query->setMaxResults(10);

        $this->assertSame($query, $result);
        $this->assertSame(10, $query->getMaxResults());
    }

    public function testSetFirstResult(): void
    {
        $query = new Query($this->connection, 'SELECT * FROM users', $this->hydrator);
        $result = $query->setFirstResult(20);

        $this->assertSame($query, $result);
        $this->assertSame(20, $query->getFirstResult());
    }
}

class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testParseSimpleQuery(): void
    {
        $dql = 'SELECT u FROM User u';
        $result = $this->parser->parse($dql);

        $this->assertInstanceOf(ParserResult::class, $result);
        $this->assertNotEmpty($result->getSql());
    }

    public function testParseQueryWithWhere(): void
    {
        $dql = 'SELECT u FROM User u WHERE u.id = :id';
        $result = $this->parser->parse($dql);

        $this->assertInstanceOf(ParserResult::class, $result);
        $this->assertStringContainsString('WHERE', $result->getSql());
    }

    public function testParseQueryWithJoin(): void
    {
        $dql = 'SELECT u, p FROM User u JOIN u.posts p';
        $result = $this->parser->parse($dql);

        $this->assertInstanceOf(ParserResult::class, $result);
        $this->assertStringContainsString('JOIN', $result->getSql());
    }

    public function testParseQueryWithOrderBy(): void
    {
        $dql = 'SELECT u FROM User u ORDER BY u.name ASC';
        $result = $this->parser->parse($dql);

        $this->assertInstanceOf(ParserResult::class, $result);
        $this->assertStringContainsString('ORDER BY', $result->getSql());
    }
}

class ParserResultTest extends TestCase
{
    public function testGetSql(): void
    {
        $result = new ParserResult('SELECT * FROM users', []);

        $this->assertSame('SELECT * FROM users', $result->getSql());
    }

    public function testGetParameterMappings(): void
    {
        $mappings = ['id' => 1, 'name' => 2];
        $result = new ParserResult('SELECT * FROM users WHERE id = ? AND name = ?', $mappings);

        $this->assertSame($mappings, $result->getParameterMappings());
    }

    public function testGetResultSetMapping(): void
    {
        $result = new ParserResult('SELECT * FROM users', []);
        $rsm = $result->getResultSetMapping();

        $this->assertIsArray($rsm);
    }
}
